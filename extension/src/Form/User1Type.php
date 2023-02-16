<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // si email et roles ne sont pas renseignés la page edit ne s'affichera pas
        // et la page app_client_show ne fonctionnera pas non plus (app_client_show   id: user.id)
        // je ne change rien pour me souvenir que les deux existes
        $builder
        ->add('firstname', TextType::class, [
            'required' => true,
            'row_attr' => [
                'class' => 'col-6 ml-3',
                ],
            ])
        ->add('name', TextType::class, [
            'required' => true,
            'row_attr' => [
                'class' => 'col-6 ml-3 mt-2 mb-2',
                ],
            ]
        )
        ->add('email', TextType::class, [
            'required' => true,
            'row_attr' => [
                'class' => 'col-6 ml-3 mb-5',
                ],
            ])

        // ->add('roles', ChoiceType::class, [
        //     'choices' => (array)[
        //         'ROLE_ADMIN' => 'ROLE_ADMIN', // le 1er dand le bdd, le 2d à l'écran ; mieux vaut mettre les même pour que ce soit bien renseigné
        //         'ROLE_CLIENT' => 'ROLE_CLIENT',
        //         'ROLE_USER' => 'ROLE_USER',
        //     ],
        //     'mapped' => false,
        //     'multiple' => true,
        //     'help' => 'Maintenez Ctrl pour choisir plusieurs roles',
        //     'required' => true,
        //     'row_attr' => [
        //         'class' => 'col-6 ml-3',
        //         ],
        //     ])
        //     ->add('isVerified')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
