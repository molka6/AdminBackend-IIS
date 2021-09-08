<?php

namespace App\Entity;

use App\Repository\OffreEmploiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(formats="json")
 * @ORM\Entity(repositoryClass=OffreEmploiRepository::class)
 */
class OffreEmploi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $DateAjout;

    /**
     * @ORM\ManyToMany(targetEntity=Candidature::class, inversedBy="offreEmplois")
     */
    private $condidature;








    public function __construct()
    {
        $this->condidature = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateAjout(): ?string
    {
        return $this->DateAjout;
    }

    public function setDateAjout(string $DateAjout): self
    {
        $this->DateAjout = $DateAjout;

        return $this;
    }


    
    public function toArray()
        {
            return [
                'id' => $this->getId(),
                'title' => $this->getTitre(),
                'Description' => $this->getDescription(),
                'DateAjout' => $this->getDateAjout(),
                
            ];
        }

    /**
     * @return Collection|Candidature[]
     */
    public function getCondidature(): Collection
    {
        return $this->condidature;
    }

    public function addCondidature(Candidature $condidature): self
    {
        if (!$this->condidature->contains($condidature)) {
            $this->condidature[] = $condidature;
        }

        return $this;
    }

    public function removeCondidature(Candidature $condidature): self
    {
        $this->condidature->removeElement($condidature);

        return $this;
    }
}
