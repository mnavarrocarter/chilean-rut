<?php

namespace MNC\ChileanRut\Bridge\Symfony\Validator;

use MNC\ChileanRut\Exception\InvalidRutException;
use MNC\ChileanRut\Rut\Rut;
use MNC\ChileanRut\Validator\RutValidator;
use MNC\ChileanRut\Validator\SimpleRutValidator;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class IsValidRutValidator
 * @package MNC\ChileanRut\Bridge\Symfony\Validator
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