<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_pub", type="integer", nullable=false)
     */
    private $idPub;

    /**
     * @var int
     *
     * @ORM\Column(name="id_u", type="integer", nullable=false)
     */
    private $idU;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=false)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPub(): ?int
    {
        return $this->idPub;
    }

    public function setIdPub(int $idPub): self
    {
        $this->idPub = $idPub;

        return $this;
    }

    public function getIdU(): ?int
    {
        return $this->idU;
    }

    public function setIdU(int $idU): self
    {
        $this->idU = $idU;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }


}
