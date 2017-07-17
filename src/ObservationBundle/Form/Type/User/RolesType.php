<?php


namespace ObservationBundle\Form\Type\User;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RolesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('roles', ChoiceType::class, array(
            'label' => 'Sélectionner les roles du visiteur ',
            'choices' => array(
                'Naturaliste' => 'ROLE_NATURALISTE',
                'Administrateur' => 'ROLE_ADMIN'
            ),
            'multiple' => true,
            'expanded' => true
        ))
            ->add('save', SubmitType::class, array(
                'label' => 'Enregistrer',
                'attr' => array(
                    'class' => 'btn btn-nao'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\User'
        ));
    }
}
