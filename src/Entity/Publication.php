<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_u", type="integer", nullable=false)
     */
    private $idU;

    /**
     * @var string|null
     *
     * @ORM\Column(name="date_pub", type="string", length=30, nullable=true)
     */
    private $datePub;

    /**
     * @var int|null
     *
     * @ORM\Column(name="reactions", type="integer", nullable=true)
     */
    private $reactions = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbre_commentaires", type="integer", nullable=true)
     */
    private $nbreCommentaires = '0';

    /**
     * @var string
     * @ORM\Column(name="topic", type="string", length=120, nullable=false)
     *  @Assert\NotBlank(message="WRITE SOMETHING ..")
     *  @Assert\Length(
     *      min = 10,
     *      max = 100,
     *      minMessage = "The Topic Description must be at least {{ limit }} characters long",
     *      maxMessage = "The Topic Description cannot be longer than {{ limit }} characters"
     *          )
     */
    private $topic;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="publication")
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }


    
    public function getid(): ?int
    {
        return $this->id;
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

    public function getDatePub(): ?string
    {
        return $this->datePub;
    }

    public function setDatePub(?string $datePub): self
    {
        $this->datePub = $datePub;

        return $this;
    }

    public function getReactions(): ?int
    {
        return $this->reactions;
    }

    public function setReactions(?int $reactions): self
    {
        $this->reactions = $reactions;

        return $this;
    }

    public function getNbreCommentaires(): ?int
    {
        return $this->nbreCommentaires;
    }

    public function setNbreCommentaires(?int $nbreCommentaires): self
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

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setPublication($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPublication() === $this) {
                $commentaire->setPublication(null);
            }
        }

        return $this;
    }







}
