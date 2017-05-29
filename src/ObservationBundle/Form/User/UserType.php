<?php


namespace ObservationBundle\Form\User;


use ObservationBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, array(
            'label' => 'Pseudo',
        ))
            ->add('email', EmailType::class,array(
                'label' => 'Email'
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas!',
                'first_options' => array(
                    'label' => 'Mot de passe'
                ),
                'second_options' => array(
                    'label' => 'Confirmation'
                )
            ))
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom'
            ))
            ->add('lastname', TextType::class,array(
                'label' => 'Nom'
            ))
            ->add('birthDate', BirthdayType::class, array(
                'label' => 'Date de naissance',
                'choice_translation_domain' => true,
                'format' => 'dd/MM/yyyy',
                'years' => range(1917, 2016),
                'required' => false,
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Enregistrer',
                'attr' => array(
                    'class' => 'btn btn-xs btn-primary'
                )
            ));
    }

}