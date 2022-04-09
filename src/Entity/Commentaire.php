<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_u;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_pub;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdU(): ?int
    {
        return $this->id_u;
    }

    public function setIdU(int $id_u): self
    {
        $this->id_u = $id_u;

        return $this;
    }

    public function getIdPub(): ?int
    {
        return $this->id_pub;
    }

    public function setIdPub(int $id_pub): self
    {
        $this->id_pub = $id_pub;

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
