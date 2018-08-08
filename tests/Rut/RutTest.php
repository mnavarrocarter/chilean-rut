<?php
/**
 * Created by PhpStorm.
 * User: mnavarro
 * Date: 07-08-18
 * Time: 23:45
 */

namespace MNC\ChileanRut\Tests\Rut;

use MNC\ChileanRut\Exception\InvalidRutException;
use MNC\ChileanRut\Rut\Rut;
use MNC\ChileanRut\Validator\SimpleRutValidator;
use PHPUnit\Framework\TestCase;

class RutTest extends TestCase
{
    public function testThatRutIsSanitizedProperlyOnInstantiation()
    {
        $rut = Rut::fromString('16.894.365-2');

        $this->assertEquals('16894365', $rut->getCorrelative());
        $this->assertEquals('2', $rut->getVerifierDigit());
    }

    public function testThatRutsInstantiatedDifferentFormatButWithEqualValueAreIndeedEqual()
    {
        $rut1 = new Rut('16.894.365-2');
        $rut2 = new Rut('16894365-2');
        $this->assertTrue($rut1->isEqualTo($rut2));
    }

    public function testThatFormatClearWorks()
    {
        $rut = new Rut('16.894.365-2');
        $this->assertEquals('168943652', $rut->format(Rut::FORMAT_CLEAR));
    }

    public function testThatFormatWithHyphenWorks()
    {
        $rut = new Rut('16.894.365-2');
        $this->assertEquals('16894365-2', $rut->format(Rut::FORMAT_HYPHENED));
    }

    public function testThatFormatReadableWorks()
    {
        $rut = new Rut('168943652');
        $this->assertEquals('16.894.365-2', $rut->format(Rut::FORMAT_READABLE));
    }

    public function testThatIntegratedValidationThrowsExceptionOnInvalidRut()
    {
        $this->expectException(InvalidRutException::class);

        $validator = new SimpleRutValidator();
        $rut = new Rut('4444444-2', $validator);
    }

    public function testThatIntegratedValidationDoesNotThrowExceptionOnValidRut()
    {
        $validator = new SimpleRutValidator();
        $rut = new Rut('16.894.365-2', $validator);

        $this->assertInstanceOf(Rut::class, $rut);
    }
}
