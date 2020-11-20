<?php

declare(strict_types=1);

/**
 * @project Chilean Rut
 * @link https://github.com/mnavarrocarter/chilean-rut
 * @package mnavarrocarter/chilean-rut
 * @author Matias Navarro-Carter mnavarrocarter@gmail.com
 * @license MIT
 * @copyright 2020 Matias Navarro Carter
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\ChileanRut;

use InvalidArgumentException;

/**
 * Class InvalidRut.
 */
class InvalidRut extends InvalidArgumentException
{
    public static function number(): InvalidRut
    {
        return new self('Rut number cannot be greater than 999.999.999 and smaller than zero');
    }

    public static function digit(string $digit): InvalidRut
    {
        return new self(sprintf('The verifier digit "%s" is not valid', $digit));
    }
}
