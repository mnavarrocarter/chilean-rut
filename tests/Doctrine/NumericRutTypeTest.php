<?php

namespace MNC\ChileanRut\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use MNC\ChileanRut\Rut;
use PHPUnit\Framework\TestCase;

class NumericRutTypeTest extends TestCase
{
    public function testItConvertsNullFromDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = new NumericRutType();
        $result = $type->convertToPHPValue(null, $platform);
        self::assertNull($result);
    }

    public function testItConvertsStringFromDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = new NumericRutType();
        $result = $type->convertToPHPValue(16894365, $platform);
        self::assertInstanceOf(Rut::class, $result);
    }

    public function testItConvertsNullToDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = new NumericRutType();
        $result = $type->convertToDatabaseValue(null, $platform);
        self::assertNull($result);
    }

    public function testItConvertsRutToDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = new NumericRutType();
        $result = $type->convertToDatabaseValue(Rut::parse('168943652'), $platform);
        self::assertSame('16894365', $result);
    }

    public function testItCannotConvertToDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = new NumericRutType();
        $this->expectException(ConversionException::class);
        $type->convertToDatabaseValue(new \DateTime(), $platform);
    }
}
