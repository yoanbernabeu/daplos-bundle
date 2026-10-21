<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter;

use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;
use YoanBernabeu\DaplosBundle\Exporter\Contract\FileExporterInterface;
use YoanBernabeu\DaplosBundle\Exporter\Contract\TruncationAwareInterface;
use YoanBernabeu\DaplosBundle\Exporter\Exception\DaplosExportException;
use YoanBernabeu\DaplosBundle\Exporter\Registry\LineWriterRegistry;

/**
 * Exporter principal pour les fichiers DAPLOS.
 *
 * Orchestre les Line Writers et produit le fichier a plat complet,
 * symetrique du DaplosFileParser : parse(export($document)) redonne
 * un document equivalent tant qu'aucune valeur n'est tronquee.
 *
 * Les valeurs texte plus longues que leur champ sont coupees et signalees :
 * getTruncations() les liste apres chaque export ; en mode strict
 * ($failOnTruncation), l'export leve une DaplosExportException.
 */
final class DaplosFileExporter implements FileExporterInterface, TruncationAwareInterface
{
    private const LINE_ENDING = "\r\n";

    /** Nombre maximal de troncatures detaillees dans le message d'exception */
    private const MAX_TRUNCATIONS_IN_MESSAGE = 10;

    /** @var list<ExportTruncation> */
    private array $truncations = [];

    public function __construct(
        private readonly LineWriterRegistry $registry,
        private readonly string $encoding = 'ISO-8859-1',
        private readonly bool $failOnTruncation = false,
    ) {
    }

    /**
     * @throws DaplosExportException En mode strict, si une valeur texte a ete tronquee
     */
    public function exportToString(DaplosDocument $document): string
    {
        $lines = [];
        $this->truncations = [];

        if (null !== $document->interchange) {
            $this->writeLine('EI', $document->interchange, $lines);
        }

        if (null !== $document->header) {
            $this->writeLine('DE', $document->header, $lines);
        }

        foreach ($document->intervenants as $intervenant) {
            $this->writeLine('DA', $intervenant, $lines);
        }

        foreach ($document->typesAgriculture as $typeAgriculture) {
            $this->writeLine('DT', $typeAgriculture, $lines);
        }

        foreach ($document->parcelles as $parcelle) {
            $this->writeParcelle($parcelle, $lines);
        }

        if ($this->failOnTruncation && [] !== $this->truncations) {
            throw new DaplosExportException($this->truncationMessage());
        }

        if ([] === $lines) {
            return '';
        }

        $content = implode(self::LINE_ENDING, $lines).self::LINE_ENDING;

        if ('ISO-8859-1' !== $this->encoding) {
            $content = mb_convert_encoding($content, $this->encoding, 'ISO-8859-1');
        }

        return $content;
    }

    /**
     * Valeurs texte tronquees lors du dernier export, dans l'ordre du fichier.
     *
     * @return list<ExportTruncation>
     */
    public function getTruncations(): array
    {
        return $this->truncations;
    }

    /**
     * @throws DaplosExportException En mode strict, si une valeur texte a ete tronquee
     */
    public function exportToFile(DaplosDocument $document, string $filePath): void
    {
        $content = $this->exportToString($document);

        $result = @file_put_contents($filePath, $content);
        if (false === $result) {
            throw new DaplosExportException(sprintf('Impossible d\'ecrire le fichier DAPLOS "%s"', $filePath));
        }
    }

    /**
     * Ecrit une ligne et collecte ses troncatures avec leur numero de ligne.
     *
     * @param array<string> $lines
     */
    private function writeLine(string $flag, object $dto, array &$lines): void
    {
        $writer = $this->registry->get($flag);
        $lines[] = $writer->write($dto);

        if ($writer instanceof TruncationAwareInterface) {
            foreach ($writer->getTruncations() as $truncation) {
                $this->truncations[] = $truncation->withLineNumber(\count($lines));
            }
        }
    }

