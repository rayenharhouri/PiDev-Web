<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use App\Repository\QuizRepo;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class QuestionType extends AbstractType
{

    private $Crepo;
    public  function __construct(QuizRepo $Crepo)
    {
        $this->QuizRepo = $Crepo;
    }



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question')
            ->add('matiere')
            ->add('r1')
            ->add('r2')
            ->add('r3')
            ->add('solution')
            ->add('difficulte')


            ->add('idQuizs', ChoiceType::class, [

                'multiple' => false,
                'choices' =>    
                    $this->QuizRepo->createQueryBuilder('u')->select("(u.idQuizs) as idQuizs")->getQuery()->getResult(),
                    'choice_label' => function ($choice) {
                    return $choice;
                },
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
