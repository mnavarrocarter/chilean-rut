<?php

namespace MNC\ChileanRut\Bridge\Symfony\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsValidRut extends Constraint
{
    public $message = 'The rut "{{value}}" is not valid.';
}