<?php

namespace App\Repository;

use App\Entity\LigneCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Driver\Exception;

/**
 * @method LigneCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneCommande[]    findAll()
 * @method LigneCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneCommandeRepo extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneCommande::class);
    }

    ///////////
    public function max_id_user()
    {

        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "SELECT (id_u) as id FROM commande ORDER BY id_commande DESC LIMIT 1";
        //  $sql = "SELECT MAX(id_u) as id FROM `commande`";

        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
        }
        $stmt->execute();
        return $stmt->fetch();
    }

    public function max_id_commande()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "SELECT MAX(id_commande) as id FROM `commande`";

        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
        }
        $stmt->execute();
        return $stmt->fetch();
    }

    public function insert_idUser($total, $idUser, $iCommande)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "INSERT INTO `ligne_commande`(`total_facture`, `id_commande`, `id_user`) VALUES ('.$total.', '.$iCommande.', '.$idUser.') ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function insert_idCommande($id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "INSERT INTO `ligne_commande`(`id_commande`) VALUES ('.$id.') ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    /////////

}
