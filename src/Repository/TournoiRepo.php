<?php


namespace coachBundle\Repository;
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Null_;
use App\Entity\Tournoi;


/**
 * @method Tournoi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tournoi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tournoi[]    findAll()
 * @method Tournoi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */



class TournoiRepo extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournoi::class);
    }




    public function mise_a_joure()
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
           DELETE FROM `tournoi` WHERE DATE < CURRENT_DATE ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();


    }
























}