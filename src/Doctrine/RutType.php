<?php

declare(strict_types=1);

/**
 * @project Chilean Rut
 * @link https://github.com/mnavarrocarter/chilean-rut
 * @package mnavarrocarter/chilean-rut
 * @author Matias Navarro-Carter mnavarrocarter@gmail.com
 * @license MIT
 * @copyright 2020 Matias Navarro Carter
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\ChileanRut\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use MNC\ChileanRut\Rut;

/**
 * Class RutTextType.
 *
 * This type maps the rut to a string and stores it with the verifier number,
 * including dots and the hyphen.
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
     * @return mixed
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return $value;
        }

        if ($value instanceof Rut) {
            return (string) $value->format()->hyphened()->dotted();
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Rut::class]);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return $value;
        }

        if (is_string($value)) {
            return Rut::parse($value);
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'string']);
    }
}
