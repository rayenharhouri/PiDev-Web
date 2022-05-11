<?php

namespace App\Form;

use App\Entity\Facture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Repository\CommandeRepo;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class FactureType extends AbstractType
{


    private $Crepo;
    public  function __construct(CommandeRepo $Crepo)
    {
        $this->Commanderepo = $Crepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adressLivraison')
            ->add('totalApresReduction')
            //->add('idCommande')

            ->add('idCommande', ChoiceType::class, [

                'multiple' => false,
                'choices' =>    
                    $this->Commanderepo->createQueryBuilder('u')->select("(u.idCommande) as idCommande")->getQuery()->getResult(),
                    'choice_label' => function ($choice) {
                    return $choice;
                },
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
