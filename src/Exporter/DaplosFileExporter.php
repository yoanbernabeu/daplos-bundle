<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter;

use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;
use YoanBernabeu\DaplosBundle\Exporter\Contract\FileExporterInterface;
use YoanBernabeu\DaplosBundle\Exporter\Exception\DaplosExportException;
use YoanBernabeu\DaplosBundle\Exporter\Registry\LineWriterRegistry;

/**
 * Exporter principal pour les fichiers DAPLOS.
 *
 * Orchestre les Line Writers et produit le fichier a plat complet,
 * symetrique du DaplosFileParser : parse(export($document)) redonne
 * un document equivalent.
 */
final class DaplosFileExporter implements FileExporterInterface
{
    private const LINE_ENDING = "\r\n";

    public function __construct(
        private readonly LineWriterRegistry $registry,
        private readonly string $encoding = 'ISO-8859-1',
    ) {
    }

    public function exportToString(DaplosDocument $document): string
    {
        $lines = [];

        if (null !== $document->interchange) {
            $lines[] = $this->registry->get('EI')->write($document->interchange);
        }

        if (null !== $document->header) {
            $lines[] = $this->registry->get('DE')->write($document->header);
        }

        foreach ($document->intervenants as $intervenant) {
            $lines[] = $this->registry->get('DA')->write($intervenant);
        }

        foreach ($document->typesAgriculture as $typeAgriculture) {
            $lines[] = $this->registry->get('DT')->write($typeAgriculture);
        }

        foreach ($document->parcelles as $parcelle) {
            $this->writeParcelle($parcelle, $lines);
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

    public function exportToFile(DaplosDocument $document, string $filePath): void
    {
        $content = $this->exportToString($document);

        $result = @file_put_contents($filePath, $content);
        if (false === $result) {
            throw new DaplosExportException(sprintf('Impossible d\'ecrire le fichier DAPLOS "%s"', $filePath));
        }
    }

    /**
     * Ecrit une parcelle culturale et toutes ses lignes filles,
     * dans l'ordre des FLAGS du guide v0.95.
     *
     * @param array<string> $lines
     */
    private function writeParcelle(ParcelleCulturale $parcelle, array &$lines): void
    {
        $lines[] = $this->registry->get('DP')->write($parcelle);

        foreach ($parcelle->getSurfaces() as $surface) {
            $lines[] = $this->registry->get('PS')->write($surface);
            foreach ($surface->getCoordonnees() as $coordonnee) {
                $lines[] = $this->registry->get('SC')->write($coordonnee);
            }
        }

        foreach ($parcelle->getParcellesCadastrales() as $parcelleCadastrale) {
            $lines[] = $this->registry->get('PC')->write($parcelleCadastrale);
            foreach ($parcelleCadastrale->getCoordonnees() as $coordonnee) {
                $lines[] = $this->registry->get('CC')->write($coordonnee);
            }
        }

        foreach ($parcelle->getEngagements() as $engagement) {
            $lines[] = $this->registry->get('PE')->write($engagement);
        }

        foreach ($parcelle->getHistoriques() as $historique) {
            $lines[] = $this->registry->get('PH')->write($historique);
            foreach ($historique->getAmendements() as $amendement) {
                $lines[] = $this->registry->get('HA')->write($amendement);
            }
        }

        foreach ($parcelle->getAnalyses() as $analyse) {
            $lines[] = $this->registry->get('PA')->write($analyse);
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
        $lines[] = $this->registry->get('PV')->write($evenement);

        foreach ($evenement->getCibles() as $cible) {
            $lines[] = $this->registry->get('VB')->write($cible);
        }

        $historiqueDecision = $evenement->getHistoriqueDecision();
        if (null !== $historiqueDecision) {
            $lines[] = $this->registry->get('VH')->write($historiqueDecision);
        }

        foreach ($evenement->getCoordonnees() as $coordonnee) {
            $lines[] = $this->registry->get('VC')->write($coordonnee);
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
        $lines[] = $this->registry->get('VI')->write($intrant);

        foreach ($intrant->getCompositions() as $composition) {
            $lines[] = $this->registry->get('IC')->write($composition);
        }

        foreach ($intrant->getLots() as $lot) {
            $lines[] = $this->registry->get('IL')->write($lot);
        }

        foreach ($intrant->getAnalysesEffluent() as $analyseEffluent) {
            $lines[] = $this->registry->get('IA')->write($analyseEffluent);
        }
    }

    /**
     * Ecrit une recolte et toutes ses lignes filles.
     *
     * @param array<string> $lines
     */
    private function writeRecolte(Recolte $recolte, array &$lines): void
    {
        $lines[] = $this->registry->get('VR')->write($recolte);

        foreach ($recolte->getLots() as $lot) {
            $lines[] = $this->registry->get('RL')->write($lot);
        }

        foreach ($recolte->getCaracterisations() as $caracterisation) {
            $lines[] = $this->registry->get('LC')->write($caracterisation);
        }
    }
}
