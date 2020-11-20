<?php

/*
 * This file is part of the MNC\ChileanRut library.
 *
 * (c) Matías Navarro Carter <mnavarrocarter@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\ChileanRut;

use PHPUnit\Framework\TestCase;

/**
 * Class RutTest
 * @package MNC\ChileanRut\Tests\Rut
 */
class RutTest extends TestCase
{
    /**
     * @dataProvider getRutDataset
     * @param string $raw
     * @param int $expectedNumber
     * @param string $expectedVerifier
     */
    public function testItParsesRuts(string $raw, int $expectedNumber, string $expectedVerifier): void
    {
        $rut = Rut::parse($raw);
        self::assertSame($expectedNumber, $rut->getNumber());
        self::assertSame($expectedVerifier, $rut->getVerifier());
    }

    public function testItDetectsOutOfRangeVerifier(): void
    {
        $this->expectException(InvalidRut::class);
        Rut::parse('16894365F');
    }

    public function testItDetectsInvalidVerifier(): void
    {
        $this->expectException(InvalidRut::class);
        Rut::parse('16894365K');
    }

    public function testItDetectsRutTooBig(): void
    {
        $this->expectException(InvalidRut::class);
        Rut::create(3_355_535_353);
    }

    public function testItComparesToEqual(): void
    {
        $rut1 = Rut::parse('168943652');
        $rut2 = Rut::parse('16.894.365-2');
        $rut3 = Rut::create(22_224_525);
        self::assertTrue($rut1->equals($rut2));
        self::assertFalse($rut1->equals($rut3));
    }

    public static function testItCreatesARut(): void
    {
        $rut = Rut::create(22_457_309);
        self::assertSame(22_457_309, $rut->getNumber());
    }

    public static function testItCanFormatRut(): void
    {
        $rut = (string) Rut::create(22_457_309)->format();
        self::assertSame('22457309K', $rut);
    }

    /**
     * @return array[]
     */
    public function getRutDataset(): array
    {
        return [
            ['16.894.365-2', 16_894_365, '2'],
            ['24  736.7322', 24_736_732, '2'],
            [' 24 232..  442  -- 0', 24_232_442, '0'],
            ['35323325', 3_532_332, '5'],
            ['22.457.309K', 22_457_309, 'K']
        ];
    }
}
