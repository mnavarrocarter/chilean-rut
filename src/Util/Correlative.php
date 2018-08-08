<?php

namespace MNC\ChileanRut\Util;

use MNC\ChileanRut\Rut\Rut;

/**
 * This class provides utils for a Rut correlative.
 *
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class Correlative
{
    /**
     * Finds the verifier digit of a correlative.
     *
     * @param string $correlative
     * @return string
     */
    public static function findVerifierDigit(string $correlative): string
    {
        $x = 2;
        $s = 0;

        for ($i = \strlen($correlative) - 1; $i >= 0; $i--) {
            if ($x > 7) {
                $x = 2;
            }
            $s += $correlative[$i] * $x;
            $x++;
        }

        $dv = 11 - ($s % 11);

        if ($dv === 10) {
            $dv = 'K';
        }

        if ($dv === 11) {
            $dv = '0';
        }

        return (string) $dv;
    }

    /**
     * Instantiates a valid Rut object just providing a correlative.
     *
     * @param string $correlative
     * @return Rut
     */
    public static function createValidRutOnlyFromCorrelative(string $correlative): Rut
    {
        return Rut::fromParts($correlative, static::findVerifierDigit($correlative));
    }
}