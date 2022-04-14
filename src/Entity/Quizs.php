<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Quizs
 *
 * @ORM\Table(name="quizs")
 * @ORM\Entity
 */
class Quizs
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_quizs", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idQuizs;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=250, nullable=false)
         * @Assert\NotBlank(message="Image est obligatoire")

     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="matiere", type="string", length=30, nullable=false)
         * @Assert\NotBlank(message="Matiere est obligatoire")

     */
    private $matiere;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulte", type="string", length=30, nullable=false)
              * @Assert\NotBlank(message="Difficulté est obligatoire")

     */
    private $difficulte;

    /**
     * @var int
     *
     * @ORM\Column(name="resultat", type="integer", nullable=false)
                   * @Assert\NotBlank(message="Resultat est obligatoire")

     */
    private $resultat;

    public function getIdQuizs(): ?int
    {
        return $this->idQuizs;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(string $image)
    {
        $this->image = $image;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getDifficulte(): ?string
    {
        return $this->difficulte;
    }

    public function setDifficulte(string $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getResultat(): ?int
    {
        return $this->resultat;
    }

    public function setResultat(int $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }


}
