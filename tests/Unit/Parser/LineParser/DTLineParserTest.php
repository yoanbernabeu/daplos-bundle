<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Document\TypeAgriculture;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DTLineParser;

class DTLineParserTest extends TestCase
{
    private DTLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new DTLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('DT', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('DT'));
        $this->assertFalse($this->parser->supports('DA'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG DT p. 12),
     * tous les champs renseignés, positions exactes (longueur totale 45).
     */
    public function testParseFullLine(): void
    {
        $line = 'DT'
            .'ZLC'                                  // 3-5   type d'agriculture pratiquée (an3)
            .str_pad('CERT-2025-000042', 20)        // 6-25  n° de certificat (an20)
            .str_pad('Agriculture de cons.', 20);   // 26-45 autre type d'agriculture (an20)

        $this->assertSame(45, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(TypeAgriculture::class, $result);
        $this->assertSame('ZLC', $result->codeTypeAgriculture);
        $this->assertSame('CERT-2025-000042', $result->numeroCertificat);
        $this->assertSame('Agriculture de cons.', $result->libelle);
    }

    /**
     * Ligne issue d'un fichier réel : « autre type d'agriculture »
     * déborde de la position 45 du guide, lecture jusqu'à la fin de ligne.
     */
    public function testParseRealWorldLineWithOverflow(): void
    {
        $line = 'DTZLC                    Suivi parcellaire (Grandes cultures)';

        $this->assertSame(61, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('ZLC', $result->codeTypeAgriculture);
        $this->assertNull($result->numeroCertificat);
        $this->assertSame('Suivi parcellaire (Grandes cultures)', $result->libelle);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'DTZLC';

        $result = $this->parser->parse($line, 1);

        $this->assertSame('ZLC', $result->codeTypeAgriculture);
        $this->assertNull($result->numeroCertificat);
        $this->assertNull($result->libelle);
    }
}
