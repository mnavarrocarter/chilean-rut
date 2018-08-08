<?php

/*
 * This file is part of the MNC\ChileanRut library.
 *
 * (c) Matías Navarro Carter <mnavarrocarter@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\ChileanRut\Bridge\Symfony\Form;

use MNC\ChileanRut\Rut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RutType.
 *
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class RutType extends AbstractType implements DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer($this);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'compound' => false,
            'data_class' => Rut::class,
            'empty_data' => function (FormInterface $form) {
                return new Rut($form->getData());
            },
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): ?string
    {
        return 'rut';
    }

    /**
     * @param mixed $value
     *
     * @return mixed|string
     */
    public function transform($value)
    {
        if ($value instanceof Rut) {
            return $value->format(Rut::FORMAT_READABLE);
        }
    }

    /**
     * @param mixed $value
     *
     * @return mixed|Rut
     */
    public function reverseTransform($value)
    {
        return new Rut((string) $value);
    }
}
