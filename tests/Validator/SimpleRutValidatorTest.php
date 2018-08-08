<?php

/*
 * This file is part of the MNC\ChileanRut library.
 *
 * (c) Matías Navarro Carter <mnavarrocarter@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\ChileanRut\Tests\Validator;

use MNC\ChileanRut\Exception\InvalidRutException;
use MNC\ChileanRut\Rut;
use MNC\ChileanRut\Validator\SimpleRutValidator;
use PHPUnit\Framework\TestCase;

class SimpleRutValidatorTest extends TestCase
{
    public function testValidationPassesOnValidRut()
    {
        $rut = new Rut('16.894.365-2');
        $validator = new SimpleRutValidator();

        $validator->validate($rut);

        $this->assertInstanceOf(Rut::class, $rut);
    }

    public function testValidationFailsOnInvalidRut()
    {
        $this->expectException(InvalidRutException::class);

        $rut = new Rut('34.4534.353-1');
        $validator = new SimpleRutValidator();

        $validator->validate($rut);
    }
}
