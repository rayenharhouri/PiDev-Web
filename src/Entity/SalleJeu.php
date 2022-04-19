<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SalleJeu
 *
 * @ORM\Table(name="salle_jeu", indexes={@ORM\Index(name="id_tournementP_fr", columns={"id_tournementP"})})
 * @ORM\Entity
 */
class SalleJeu
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_salleJ", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSallej;

    /**
     * @var int
     * @Assert\NotBlank(message="le nom de salle est obligatoire")
     * @ORM\Column(name="nomSalleJ", type="integer", nullable=false)
     */
    private $nomsallej;

    /**
     * @var int
     * @Assert\NotBlank(message="id Tournoi est obligatoire")
     * @ORM\Column(name="id_tournementP", type="integer", nullable=false)
     */
    private $idTournementp;

    public function getIdSallej(): ?int
    {
        return $this->idSallej;
    }

    public function getNomsallej(): ?int
    {
        return $this->nomsallej;
    }

    public function setNomsallej(int $nomsallej): self
    {
        $this->nomsallej = $nomsallej;

        return $this;
    }

    public function getIdTournementp(): ?int
    {
        return $this->idTournementp;
    }

    public function setIdTournementp(int $idTournementp): self
    {
        $this->idTournementp = $idTournementp;

        return $this;
    }


}
