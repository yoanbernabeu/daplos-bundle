<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser;

use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;
use YoanBernabeu\DaplosBundle\DTO\Document\DocumentHeader;
use YoanBernabeu\DaplosBundle\DTO\Document\Intervenant;
use YoanBernabeu\DaplosBundle\DTO\Document\TypeAgriculture;
use YoanBernabeu\DaplosBundle\DTO\Interchange\InterchangeHeader;
use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\DTO\Intervention\HistoriqueDecision;
use YoanBernabeu\DaplosBundle\DTO\Intrant\AnalyseEffluent;
use YoanBernabeu\DaplosBundle\DTO\Intrant\CompositionFertilisation;
use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;
use YoanBernabeu\DaplosBundle\DTO\Intrant\LotFabricant;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Amendement;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Analyse;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Engagement;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Historique;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCadastrale;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\SurfaceParcelle;
use YoanBernabeu\DaplosBundle\DTO\Recolte\CaracterisationProduit;
use YoanBernabeu\DaplosBundle\DTO\Recolte\LotRecolte;
use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;
use YoanBernabeu\DaplosBundle\Parser\Context\ParserContext;
use YoanBernabeu\DaplosBundle\Parser\Contract\FileParserInterface;
use YoanBernabeu\DaplosBundle\Parser\Exception\DaplosParseException;
use YoanBernabeu\DaplosBundle\Parser\Exception\InvalidFlagException;
use YoanBernabeu\DaplosBundle\Parser\Reader\FileReader;
use YoanBernabeu\DaplosBundle\Parser\Reader\ReaderInterface;
use YoanBernabeu\DaplosBundle\Parser\Reader\StringReader;
use YoanBernabeu\DaplosBundle\Parser\Registry\LineParserRegistry;

/**
 * Parser principal pour les fichiers DAPLOS.
 *
 * Orchestre les Line Parsers et construit le document complet.
 */
final class DaplosFileParser implements FileParserInterface
{
    public function __construct(
        private readonly LineParserRegistry $registry,
        private readonly string $defaultEncoding = 'auto',
        private readonly bool $ignoreUnknownFlags = false,
    ) {
    }

    public function parseFile(string $filePath): DaplosDocument
    {
        $reader = new FileReader($filePath, $this->defaultEncoding);

        return $this->doParse($reader, $filePath);
    }

    public function parseString(string $content): DaplosDocument
    {
        $reader = new StringReader($content);

        return $this->doParse($reader);
    }

    /**
     * Parse le contenu lu par le reader.
     */
    private function doParse(ReaderInterface $reader, ?string $sourceFile = null): DaplosDocument
    {
        $context = new ParserContext();

        foreach ($reader->readLines() as $lineNumber => $line) {
            // Ignorer les lignes vides
            if ('' === trim($line)) {
                continue;
            }

            $this->parseLine($line, $lineNumber, $context);
        }

        return $this->buildDocument($context, $sourceFile);
    }

    /**
     * Parse une ligne et met a jour le contexte.
     */
    private function parseLine(string $line, int $lineNumber, ParserContext $context): void
    {
        $flag = substr($line, 0, 2);

        if (!$this->registry->has($flag)) {
            if ($this->ignoreUnknownFlags) {
                return;
            }

            throw new InvalidFlagException($flag, $lineNumber, $line);
        }

        $parser = $this->registry->get($flag);

        try {
            $dto = $parser->parse($line, $lineNumber);
            $this->updateContext($context, $flag, $dto, $lineNumber);
        } catch (DaplosParseException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new DaplosParseException(sprintf('Erreur lors du parsing de la ligne : %s', $e->getMessage()), $lineNumber, $line, $e);
        }
    }

