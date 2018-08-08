<?php

namespace MNC\ChileanRut\Validator;

use MNC\ChileanRut\Exception\InvalidRutException;
use MNC\ChileanRut\Rut\Rut;
use MNC\ChileanRut\Util\Correlative;

/**
 * Validates the Rut using the Module 11 algorithm.
 *
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class SimpleRutValidator implements RutValidator
{
    /**
     * @param Rut $rut
     */
    public function validate(Rut $rut): void
    {
        $digit = Correlative::findVerifierDigit($rut->getCorrelative());

        if ($digit !== $rut->getVerifierDigit()) {
            throw new InvalidRutException($rut);
        }
    }
}