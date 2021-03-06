<?php


namespace ObservationBundle\Form\Type\Picture;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Image;

class PictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('file', FileType::class, array(
                    'label' => 'Importer une image',
                    'multiple' => false,
                    'required' => false,
                    'attr' => [
                        'accept' => 'image/*',
                    ],
                    'constraints' => new Image(),
                )
            );


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'ObservationBundle\Entity\Picture',
                'cascade_validation' => true,
            )
        );
    }
}
