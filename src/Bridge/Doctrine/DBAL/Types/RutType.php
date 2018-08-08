<?php

namespace MNC\ChileanRut\Bridge\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use MNC\ChileanRut\Rut\Rut;

/**
 * Class RutType
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class RutType extends StringType
{
    public const NAME = 'rut';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return $value;
        }

        if ($value instanceof Rut) {
            return parent::convertToDatabaseValue($value->format(), $platform);
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'Rut']);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);

        if ($value === null || $value instanceof Rut) {
            return $value;
        }

        return new Rut($value);
    }
}