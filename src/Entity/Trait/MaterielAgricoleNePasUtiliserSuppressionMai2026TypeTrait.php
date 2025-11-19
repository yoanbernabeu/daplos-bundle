<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Matériel Agricole (Type) - Ne pas utiliser - Suppression Mai 2026"
 *
 * Repository Code: List_AgriculturalEquipment_CodeType
 * Référentiel ID: 693
 * Nombre d'items: 222
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété materielAgricoleNePasUtiliserSuppressionMai2026TypeId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $materielAgricoleNePasUtiliserSuppressionMai2026TypeId = null;
 */
trait MaterielAgricoleNePasUtiliserSuppressionMai2026TypeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $materielAgricoleNePasUtiliserSuppressionMai2026TypeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $materielAgricoleNePasUtiliserSuppressionMai2026TypeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $materielAgricoleNePasUtiliserSuppressionMai2026TypeReferenceCode = null;

    public function getMaterielAgricoleNePasUtiliserSuppressionMai2026TypeId(): ?int
    {
        return $this->materielAgricoleNePasUtiliserSuppressionMai2026TypeId;
    }

    public function setMaterielAgricoleNePasUtiliserSuppressionMai2026TypeId(?int $materielAgricoleNePasUtiliserSuppressionMai2026TypeId): self
    {
        $this->materielAgricoleNePasUtiliserSuppressionMai2026TypeId = $materielAgricoleNePasUtiliserSuppressionMai2026TypeId;
        return $this;
    }

    public function getMaterielAgricoleNePasUtiliserSuppressionMai2026TypeTitle(): ?string
    {
        return $this->materielAgricoleNePasUtiliserSuppressionMai2026TypeTitle;
    }

    public function setMaterielAgricoleNePasUtiliserSuppressionMai2026TypeTitle(?string $materielAgricoleNePasUtiliserSuppressionMai2026TypeTitle): self
    {
        $this->materielAgricoleNePasUtiliserSuppressionMai2026TypeTitle = $materielAgricoleNePasUtiliserSuppressionMai2026TypeTitle;
        return $this;
    }

    public function getMaterielAgricoleNePasUtiliserSuppressionMai2026TypeReferenceCode(): ?string
    {
        return $this->materielAgricoleNePasUtiliserSuppressionMai2026TypeReferenceCode;
    }

    public function setMaterielAgricoleNePasUtiliserSuppressionMai2026TypeReferenceCode(?string $materielAgricoleNePasUtiliserSuppressionMai2026TypeReferenceCode): self
    {
        $this->materielAgricoleNePasUtiliserSuppressionMai2026TypeReferenceCode = $materielAgricoleNePasUtiliserSuppressionMai2026TypeReferenceCode;
        return $this;
    }
}
