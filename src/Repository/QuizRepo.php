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


    
}
