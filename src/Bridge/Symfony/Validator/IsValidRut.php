<?php

/*
 * This file is part of the MNC\ChileanRut library.
 *
 * (c) Matías Navarro Carter <mnavarrocarter@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\ChileanRut\Bridge\Symfony\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsValidRut extends Constraint
{
    public $message = '"{{value}}" is not a valid Rut.';
}
