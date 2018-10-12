<?php

/*
 * This file is part of the MNC\ChileanRut library.
 *
 * (c) Matías Navarro Carter <mnavarrocarter@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\ChileanRut\Validator;

use MNC\ChileanRut\Exception\InvalidRutException;
use MNC\ChileanRut\Rut;

/**
 * This is the base contract for a Rut validator.
 *
 * You can implement any logic here that you can use to validate a Rut.
 * For example, the Module11RutValidator only validates that a Rut is algorithmically
 * correct, but not that it actually exists.
 *
 * You could create a HTTPRutValidator that performs a request to validate that a
 * Rut exists against a Rest Api or a third party service.
 *
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
interface RutValidator
{
    /**
     * Validates a Rut.
     *
     * The implementation MUST throw an InvalidRutException if validation fails.
     *
     * The different clients CAN catch that exception and handle the validation
     * error according to their business rules.
     *
     * @param Rut $rut
     *
     * @throws InvalidRutException on invalid Rut
     */
    public function validate(Rut $rut): void;
}
