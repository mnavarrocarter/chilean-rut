<?php

namespace MNC\ChileanRut\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use MNC\ChileanRut\Rut;
use PHPUnit\Framework\TestCase;

class RutTypeTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        Type::addType(RutType::NAME, RutType::class);
    }

    public function testItConvertsNullFromDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = Type::getType(RutType::NAME);
        $result = $type->convertToPHPValue(null, $platform);
        self::assertNull($result);
    }

    public function testItConvertsStringFromDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = Type::getType(RutType::NAME);
        $result = $type->convertToPHPValue('16.894.365-2', $platform);
        self::assertInstanceOf(Rut::class, $result);
    }

    public function testItCannotConvertFromDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = Type::getType(RutType::NAME);
        $this->expectException(ConversionException::class);
        $type->convertToPHPValue(true, $platform);
    }

    public function testItConvertsNullToDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = Type::getType(RutType::NAME);
        $result = $type->convertToDatabaseValue(null, $platform);
        self::assertNull($result);
    }

    public function testItConvertsRutToDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = Type::getType(RutType::NAME);
        $result = $type->convertToDatabaseValue(Rut::parse('168943652'), $platform);
        self::assertSame('16.894.365-2', $result);
    }

    public function testItCannotConvertToDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = Type::getType(RutType::NAME);
        $this->expectException(ConversionException::class);
        $type->convertToDatabaseValue(new \DateTime(), $platform);
    }
}
