<?php

namespace App\Repository;

use App\Entity\Quizs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Quizs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quizs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quizs[]    findAll()
 * @method Quizs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizRepo extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quizs::class);
    }








    
    public function find_Nb_Rec_Par_Status($difficulte){

        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT DISTINCT  count(r.idQuizs) FROM   App\Entity\Quizs r  where r.difficulte = :difficulte   '
        );
        $query->setParameter('difficulte', $difficulte);
        return $query->getResult();
    }






    public function findUser($valueemail,$order){
        $em = $this->getEntityManager();
        if($order=='DESC') {
            $query = $em->createQuery(
                'SELECT r FROM App\Entity\Quizs r   where r.matiere like :matieree order by r.idQuizs DESC '
            );
            $query->setParameter('matieree', $valueemail . '%');
        }
        else{
            $query = $em->createQuery(
                'SELECT r FROM App\Entity\Quizs r   where r.matiere like :matieree  order by r.idQuizs ASC '
            );
            $query->setParameter('matieree', $valueemail . '%');
        }
        return $query->getResult();
    }



    
}