    private function truncationMessage(): string
    {
        $details = array_map(
            static fn (ExportTruncation $truncation): string => $truncation->getMessage(),
            \array_slice($this->truncations, 0, self::MAX_TRUNCATIONS_IN_MESSAGE),
        );
        $remaining = \count($this->truncations) - \count($details);

        return sprintf(
            '%d valeur(s) texte trop longue(s) pour leur champ DAPLOS : %s%s',
            \count($this->truncations),
            implode(' ; ', $details),
            $remaining > 0 ? sprintf(' ; et %d autre(s)', $remaining) : '',
        );
    }

    /**
     * Ecrit une parcelle culturale et toutes ses lignes filles,
     * dans l'ordre des FLAGS du guide v0.95.
     *
     * @param array<string> $lines
     */
    private function writeParcelle(ParcelleCulturale $parcelle, array &$lines): void
    {
        $this->writeLine('DP', $parcelle, $lines);

        foreach ($parcelle->getSurfaces() as $surface) {
            $this->writeLine('PS', $surface, $lines);
            foreach ($surface->getCoordonnees() as $coordonnee) {
                $this->writeLine('SC', $coordonnee, $lines);
            }
        }

        foreach ($parcelle->getParcellesCadastrales() as $parcelleCadastrale) {
            $this->writeLine('PC', $parcelleCadastrale, $lines);
            foreach ($parcelleCadastrale->getCoordonnees() as $coordonnee) {
                $this->writeLine('CC', $coordonnee, $lines);
            }
        }

        foreach ($parcelle->getEngagements() as $engagement) {
            $this->writeLine('PE', $engagement, $lines);
        }

        foreach ($parcelle->getHistoriques() as $historique) {
            $this->writeLine('PH', $historique, $lines);
            foreach ($historique->getAmendements() as $amendement) {
                $this->writeLine('HA', $amendement, $lines);
            }
        }

        foreach ($parcelle->getAnalyses() as $analyse) {
            $this->writeLine('PA', $analyse, $lines);
        }

        foreach ($parcelle->getEvenements() as $evenement) {
            $this->writeEvenement($evenement, $lines);
        }
    }

    /**
     * Ecrit un evenement (intervention) et toutes ses lignes filles.
     *
     * @param array<string> $lines
     */
    private function writeEvenement(Evenement $evenement, array &$lines): void
    {
        $this->writeLine('PV', $evenement, $lines);

        foreach ($evenement->getCibles() as $cible) {
            $this->writeLine('VB', $cible, $lines);
        }

        $historiqueDecision = $evenement->getHistoriqueDecision();
        if (null !== $historiqueDecision) {
            $this->writeLine('VH', $historiqueDecision, $lines);
        }

        foreach ($evenement->getCoordonnees() as $coordonnee) {
            $this->writeLine('VC', $coordonnee, $lines);
        }

        foreach ($evenement->getIntrants() as $intrant) {
            $this->writeIntrant($intrant, $lines);
        }

        foreach ($evenement->getRecoltes() as $recolte) {
            $this->writeRecolte($recolte, $lines);
        }
    }

    /**
     * Ecrit un intrant et toutes ses lignes filles.
     *
     * @param array<string> $lines
     */
    private function writeIntrant(Intrant $intrant, array &$lines): void
    {
        $this->writeLine('VI', $intrant, $lines);

        foreach ($intrant->getCompositions() as $composition) {
            $this->writeLine('IC', $composition, $lines);
        }

        foreach ($intrant->getLots() as $lot) {
            $this->writeLine('IL', $lot, $lines);
        }

        foreach ($intrant->getAnalysesEffluent() as $analyseEffluent) {
            $this->writeLine('IA', $analyseEffluent, $lines);
        }
    }

    /**
     * Ecrit une recolte et toutes ses lignes filles.
     *
     * @param array<string> $lines
     */
    private function writeRecolte(Recolte $recolte, array &$lines): void
    {
        $this->writeLine('VR', $recolte, $lines);

        foreach ($recolte->getLots() as $lot) {
            $this->writeLine('RL', $lot, $lines);
        }

        foreach ($recolte->getCaracterisations() as $caracterisation) {
            $this->writeLine('LC', $caracterisation, $lines);
        }
    }
}
