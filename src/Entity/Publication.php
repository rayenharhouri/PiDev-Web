<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublicationRepository::class)
 */
class Publication
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
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_pub;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reactions;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbre_commentaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $topic;

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

    public function getDatePub(): ?\DateTimeInterface
    {
        return $this->date_pub;
    }

    public function setDatePub(?\DateTimeInterface $date_pub): self
    {
        $this->date_pub = $date_pub;

        return $this;
    }

    public function getReactions(): ?int
    {
        return $this->reactions;
    }

    public function setReactions(int $reactions): self
    {
        $this->reactions = $reactions;

        return $this;
    }

    public function getNbreCommentaire(): ?int
    {
        return $this->nbre_commentaire;
    }

    public function setNbreCommentaire(?int $nbre_commentaire): self
    {
        $this->nbre_commentaire = $nbre_commentaire;

        return $this;
    }

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }
}
