<?php

namespace MNC\ChileanRut\Bridge\Symfony\Form;

use MNC\ChileanRut\Rut\Rut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RutType
 * @package MNC\ChileanRut\Bridge\Symfony\Form
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class RutType extends TextType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rut::class,
        ]);
    }
}