<?php


namespace ObservationBundle\Form\Type\User;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class EditUserType extends UserType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('plainPassword')
            ->remove('save')
            ->add('save', SubmitType::class, array(
                'label' => 'Modifier',
                'attr' => array(
                    'class' => 'btn btn-nao'
                )
            ));
    }

}
