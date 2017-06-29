<?php


namespace ObservationBundle\Form\Type\User;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, array(
            'label' => 'Pseudo',
            'attr' => [
                'placeholder' => 'Identifiant'
            ]
        ))
            ->add('email', EmailType::class,array(
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email'
                ]
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas!',
                'first_options' => array(
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Mot de passe'
                    ]
                ),
                'second_options' => array(
                    'label' => 'Confirmation du mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmez votre mot de passe'
                    ]
                )
            ))
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Prénom'
                ]
            ))
            ->add('lastname', TextType::class,array(
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ))
            ->add('birthDate', BirthdayType::class, array(
                'label' => 'Date de naissance',
                'attr' => [
                    'placeholder' => 'Né(é) le : (jj/mm/AAAA)'
                ],
                'widget' => 'single_text',
                'choice_translation_domain' => true,
                'format' => 'dd/MM/yyyy',
                'required' => false,
            ))
            ->add('newsletter', CheckboxType::class, array(
                'label' => 'Newsletter ',
                'required' => false
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Inscription',
                'attr' => array(
                    'class' => 'btn btn-nao'
                )
            ));
    }

}
