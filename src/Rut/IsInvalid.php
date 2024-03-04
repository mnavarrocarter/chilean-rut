<?php

declare(strict_types=1);

/**
 * @project Chilean RUT
 * @link https://github.com/mnavarrocarter/chilean-rut
 * @package castor/log
 * @author Matias Navarro-Carter mnavarrocarter@gmail.com
 * @license MIT
 * @copyright 2024 Matias Navarro-Carter
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\Rut;

class IsInvalid extends \InvalidArgumentException
{
    public static function numberTooBig(int $number): IsInvalid
    {
        return new self(\sprintf(
            'El RUT numero %d es mayor a 99.999.999',
            $number
        ));
    }

    public static function numberTooSmall(int $number): IsInvalid
    {
        return new self(\sprintf(
            'El RUT numero %d es menor a cero',
            $number
        ));
    }

    public static function rut(int $number, Verifier $verifier): IsInvalid
    {
        return new self(\sprintf(
            'El digito verificador %s no es valido para el rut %d',
            $verifier->toString(),
            $number
        ));
    }

    public static function verifier(string $verifier): IsInvalid
    {
        return new self(\sprintf(
            'Encontrado un digito verificador invalido con valor %s',
            $verifier,
        ));
    }
}
