<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('username', TextType::class, ['label' => "Nom d'utilisateur",
                'attr' => array(
                    'class' => 'form-control','class'=>'calendar'
                    
                )])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe',
                    'attr' => array(
                    'class' => 'form-control'
                )],
                'second_options' => ['label' => 'Tapez le mot de passe à nouveau',
                    'attr' => array(
                    'class' => 'form-control'
                )],
            ])

            ->add('email', EmailType::class, ['label' => 'Adresse email',
                'attr' => array(
                    'class' => 'form-control'
                )])
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'UTILISATEUR' => 'ROLE_USER',
                    'ADMIN' => 'ROLE_ADMIN',
                ],
                'attr' => array(
                    'class' => 'form-control'
                )
            ]);
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return $rolesArray !== null ? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

}
