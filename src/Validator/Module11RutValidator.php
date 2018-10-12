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
use MNC\ChileanRut\Util\CorrelativeUtils;

/**
 * Validates the Rut using the Module 11 algorithm.
 *
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class Module11RutValidator implements RutValidator
{
    /**
     * @param Rut $rut
     *
     * @throws InvalidRutException
     */
    public function validate(Rut $rut): void
    {
        $digit = CorrelativeUtils::findVerifierDigit($rut->getCorrelative());

        if ($digit !== $rut->getVerifierDigit()) {
            throw new InvalidRutException($rut);
        }
    }
}
