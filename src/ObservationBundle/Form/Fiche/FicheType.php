<?php

namespace ObservationBundle\Form\Fiche;

use ObservationBundle\Form\Bird\BirdType;
use function Sodium\add;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ObservationBundle\Form\Observation\AddObservationType;

class FicheType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minQuantity', IntegerType::class, array(
                'label' => 'Quantité minimum de spécimens',
                'attr' => array('min' => 1,
                    'max' => 20000,
                    'value' => $options['attr']['minVal'])
            ))
            ->add('maxQuantity', IntegerType::class, array(
                'label' => 'Quantité maximum de spécimens',
                'attr' => array('min' => 1,
                    'max' => 20000,
                    'value' => $options['attr']['maxVal'])
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description de l\'oiseau',
                'attr' => array('rows' => '10')
            ))
            ->add('status', ChoiceType::class, array(
                'choices' => [
                    'éteint' => 'eteint',
                    'éteint à l\'état sauvage' => 'éteint à l\'état sauvage',
                    'en danger critique' =>'en danger critique',
                    'en danger' =>'en danger',
                    'vulnérable' =>'vulnérable',
                    'quasi menacé' =>'quasi menacé',
                    'préoccupation mineure' =>'préoccupation mineure',
                    'données insuffisante' =>'données insuffisante',
                    'non évalué' =>'non évalué',
                ]
            ))
            ->add('bird', BirdType::class, array(
                'label' => false
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Valider la saisie',
                'attr' => array(
                    'class' => 'btn btn-nao'
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\Fiche'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'observationbundle_fiche';
    }


}
