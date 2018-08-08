<?php

/*
 * This file is part of the MNC\ChileanRut library.
 *
 * (c) Matías Navarro Carter <mnavarrocarter@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\ChileanRut\Bridge\Symfony\Validator;

use MNC\ChileanRut\Exception\InvalidRutException;
use MNC\ChileanRut\Rut;
use MNC\ChileanRut\Validator\RutValidator;
use MNC\ChileanRut\Validator\SimpleRutValidator;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class IsValidRutValidator.
 *
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class IsValidRutValidator extends ConstraintValidator
{
    /**
     * @var RutValidator
     */
    private $validator;

    public function __construct(RutValidator $validator = null)
    {
        $this->validator = $validator ?? new SimpleRutValidator();
    }

    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!$value instanceof Rut) {
            throw new UnexpectedTypeException($value, Rut::class);
        }

        try {
            $this->validator->validate($value);
        } catch (InvalidRutException $exception) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value->format(Rut::FORMAT_CLEAR))
                ->addViolation();
        }
    }
}
