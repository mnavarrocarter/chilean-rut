<?php

namespace MNC\ChileanRut\Tests\Validator;

use MNC\ChileanRut\Exception\InvalidRutException;
use MNC\ChileanRut\Rut\Rut;
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
