<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Espèce botanique d’une culture"
 *
 * Repository Code: List_BotanicalSpecies_CodeType
 * Référentiel ID: 611
 * Nombre d'items: 716
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété especeBotaniqueDUneCultureId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $especeBotaniqueDUneCultureId = null;
 */
trait EspeceBotaniqueDUneCultureTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $especeBotaniqueDUneCultureId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $especeBotaniqueDUneCultureTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $especeBotaniqueDUneCultureReferenceCode = null;

    public function getEspeceBotaniqueDUneCultureId(): ?int
    {
        return $this->especeBotaniqueDUneCultureId;
    }

    public function setEspeceBotaniqueDUneCultureId(?int $especeBotaniqueDUneCultureId): self
    {
        $this->especeBotaniqueDUneCultureId = $especeBotaniqueDUneCultureId;
        return $this;
    }

    public function getEspeceBotaniqueDUneCultureTitle(): ?string
    {
        return $this->especeBotaniqueDUneCultureTitle;
    }

    public function setEspeceBotaniqueDUneCultureTitle(?string $especeBotaniqueDUneCultureTitle): self
    {
        $this->especeBotaniqueDUneCultureTitle = $especeBotaniqueDUneCultureTitle;
        return $this;
    }

    public function getEspeceBotaniqueDUneCultureReferenceCode(): ?string
    {
        return $this->especeBotaniqueDUneCultureReferenceCode;
    }

    public function setEspeceBotaniqueDUneCultureReferenceCode(?string $especeBotaniqueDUneCultureReferenceCode): self
    {
        $this->especeBotaniqueDUneCultureReferenceCode = $especeBotaniqueDUneCultureReferenceCode;
        return $this;
    }
}
