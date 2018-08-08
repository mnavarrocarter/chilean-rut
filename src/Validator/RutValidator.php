<?php

namespace MNC\ChileanRut\Validator;

use MNC\ChileanRut\Exception\InvalidRutException;
use MNC\ChileanRut\Rut\Rut;

/**
 * This is the base contract for a Rut validator.
 *
 * You can implement any logic here that you can use to validate a Rut.
 * For example, the SimpleRutValidator only validates that a Rut is algorithmically
 * correct, but not that it actually exists.
 *
 * You could create a HTTPRutValidator that performs a request to validate that a
 * Rut exists against a Rest Api or a third party service.
 *
 * @package MNC\ChileanRut\Validator
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
     * @throws InvalidRutException on invalid Rut.
     */
    public function validate(Rut $rut): void;
}