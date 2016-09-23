<?php

namespace PlugSurfingDemoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * Project: PlugSurfingDemo
 * User: Dave
 * Date: 22/09/2016
 * Time: 22:41
 */
class CsvUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'csvfile',
                FileType::class,
                array(
                    'label' => 'CSVUpload',

                    'attr' => array(
                        'placeholder' => 'Please select CSV File to upload.',
                        'pattern' => '.{2,}' //minlength
                    ),
                )
            )
            ->add(
                'output_format',
                ChoiceType::class,
                [
                    'choices' => [
                        'json' => '0',
                        'xml' => '1',
                    ],
                    'choices_as_values' => true,
                    'multiple' => false,
                    'expanded' => true,
                ]
            )
            ->add('Send', SubmitType::class, array('label' => 'Upload'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'PlugSurfingDemoBundle\Entity\CSVFile',
            )
        );
    }

    public function getName()
    {
        return 'csvupload';
    }
}