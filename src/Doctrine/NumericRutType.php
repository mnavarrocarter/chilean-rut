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
use Doctrine\DBAL\Types\IntegerType;
use MNC\ChileanRut\Rut;

/**
 * Class NumericRutType.
 *
 * This type maps the rut to a number table and stores it without the verifier
 * digit. This is because the digit is derived from the number.
 */
class NumericRutType extends IntegerType
{
    public const NAME = 'numeric-rut';

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
            return (string) $value->getNumber();
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Rut::class]);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);

        if ($value === null) {
            return $value;
        }

        return Rut::create($value);
    }
}
