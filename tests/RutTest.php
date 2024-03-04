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

namespace MNC;

use MNC\Rut\IsInvalid;
use MNC\Rut\Verifier;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Rut::class)]
#[CoversClass(IsInvalid::class)]
#[CoversClass(Verifier::class)]
class RutTest extends TestCase
{
    #[Test]
    #[DataProvider('getParseData')]
    public function it_parses_ruts(string $raw, int $expectedNumber, Verifier $expectedVerifier): void
    {
        $rut = Rut::parse($raw);
        $this->assertSame($expectedNumber, $rut->number);
        $this->assertSame($expectedVerifier, $rut->verifier);
    }

    #[Test]
    #[DataProvider('getParseWithErrorData')]
    public function it_parses_with_error(string $raw, string $expectedError): void
    {
        $this->expectException(IsInvalid::class);
        $this->expectExceptionMessage($expectedError);
        Rut::parse($raw);
    }

    #[Test]
    public function it_cannot_be_negative(): void
    {
        $this->expectException(IsInvalid::class);
        $this->expectExceptionMessage('El RUT numero -22224525 es menor a cero');
        Rut::create(-22_224_525);
    }

    #[Test]
    public function it_checks_for_equality(): void
    {
        $rut1 = Rut::parse('168943652');
        $rut2 = Rut::parse('16.894.365-2');
        $rut3 = Rut::create(22_224_525);
        $this->assertTrue($rut1->equals($rut2));
        $this->assertFalse($rut1->equals($rut3));
    }

    #[Test]
    public function it_creates_with_no_verifier(): void
    {
        $rut = Rut::create(22_457_309);
        $this->assertSame(22_457_309, $rut->number);
    }

    #[Test]
    public function it_formats(): void
    {
        $rut = Rut::create(22_457_309);
        $this->assertSame('22457309K', $rut->toString());
        $this->assertSame('22457309-K', $rut->toSimple());
        $this->assertSame('22.457.309-K', $rut->toHuman());
        $this->assertSame('7309', $rut->last(4));
        $this->assertSame('****7309', $rut->last(4, '*'));
        $this->assertSame('2245', $rut->first(4));
        $this->assertSame('2245****', $rut->first(4, '*'));
    }

    public static function getParseData(): array
    {
        return [
            ['16.894.365-2', 16_894_365, Verifier::Two],
            ['24  736.7322', 24_736_732, Verifier::Two],
            [' 24 232..  442  -- 0', 24_232_442, Verifier::Zero],
            ['35323325', 3_532_332, Verifier::Five],
            ['22.457.309K', 22_457_309, Verifier::K],
            ['15450088K', 15_450_088, Verifier::K],
        ];
    }

    public static function getParseWithErrorData(): array
    {
        return [
            ['212321312321-1', 'El RUT numero 212321312321 es mayor a 99.999.999'],
            ['23.232.123-K', 'El digito verificador K no es valido para el rut 23232123'],
            ['12.2324.232-P', 'Encontrado un digito verificador invalido con valor P'],
        ];
    }
}