    /**
     * Met a jour le contexte avec le DTO parse.
     */
    private function updateContext(ParserContext $context, string $flag, object $dto, int $lineNumber): void
    {
        match ($flag) {
            // En-tetes
            'EI' => $context->setInterchange($dto instanceof InterchangeHeader ? $dto : throw new DaplosParseException('DTO inattendu pour EI', $lineNumber)),
            'DE' => $context->setDocument($dto instanceof DocumentHeader ? $dto : throw new DaplosParseException('DTO inattendu pour DE', $lineNumber)),
            'DA' => $context->addIntervenant($dto instanceof Intervenant ? $dto : throw new DaplosParseException('DTO inattendu pour DA', $lineNumber)),
            'DT' => $context->addTypeAgriculture($dto instanceof TypeAgriculture ? $dto : throw new DaplosParseException('DTO inattendu pour DT', $lineNumber)),

            // Parcelle
            'DP' => $context->addParcelle($dto instanceof ParcelleCulturale ? $dto : throw new DaplosParseException('DTO inattendu pour DP', $lineNumber)),
            'PS' => $context->addSurface($dto instanceof SurfaceParcelle ? $dto : throw new DaplosParseException('DTO inattendu pour PS', $lineNumber)),
            'SC' => $context->addCoordonnee($dto instanceof Coordonnee ? $dto : throw new DaplosParseException('DTO inattendu pour SC', $lineNumber)),
            'PC' => $context->addParcelleCadastrale($dto instanceof ParcelleCadastrale ? $dto : throw new DaplosParseException('DTO inattendu pour PC', $lineNumber)),
            'CC' => $context->addCoordonnee($dto instanceof Coordonnee ? $dto : throw new DaplosParseException('DTO inattendu pour CC', $lineNumber)),
            'PE' => $context->addEngagement($dto instanceof Engagement ? $dto : throw new DaplosParseException('DTO inattendu pour PE', $lineNumber)),
            'PH' => $context->addHistorique($dto instanceof Historique ? $dto : throw new DaplosParseException('DTO inattendu pour PH', $lineNumber)),
            'HA' => $context->addAmendement($dto instanceof Amendement ? $dto : throw new DaplosParseException('DTO inattendu pour HA', $lineNumber)),
            'PA' => $context->addAnalyse($dto instanceof Analyse ? $dto : throw new DaplosParseException('DTO inattendu pour PA', $lineNumber)),

            // Intervention
            'PV' => $context->addEvenement($dto instanceof Evenement ? $dto : throw new DaplosParseException('DTO inattendu pour PV', $lineNumber)),
            'VB' => $context->addCibleEvenement($dto instanceof CibleEvenement ? $dto : throw new DaplosParseException('DTO inattendu pour VB', $lineNumber)),
            'VH' => $context->addHistoriqueDecision($dto instanceof HistoriqueDecision ? $dto : throw new DaplosParseException('DTO inattendu pour VH', $lineNumber)),
            'VC' => $context->addCoordonneeIntervention($dto instanceof Coordonnee ? $dto : throw new DaplosParseException('DTO inattendu pour VC', $lineNumber)),

            // Intrant
            'VI' => $context->addIntrant($dto instanceof Intrant ? $dto : throw new DaplosParseException('DTO inattendu pour VI', $lineNumber)),
            'IC' => $context->addCompositionFertilisation($dto instanceof CompositionFertilisation ? $dto : throw new DaplosParseException('DTO inattendu pour IC', $lineNumber)),
            'IL' => $context->addLotFabricant($dto instanceof LotFabricant ? $dto : throw new DaplosParseException('DTO inattendu pour IL', $lineNumber)),
            'IA' => $context->addAnalyseEffluent($dto instanceof AnalyseEffluent ? $dto : throw new DaplosParseException('DTO inattendu pour IA', $lineNumber)),

            // Recolte
            'VR' => $context->addRecolte($dto instanceof Recolte ? $dto : throw new DaplosParseException('DTO inattendu pour VR', $lineNumber)),
            'RL' => $context->addLotRecolte($dto instanceof LotRecolte ? $dto : throw new DaplosParseException('DTO inattendu pour RL', $lineNumber)),
            'LC' => $context->addCaracterisationProduit($dto instanceof CaracterisationProduit ? $dto : throw new DaplosParseException('DTO inattendu pour LC', $lineNumber)),

            default => null,
        };
    }

    /**
     * Construit le document final a partir du contexte.
     */
    private function buildDocument(ParserContext $context, ?string $sourceFile): DaplosDocument
    {
        return new DaplosDocument(
            interchange: $context->getInterchange(),
            header: $context->getDocument(),
            intervenants: $context->getIntervenants(),
            typesAgriculture: $context->getTypesAgriculture(),
            parcelles: $context->getParcelles(),
            sourceFile: $sourceFile,
        );
    }
}
