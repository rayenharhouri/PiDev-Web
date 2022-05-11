<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tournoi
 *
 * @ORM\Table(name="tournoi")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TournoiRepo")
 */
class Tournoi
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tournoi", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTournoi;

    /**
     * @var int
     * @Assert\NotBlank(message="nombre_equipe est obligatoire")
     * @ORM\Column(name="nombre_equipe", type="integer", nullable=false)
     */
    private $nombreEquipe;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="Date est obligatoire")
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     * @Assert\NotBlank(message="type_jeu est obligatoire")
     * @ORM\Column(name="type_jeu", type="string", length=10, nullable=false)
     */
    private $typeJeu;

    /**
     * @var string
     * @Assert\NotBlank(message="prix est obligatoire")
     * @ORM\Column(name="prix", type="string", length=10, nullable=false)
     */
    private $prix;

    public function getIdTournoi(): ?int
    {
        return $this->idTournoi;
    }

    public function getNombreEquipe(): ?int
    {
        return $this->nombreEquipe;
    }

    public function setNombreEquipe(int $nombreEquipe): self
    {
        $this->nombreEquipe = $nombreEquipe;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTypeJeu(): ?string
    {
        return $this->typeJeu;
    }

    public function setTypeJeu(string $typeJeu): self
    {
        $this->typeJeu = $typeJeu;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }


}
