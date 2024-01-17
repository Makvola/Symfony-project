<?php

namespace App\Form;

use App\Entity\CarteJoueur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarteJoueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomJoueur')
            ->add('pays')
            ->add('poste')
            ->add('maCollection', null, [
                'disabled'   => true,
            ])
            #->add('expo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CarteJoueur::class,
        ]);
    }
}
