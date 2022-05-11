<?php

namespace App\Entity;

class FiltrerProduit
{
    /**
     * @var
     */
    private $typeproduit;

    /**
     * @var
     */
    private $fournisseur;

    /**
     * @return mixed
     */
    public function getTypeproduit()
    {
        return $this->typeproduit;
    }

    /**
     * @param mixed $typeproduit
     */
    public function setTypeproduit($typeproduit): void
    {
        $this->typeproduit = $typeproduit;
    }

    /**
     * @return mixed
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * @param mixed $fournisseur
     */
    public function setFournisseur($fournisseur): void
    {
        $this->fournisseur = $fournisseur;
    }




}