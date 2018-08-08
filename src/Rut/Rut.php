<?php

namespace MNC\ChileanRut\Rut;

use MNC\ChileanRut\Validator\RutValidator;

/**
 * Class Rut
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class Rut
{
    public const FORMAT_HYPHENED = 0;   // 14533535-5
    public const FORMAT_CLEAR = 1;      // 145335355
    public const FORMAT_READABLE = 2;   // 14.533.535-5

    /**
     * @var string
     */
    private $value;
    /**
     * @var string
     */
    private $dv;

    /**
     * Rut constructor.
     * @param string            $rut
     * @param RutValidator|null $validator if provided validates the Rut.
     */
    public function __construct(string $rut, RutValidator $validator = null)
    {
        $sanitized = $this->sanitize($rut);
        $this->value = substr($sanitized, 0, -1);
        $this->dv = $sanitized[\strlen($sanitized) - 1];

        if (null !== $validator) {
            $validator->validate($this);
        }
    }

    /**
     * @param string $correlative
     * @param string $verifierDigit
     * @return Rut
     */
    public static function fromParts(string $correlative, string $verifierDigit): Rut
    {
        return new self($correlative.$verifierDigit);
    }

    /**
     * @param string $rut
     * @return Rut
     */
    public static function fromString(string $rut): Rut
    {
        return new self($rut);
    }

    /**
     * @param Rut $rut
     * @return bool
     */
    public function isEqualTo(Rut $rut): bool
    {
        return $this->format() === $rut->format();
    }

    /**
     * @param string $value
     * @return string
     */
    private function sanitize(string $value): string
    {
        $value = trim($value);
        $value = strtoupper($value);
        return str_replace(['.', ',', '-'], '', $value);
    }

    /**
     * @param int $format One of the FORMAT_ constants.
     * @return string
     */
    public function format(int $format = 0): string
    {
        switch ($format) {
            case self::FORMAT_HYPHENED:
                return $this->value . '-' . $this->dv;
                break;
            case self::FORMAT_CLEAR:
                return $this->value . $this->dv;
                break;
            case self::FORMAT_READABLE:
                return sprintf('%s-%s', number_format($this->value, 0, '', '.'), $this->dv);
                break;
            default:
                throw new \InvalidArgumentException(
                    sprintf(
                        'Argument provided for %s method of class %s is invalid.',
                        __METHOD__,
                        __CLASS__
                    )
                );
        }
    }

    /**
     * @return string
     */
    public function getCorrelative(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getVerifierDigit(): string
    {
        return $this->dv;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->format(self::FORMAT_READABLE);
    }
}