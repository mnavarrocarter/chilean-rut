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
use MNC\ChileanRut\Util\CorrelativeUtils;
use MNC\ChileanRut\Validator\ChainRutValidator;
use MNC\ChileanRut\Validator\Module11RutValidator;
use MNC\ChileanRut\Validator\RutValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class ChainRutValidatorTest.
 */
class ChainRutValidatorTest extends TestCase
{
    public function testThatChainValidatorFails(): void
    {
        $rut = CorrelativeUtils::autoGenerateValidRut();

        $normalValidator = new Module11RutValidator();
        $mockValidator = $this->createMock(RutValidator::class);
        $mockValidator->expects($this->once())
            ->method('validate')
            ->willThrowException(new InvalidRutException($rut));

        $chainValidator = new ChainRutValidator($normalValidator, $mockValidator);

        $this->expectException(InvalidRutException::class);
        $chainValidator->validate($rut);
    }

    public function testThatChainValidatorPasses(): void
    {
        $rut = CorrelativeUtils::autoGenerateValidRut();

        $normalValidator = new Module11RutValidator();
        $mockValidator = $this->createMock(RutValidator::class);
        $mockValidator->expects($this->once())
            ->method('validate')
            ->willReturn(null);

        $chainValidator = new ChainRutValidator($normalValidator, $mockValidator);

        $chainValidator->validate($rut);
        $this->assertTrue(true);
    }
}
