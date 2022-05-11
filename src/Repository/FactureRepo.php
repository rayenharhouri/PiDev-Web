<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Driver\Exception;

/**
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRepo extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    public function findInFactutre($adress, $order)
    {
        $em = $this->getEntityManager();
        if ($order == 'DESC') {
            $query = $em->createQuery(
                'SELECT r FROM App\Entity\Facture r   where r.adressLivraison like :adress  order by r.totalApresReduction DESC '
            );
            $query->setParameter('adress', $adress . '%');
        } else {
            $query = $em->createQuery(
                'SELECT r FROM App\Entity\Facture r   where r.adressLivraison like :adress  order by r.totalApresReduction ASC '
            );
            $query->setParameter('adress', $adress . '%');
        }
        return $query->getResult();
    }
}
