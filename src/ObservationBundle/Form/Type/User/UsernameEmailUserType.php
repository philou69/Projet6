<?php


namespace ObservationBundle\Form\Type\User;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UsernameEmailUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // champ pour la recuperation de l'user,
        // Prévoir la vérification si c'est un text ou un email
        $builder->add('username', TextType::class, array(
            'label' => 'Pseudo ou email',
            'required' => true,
        ))
            ->add('save', SubmitType::class, array(
                'label' => 'Envoyer',
                'attr' => array(
                    'class' => 'bnt'
                )
            ));
    }
}
