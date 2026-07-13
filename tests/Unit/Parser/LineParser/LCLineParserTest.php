<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Recolte\CaracterisationProduit;
use YoanBernabeu\DaplosBundle\Parser\LineParser\LCLineParser;

class LCLineParserTest extends TestCase
{
    private LCLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new LCLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('LC', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('LC'));
        $this->assertFalse($this->parser->supports('RL'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG LC p. 48),
     * tous les champs renseignés, positions exactes (longueur totale 61).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(61, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(CaracterisationProduit::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-46 : référence de l'événement (GUID)
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $result->refIntervention);
        // Positions 47-49 : type caractéristique (en code)
        $this->assertSame('ZHU', $result->codeCaracteristique);
        // Positions 50-58 : valeur de la caractéristique (9 n)
        $this->assertSame('00014.500', $result->valeur);
        $this->assertSame(14.5, $result->getValeurNumerique());
        // Positions 59-61 : unité de mesure
        $this->assertSame('PCT', $result->codeUnite);
    }

    /**
     * Ligne réaliste : valeur et unité vides.
     */
    public function testParseLineWithOptionalFieldsEmpty(): void
    {
        $line = 'LC000266  202573FF44DFEB25A3CCB28E157FAD771041ZHU'
            .str_repeat(' ', 9)
            .str_repeat(' ', 3);

        $this->assertSame(61, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000266', $result->identifiantParcelle);
        $this->assertSame('ZHU', $result->codeCaracteristique);
        $this->assertNull($result->valeur);
        $this->assertNull($result->getValeurNumerique());
        $this->assertNull($result->codeUnite);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'LC000178  2025A1B2C3D4E5F60718293A4B5C6D7E8F90ZHU';

        $result = $this->parser->parse($line, 1);

        $this->assertSame('ZHU', $result->codeCaracteristique);
        $this->assertNull($result->valeur);
        $this->assertNull($result->codeUnite);
    }

    public function testValeurNumeriqueWithNonNumericValue(): void
    {
        $dto = new CaracterisationProduit(valeur: 'abc');

        $this->assertNull($dto->getValeurNumerique());
    }

    private function buildFullLine(): string
    {
        return 'LC'
            .'0001'                                 // 3-6   n° ordre parcelle
            .'78  '                                 // 7-10  réf parcelle culturale
            .'2025'                                 // 11-14 année
            .'A1B2C3D4E5F60718293A4B5C6D7E8F90'     // 15-46 GUID
            .'ZHU'                                  // 47-49 type caractéristique
            .'00014.500'                            // 50-58 valeur de la caractéristique
            .'PCT';                                 // 59-61 unité de mesure
    }
}
