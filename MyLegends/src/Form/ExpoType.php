<?php

namespace App\Form;


use App\Repository\CarteJoueurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class ExpoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);
        $expo = $options['data'] ?? null;
        $membre = $expo->getCreateur();
        
        $builder
        ->add('descriptExpo')
        ->add('publiee')
        ->add('createur', null, [
            'disabled'   => true,
        ])
        ->add('cartes', null, [
            'query_builder' => function (CarteJoueurRepository $er) use ($membre) {
            return $er->createQueryBuilder('o')
            ->leftJoin('o.maCollection', 'i')
            ->andWhere('i.member = :membre')
            ->setParameter('membre', $membre)
            ;
            },
            'by_reference' => false,
            'multiple' => true,
            'expanded' => true
            ])
            ;
    }
    





/*class ExpoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descriptExpo')
            ->add('publiee')
            ->add('createur', null, [
                'disabled'   => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expo::class,
        ]);
    }
}*/
}
