<?php

/*
 * This file is part of the MNC\ChileanRut library.
 *
 * (c) Matías Navarro Carter <mnavarrocarter@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\ChileanRut\Util;

use MNC\ChileanRut\Rut;

/**
 * This class provides utils for a Rut correlative.
 *
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class CorrelativeUtils
{
    /**
     * Finds the verifier digit of a correlative.
     *
     * @param string $correlative
     *
     * @return string
     */
    public static function findVerifierDigit(string $correlative): string
    {
        $x = 2;
        $s = 0;

        for ($i = \strlen($correlative) - 1; $i >= 0; --$i) {
            if ($x > 7) {
                $x = 2;
            }
            $s += $correlative[$i] * $x;
            ++$x;
        }

        $dv = 11 - ($s % 11);

        if (10 === $dv) {
            $dv = 'K';
        }

        if (11 === $dv) {
            $dv = '0';
        }

        return (string) $dv;
    }

    /**
     * Instantiates a valid Rut object just providing a correlative.
     *
     * @param string $correlative
     *
     * @return Rut
     */
    public static function createValidRutOnlyFromCorrelative(string $correlative): Rut
    {
        return Rut::fromParts($correlative, static::findVerifierDigit($correlative));
    }

    /**
     * Auto-generates an algorithmically valid Rut, because why not.
     *
     * @return Rut
     */
    public static function autoGenerateValidRut(): Rut
    {
        $correlative = \random_int(1000000, 40000000);

        return static::createValidRutOnlyFromCorrelative($correlative);
    }
}
