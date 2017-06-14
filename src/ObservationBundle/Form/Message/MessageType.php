<?php


namespace ObservationBundle\Form\Message;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, array(
            'label' => 'Mail de contact'
        ))
            ->add('title', TextType::class, array(
            'label' => 'Titre de votre message'
        ))
            ->add('message', TextareaType::class, array(
                'label' => 'Votre message',
                 'attr' => array(
                     'cols' => 250,
                     'rows' => 10
                 )
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Envoyer',
                'attr' => array(
                    'class' => "btn btn-nao btn-form"
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\Message'
        ));
    }
}