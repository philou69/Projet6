<?php


namespace ObservationBundle\Form\Type\Newsletter;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class UnscubscribeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, array(
            'label' => 'votre email'
        ))
            ->add('save', SubmitType::class,array(
                'label' => 'Enregistrer',
                'attr' => array(
                    'class' => 'btn btn-nao'
                )
            ));
    }

}
