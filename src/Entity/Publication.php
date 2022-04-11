<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication")
 * @ORM\Entity
 */
class Publication
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pub", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPub;

    /**
     * @var int
     *
     * @ORM\Column(name="id_u", type="integer", nullable=false)
     */
    private $idU;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_pub", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datePub = 'CURRENT_TIMESTAMP';

    /**
     * @var int
     *
     * @ORM\Column(name="reactions", type="integer", nullable=false)
     */
    private $reactions;

    /**
     * @var int
     *
     * @ORM\Column(name="nbre_commentaires", type="integer", nullable=false)
     */
    private $nbreCommentaires;

    /**
     * @var string
     *
     * @ORM\Column(name="topic", type="string", length=120, nullable=false)
     */
    private $topic;

    public function getIdPub(): ?int
    {
        return $this->idPub;
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

    public function getDatePub(): ?\DateTimeInterface
    {
        return $this->datePub;
    }

    public function setDatePub(\DateTimeInterface $datePub): self
    {
        $this->datePub = $datePub;

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

    public function getNbreCommentaires(): ?int
    {
        return $this->nbreCommentaires;
    }

    public function setNbreCommentaires(int $nbreCommentaires): self
    {
        $this->nbreCommentaires = $nbreCommentaires;

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
