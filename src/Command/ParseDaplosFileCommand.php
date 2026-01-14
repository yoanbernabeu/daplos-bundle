<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use YoanBernabeu\DaplosBundle\Parser\Contract\FileParserInterface;
use YoanBernabeu\DaplosBundle\Parser\Exception\DaplosParseException;

/**
 * Commande pour parser un fichier DAPLOS.
 */
#[AsCommand(
    name: 'daplos:parse',
    description: 'Parse un fichier DAPLOS (.dap) et affiche son contenu',
)]
final class ParseDaplosFileCommand extends Command
{
    public function __construct(
        private readonly FileParserInterface $parser,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Chemin du fichier DAPLOS (.dap)')
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'Format de sortie (table, json)', 'table')
            ->addOption('summary', 's', InputOption::VALUE_NONE, 'Afficher uniquement un résumé')
            ->addOption('parcelles', 'p', InputOption::VALUE_NONE, 'Afficher les détails des parcelles')
            ->addOption('interventions', 'i', InputOption::VALUE_NONE, 'Afficher les détails des interventions')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = $input->getArgument('file');
        $format = $input->getOption('format');
        $showSummary = $input->getOption('summary');
        $showParcelles = $input->getOption('parcelles');
        $showInterventions = $input->getOption('interventions');

        // Vérification du fichier
        if (!file_exists($filePath)) {
            $io->error(sprintf('Fichier introuvable : %s', $filePath));

            return Command::FAILURE;
        }

        $io->title('Parsing du fichier DAPLOS');
        $io->text(sprintf('Fichier : %s', $filePath));
        $io->newLine();

        try {
            $document = $this->parser->parseFile($filePath);
        } catch (DaplosParseException $e) {
            $io->error(sprintf('Erreur de parsing : %s', $e->getMessage()));
            if (null !== $e->getLineNumber()) {
                $io->text(sprintf('Ligne %d : %s', $e->getLineNumber(), $e->getLineContent() ?? ''));
            }

            return Command::FAILURE;
        }

        if ('json' === $format) {
            $this->outputJson($io, $document);

            return Command::SUCCESS;
        }

        // Affichage en mode table
        $this->outputSummary($io, $document);

        if ($showParcelles || (!$showSummary && !$showInterventions)) {
            $this->outputParcelles($io, $document);
        }

        if ($showInterventions) {
            $this->outputInterventions($io, $document);
        }

        return Command::SUCCESS;
    }

    private function outputSummary(SymfonyStyle $io, \YoanBernabeu\DaplosBundle\DTO\DaplosDocument $document): void
    {
        $io->section('Résumé');

        $rows = [
            ['Version DAPLOS', $document->getVersion() ?? '-'],
            ['Nombre de parcelles', $document->countParcelles()],
            ['Nombre d\'interventions', $document->countInterventions()],
        ];

        // Exploitant
        $exploitant = $document->getExploitant();
        if (null !== $exploitant) {
            $rows[] = ['Exploitant', $exploitant->raisonSociale1 ?? '-'];
            $rows[] = ['SIRET', $exploitant->identification ?? '-'];
            $rows[] = ['Commune', sprintf('%s %s', $exploitant->codePostal ?? '', $exploitant->ville ?? '')];
        }

        $io->table(['Propriété', 'Valeur'], $rows);
    }

    private function outputParcelles(SymfonyStyle $io, \YoanBernabeu\DaplosBundle\DTO\DaplosDocument $document): void
    {
        $io->section('Parcelles');

        if (0 === count($document->parcelles)) {
            $io->text('Aucune parcelle trouvée.');

            return;
        }

        $rows = [];
        foreach ($document->parcelles as $parcelle) {
            $rows[] = [
                $parcelle->identifiant ?? '-',
                $parcelle->nom ?? '-',
                $parcelle->codeEspeceBotanique ?? '-',
                $parcelle->annee ?? '-',
                $this->formatSurface($parcelle),
                count($parcelle->getEvenements()),
            ];
        }

        $io->table(
            ['ID', 'Nom', 'Espèce', 'Année', 'Surface', 'Interventions'],
            $rows
        );
    }

    private function outputInterventions(SymfonyStyle $io, \YoanBernabeu\DaplosBundle\DTO\DaplosDocument $document): void
    {
        $io->section('Interventions');

        $rows = [];
        foreach ($document->parcelles as $parcelle) {
            foreach ($parcelle->getEvenements() as $evenement) {
                $rows[] = [
                    $parcelle->identifiant ?? '-',
                    $evenement->codeIntervention ?? '-',
                    mb_substr($evenement->libelleIntervention ?? '-', 0, 30),
                    $evenement->dateDebutIntervention?->format('d/m/Y') ?? '-',
                    count($evenement->getIntrants()),
                ];
            }
        }

        if (0 === count($rows)) {
            $io->text('Aucune intervention trouvée.');

            return;
        }

        $io->table(
            ['Parcelle', 'Code', 'Libellé', 'Date', 'Intrants'],
            $rows
        );
    }

    private function outputJson(SymfonyStyle $io, \YoanBernabeu\DaplosBundle\DTO\DaplosDocument $document): void
    {
        $data = [
            'version' => $document->getVersion(),
            'parcelles_count' => $document->countParcelles(),
            'interventions_count' => $document->countInterventions(),
            'exploitant' => null,
            'parcelles' => [],
        ];

        $exploitant = $document->getExploitant();
        if (null !== $exploitant) {
            $data['exploitant'] = [
                'raison_sociale' => $exploitant->raisonSociale1,
                'siret' => $exploitant->identification,
                'ville' => $exploitant->ville,
                'code_postal' => $exploitant->codePostal,
            ];
        }

        foreach ($document->parcelles as $parcelle) {
            $parcelleData = [
                'identifiant' => $parcelle->identifiant,
                'nom' => $parcelle->nom,
                'annee' => $parcelle->annee,
                'espece_botanique' => $parcelle->codeEspeceBotanique,
                'interventions' => [],
            ];

            foreach ($parcelle->getEvenements() as $evenement) {
                $parcelleData['interventions'][] = [
                    'code' => $evenement->codeIntervention,
                    'libelle' => $evenement->libelleIntervention,
                    'date_debut' => $evenement->dateDebutIntervention?->format('Y-m-d'),
                    'intrants_count' => count($evenement->getIntrants()),
                ];
            }

            $data['parcelles'][] = $parcelleData;
        }

        $io->writeln(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    private function formatSurface(\YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale $parcelle): string
    {
        $surfaces = $parcelle->getSurfaces();
        if (0 === count($surfaces)) {
            return null !== $parcelle->surface ? sprintf('%.2f', $parcelle->surface) : '-';
        }

        // Prendre la première surface (généralement A17 = surface graphique)
        $surface = $surfaces[0];

        return sprintf('%.2f %s', $surface->surface ?? 0, $surface->typeSurface ?? '');
    }
}
