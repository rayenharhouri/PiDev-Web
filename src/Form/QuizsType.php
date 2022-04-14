<?php

namespace App\Form;

use App\Entity\Quizs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class QuizsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


        ->add('image', FileType::class, array('data_class' => null,'required' => false),  [
            'label' => true,

        ])  

            ->add('matiere')
            ->add('difficulte')
            ->add('resultat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quizs::class,
        ]);
    }
}
