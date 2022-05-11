<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Facture
 *
 * @ORM\Table(name="facture", indexes={@ORM\Index(name="facture_id_commande", columns={"id_commande"})})
 * @ORM\Entity
 */
class Facture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_facture", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *@Groups("facture")
     * @Groups("posts:read")
     */
    private $idFacture;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_livraison", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Adresse est obligatoire")
     *@Groups("facture")
     * @Groups("posts:read")
     */
    private $adressLivraison;

    /**
     * @var int
     *
     * @ORM\Column(name="total_apres_reduction", type="integer", nullable=false)
     * @Assert\Positive
     *@Groups("facture")
     * @Groups("posts:read")
     */
    private $totalApresReduction;

    /**
     *
     * @ORM\Column(name="id_commande", type="integer")
     *@Groups("facture")
     * @Groups("posts:read")
     */
    private $idCommande;

    public function getIdFacture(): ?int
    {
        return $this->idFacture;
    }

    public function getAdressLivraison(): ?string
    {
        return $this->adressLivraison;
    }

    public function setAdressLivraison(string $adressLivraison): self
    {
        $this->adressLivraison = $adressLivraison;

        return $this;
    }

    public function getTotalApresReduction(): ?int
    {
        return $this->totalApresReduction;
    }

    public function setTotalApresReduction(int $totalApresReduction): self
    {
        $this->totalApresReduction = $totalApresReduction;

        return $this;
    }

    public function getIdCommande(): ?int
    {
        return $this->idCommande;
    }

    public function setIdCommande(int $idCommande): self
    {
        $this->idCommande = $idCommande;

        return $this;
    }
}
