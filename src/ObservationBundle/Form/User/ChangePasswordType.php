<?php


namespace ObservationBundle\Form\User;


use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePasswordType extends ResetPasswordType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldPassword', PasswordType::class, array(
            'attr' => [
                'placeholder' => 'Changer mot de passe'
            ],
            'mapped' => false,
            'constraints' => array(
                // Contraint ne validant le form qu'avec le bon mot de passe
                new UserPassword(array(
                    'message' => 'Le mot de passe est incorrect!'
                ))
            )
        ));
        parent::buildForm($builder, $options);
    }
}
