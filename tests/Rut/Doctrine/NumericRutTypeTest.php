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

namespace MNC\Rut\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use MNC\Rut;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(NumericRutType::class)]
#[CoversClass(Rut::class)]
#[CoversClass(Rut\Verifier::class)]
class NumericRutTypeTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        Type::addType(NumericRutType::NAME, NumericRutType::class);
    }

    public function testItConvertsNullFromDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = Type::getType(NumericRutType::NAME);
        $result = $type->convertToPHPValue(null, $platform);
        self::assertNull($result);
    }

    public function testItConvertsStringFromDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = Type::getType(NumericRutType::NAME);
        $result = $type->convertToPHPValue(16894365, $platform);
        self::assertInstanceOf(Rut::class, $result);
    }

    public function testItConvertsNullToDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = Type::getType(NumericRutType::NAME);
        $result = $type->convertToDatabaseValue(null, $platform);
        self::assertNull($result);
    }

    public function testItConvertsRutToDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = Type::getType(NumericRutType::NAME);
        $result = $type->convertToDatabaseValue(Rut::parse('168943652'), $platform);
        self::assertSame('16894365', $result);
    }

    public function testItCannotConvertToDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $type = Type::getType(NumericRutType::NAME);
        $this->expectException(ConversionException::class);
        $type->convertToDatabaseValue(new \DateTime(), $platform);
    }

    #[Test]
    public function it_returns_true_for_comment(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $this->assertTrue(Type::getType(NumericRutType::NAME)->requiresSQLCommentHint($platform));
    }
}
