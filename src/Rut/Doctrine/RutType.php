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
use Doctrine\DBAL\Types\StringType;
use MNC\Rut;

/**
 * Mapea el RUT a una columna VARCHAR.
 */
class RutType extends StringType
{
    public const NAME = 'rut';

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param mixed $value
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Rut) {
            return $value->toHuman();
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Rut::class]);
    }

    /**
     * @param mixed $value
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Rut
    {
        if ($value === null) {
            return null;
        }

        if (\is_string($value)) {
            return Rut::parse($value);
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'string']);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): true
    {
        return true;
    }
}
