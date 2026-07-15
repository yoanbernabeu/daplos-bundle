<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\Exporter\Contract\LineWriterInterface;
use YoanBernabeu\DaplosBundle\Exporter\Exception\DaplosExportException;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Classe abstraite pour les writers de ligne DAPLOS.
 *
 * Fournit le squelette d'ecriture a positions fixes via LineBuffer.
 * Utilise le pattern Template Method, symetrique d'AbstractLineParser.
 */
abstract class AbstractLineWriter implements LineWriterInterface
{
    /**
     * Template Method : squelette de l'algorithme d'ecriture.
     */
    final public function write(object $dto): string
    {
        $buffer = new LineBuffer($this->getFlag());
        $this->fillBuffer($buffer, $dto);

        return $buffer->toString();
    }

    /**
     * Hook method : remplissage des champs specifiques au FLAG.
     */
    abstract protected function fillBuffer(LineBuffer $buffer, object $dto): void;

    /**
     * Valide le type du DTO recu.
     *
     * @template T of object
     *
     * @param class-string<T> $expectedClass
     *
     * @return T
     *
     * @throws DaplosExportException Si le DTO n'est pas du type attendu
     */
    protected function assertDtoType(object $dto, string $expectedClass): object
    {
        if (!$dto instanceof $expectedClass) {
            throw new DaplosExportException(sprintf('DTO inattendu pour le FLAG %s : %s attendu, %s recu', $this->getFlag(), $expectedClass, $dto::class));
        }

        return $dto;
    }
}
