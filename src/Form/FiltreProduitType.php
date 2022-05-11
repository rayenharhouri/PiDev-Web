<?php

namespace App\Form;

use App\Entity\FiltrerProduit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeproduit',ChoiceType::class,[
                'required'=>false,
                'choices'=>[
                    'souris'=> 'souris',
                    'clavier'=>  'clavier',
                    'casque'=> 'casque'
                ]

            ])
            ->add('fournisseur',ChoiceType::class,[
                'required'=>false,
                'choices'=>[
                    'Malek'=> 3,
                    'hassen'=>2
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FiltrerProduit::class,
        ]);
    }
}
