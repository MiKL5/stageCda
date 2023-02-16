<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
                'class' => 'col-6 ml-3',
                ],
            ])

        ->add('roles', ChoiceType::class, [
            'choices' => (array)[
                'ROLE_ADMIN' => 'ROLE_ADMIN',
                'ROLE_CLIENT' => 'ROLE_CLIENT',
                'ROLE_USER' => 'ROLE_USER',
            ],
            'mapped' => false,
            'multiple' => true,
            'help' => 'Maintenez Ctrl pour choisir plusieurs roles',
            'required' => true,
            'row_attr' => [
                'class' => 'col-6 ml-3',
                ],
            ])

            // PLAIN PASSWORD est désactivé pcq si l'admin à besoi de changer des infos, devrait changer le mot de passe du client ce qui est absurde
        // ->add('plainPassword', PasswordType::class, [
        //     // instead of being set onto the object directly,
        //     // this is read and encoded in the controller
        //     'mapped' => false,
        //     'attr' => ['autocomplete' => 'new-password'],
        //     'required' => true,
        //     'row_attr' => [
        //         'class' => 'col-6 ml-3',
        //         ],
        //     'constraiSQLSTATE[42S22]: Column not found: 1054min' => 6,
        //             'minMessage' => 'Your password should be at least {{ limit }} characters',
        //             // max length allowed by Symfony for security reasons
        //             'max' => 4096,
        //         ]),
        //     ],
        // ])
        ->add('isVerified')
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
