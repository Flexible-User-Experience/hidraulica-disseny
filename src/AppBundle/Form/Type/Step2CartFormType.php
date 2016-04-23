<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Step2CartFormType
 *
 * @category FormType
 * @package  ECVulco\AppBundle\Form\Type
 * @author   David Romaní <david@flux.cat>
 */
class Step2CartFormType extends AbstractType
{
    /**
     * Build form
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                array(
                    'label' => 'Nombre',
                    'attr'  => array(
                        'class' => 'form-control',
                    ),
                )
            )
            ->add(
                'email',
                EmailType::class,
                array(
                    'label' => 'Email',
                    'attr'  => array(
                        'class' => 'form-control',
                    ),
                )
            )
            ->add(
                'phone',
                TextType::class,
                array(
                    'label'    => 'Teléfono',
                    'required' => false,
                    'attr'     => array(
                        'class' => 'form-control',
                    ),
                )
            )
            ->add(
                'address',
                TextType::class,
                array(
                    'label' => 'Dirección',
                    'attr'  => array(
                        'class' => 'form-control',
                    ),
                )
            )
            ->add(
                'city',
                TextType::class,
                array(
                    'label' => 'Ciudad',
                    'attr'  => array(
                        'class' => 'form-control',
                    ),
                )
            )
            ->add(
                'postalCode',
                TextType::class,
                array(
                    'label' => 'Código postal',
                    'attr'  => array(
                        'class' => 'form-control',
                    ),
                )
            )
            ->add(
                'state',
                TextType::class,
                array(
                    'label' => 'Provincia',
                    'attr'  => array(
                        'class' => 'form-control',
                    ),
                )
            )
            ->add(
                'country',
                TextType::class,
                array(
                    'label' => 'Pais',
                    'attr'  => array(
                        'class' => 'form-control',
                    ),
                )
            )
            ->add(
                'send',
                SubmitType::class,
                array(
                    'label' => 'Siguiente',
                    'attr'  => array(
                        'class' => 'btn btn-success'
                    ),
                )
            );
    }

    /**
     * Returns the name of this type
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'step2_cart';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Cart\Customer',
            )
        );
    }
}
