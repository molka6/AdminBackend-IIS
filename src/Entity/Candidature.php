<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Repository\CandidatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 *
 *@ApiResource( attributes={ "input_formats"={"multipart" :{"multipart/form-data"}}, "output_formats"={"json"={"application/ld+json"}}, "deserialize"=false, })
 *@ORM\Entity(repositoryClass=CandidatureRepository::class)
 */

class Candidature
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
    * @ORM\Column()
    */
    private $cv;

    /**
     * @ORM\ManyToMany(targetEntity=OffreEmploi::class, mappedBy="condidature" ,cascade={"persist"})
     */
    private $offreEmplois;




    public function __construct()
    {
        $this->offreEmplois = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv( $cv)
    {
        $this->cv = $cv;

        return $this;
    }

    
    /**
     * @return Collection|OffreEmploi[]
     */
    public function getOffreEmplois(): Collection
    {
        return $this->offreEmplois;
    }


    public function addOffreEmploi(OffreEmploi $offreEmploi)
    {
        if (!$this->offreEmplois->contains($offreEmploi)) {
            $this->offreEmplois[] = $offreEmploi;
            $offreEmploi->addCondidature($this);
        }

        return $this;
    }


    public function removeOffreEmploi(OffreEmploi $offreEmploi): self
    {
        if ($this->offreEmplois->removeElement($offreEmploi)) {
            $offreEmploi->removeCondidature($this);
        }

        return $this;
    }


}
