<?php

namespace App\Form;

use App\Entity\Fournisseur;
use App\Entity\Produit;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeProduit', null, [
                'label' => 'typeProduit',
                'attr' => [
                    'placeholder' => 'typeProduit'
                ],
            ])
            ->add('quantite', null, [
                'label' => 'quantite',
                'attr' => [
                    'placeholder' => 'quantite'
                ],
            ])
            ->add('prix', null, [
                'label' => 'prix',
                'attr' => [
                    'placeholder' => 'prix'
                ],
            ])
            ->add('imageFile',FileType::class,['required'=>false])
            ->add('idFournisseur',EntityType::class, [
            'class'=>Fournisseur::class,
            'choice_label'=>'nomFournisseur'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
