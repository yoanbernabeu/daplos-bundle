<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intrant\CompositionFertilisation;
use YoanBernabeu\DaplosBundle\Parser\LineParser\ICLineParser;

class ICLineParserTest extends TestCase
{
    private ICLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new ICLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('IC', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('IC'));
        $this->assertFalse($this->parser->supports('IL'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG IC p. 41-42),
     * tous les champs renseignés, positions exactes (longueur totale 58).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(58, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(CompositionFertilisation::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-46 : référence de l'événement (GUID)
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $result->refIntervention);
        // Positions 47-49 : code du composant (nomenclature Teneur en composé chimique)
        $this->assertSame('NT', $result->codeElement);
        // Positions 50-58 : teneur (n 9)
        $this->assertSame(0.25, $result->teneur);
        // Champ hors guide, plus jamais rempli
        $this->assertNull($result->indexElement);
    }

    /**
     * Ligne issue d'un fichier réel (longueur 58).
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'IC000266  20258C333EDE3EB064E5D4BE832B4F168870MT 000000.25';

        $this->assertSame(58, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000266', $result->identifiantParcelle);
        $this->assertSame(2025, $result->annee);
        $this->assertSame('8C333EDE3EB064E5D4BE832B4F168870', $result->refIntervention);
        $this->assertSame('MT', $result->codeElement);
        $this->assertSame(0.25, $result->teneur);
        $this->assertNull($result->indexElement);
    }

    /**
     * La teneur est lue telle quelle, sans heuristique de division par 100 :
     * une solution azotée 39 doit rendre 39 (guide p. 41-42, règle de gestion).
     */
    public function testParseTeneurSolutionAzotee(): void
    {
        $line = 'IC000266  20258C333EDE3EB064E5D4BE832B4F168870NT 000000039';

        $result = $this->parser->parse($line, 1);

        $this->assertSame(39.0, $result->teneur);
    }

    /**
     * Une teneur égale à zéro est une valeur légitime du guide (« indiquez 0 »).
     */
    public function testParseTeneurZero(): void
    {
        $line = 'IC000266  20258C333EDE3EB064E5D4BE832B4F168870NT 000000000';

        $result = $this->parser->parse($line, 1);

        $this->assertSame(0.0, $result->teneur);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        // Ligne s'arrêtant au code du composant (position 49)
        $line = 'IC000178  2025A1B2C3D4E5F60718293A4B5C6D7E8F90PT';

        $result = $this->parser->parse($line, 1);

        $this->assertSame('PT', $result->codeElement);
        $this->assertNull($result->teneur);
    }

    private function buildFullLine(): string
    {
        return 'IC'
            .'0001'                              // 3-6   n° ordre parcelle
            .'78  '                              // 7-10  réf parcelle culturale
            .'2025'                              // 11-14 année
            .'A1B2C3D4E5F60718293A4B5C6D7E8F90'  // 15-46 GUID
            .'NT '                               // 47-49 code du composant
            .'000000.25';                        // 50-58 teneur (9 car.)
    }
}
