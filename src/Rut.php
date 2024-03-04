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

use MNC\Rut\Verifier;

/**
 * Esta clase representa un RUT.
 *
 * Una vez creado, el RUT es siempre valido
 */
final readonly class Rut
{
    private const MAX_NUMBER = 999_999_999;
    private const MIN_NUMBER = 0;

    private function __construct(
        public int $number,
        public Verifier $verifier
    ) {}

    /**
     * Parsea un objeto RUT a partir de una cadena de texto.
     *
     * El RUT DEBE contener el digito verificador.
     *
     * Si no se cuenta con el verificador, el metodo create debe ser usado.
     *
     * @see Rut::create
     *
     * @throws Rut\IsInvalid si el RUT no es valido
     */
    public static function parse(string $rut): Rut
    {
        // Remove space, dots and hyphens
        $rut = \str_replace([' ', '.', '-'], '', $rut);

        return self::create(
            (int) \substr($rut, 0, -1),
            Verifier::fromString(\substr($rut, -1))
        );
    }

    /**
     * Crea un objeto RUT.
     *
     * El digito verificador es opcional. Cuando es recibido, es validado.
     *
     * Si el digito verificador no es provisto, es generado automáticamente.
     *
     * @throws Rut\IsInvalid si el Rut es invalido
     */
    public static function create(int $number, ?Verifier $verifier = null): self
    {
        if ($number < self::MIN_NUMBER) {
            throw Rut\IsInvalid::numberTooSmall($number);
        }

        if ($number > self::MAX_NUMBER) {
            throw Rut\IsInvalid::numberTooBig($number);
        }

        $computed = self::computeVerifier($number);
        if ($verifier === null) {
            return new self($number, $computed);
        }

        if ($computed !== $verifier) {
            throw Rut\IsInvalid::rut($number, $verifier);
        }

        return new self($number, $verifier);
    }

    /**
     * Compara si un RUT es igual a otro o no.
     */
    public function equals(Rut $rut): bool
    {
        return $this->number === $rut->number;
    }

    /**
     * Retorna el RUT en formato "12345678K".
     */
    public function toString(): string
    {
        return $this->number.$this->verifier->toString();
    }

    /**
     *  Retorna el RUT en formato "12345678-K".
     */
    public function toSimple(): string
    {
        return $this->number.'-'.$this->verifier->toString();
    }

    /**
     * Retorna el RUT en formato "12.345.678-K".
     */
    public function toHuman(): string
    {
        return \number_format($this->number, 0, ',', '.').'-'.$this->verifier->toString();
    }

    /**
     * Retorna los $n ultimos numeros del RUT.
     *
     * El digito verificador no es considerado.
     */
    public function last(int $n, string $pad = ''): string
    {
        $number = (string) $this->number;
        $last = \substr($number, -$n);
        if ($pad !== '') {
            $last = \str_repeat($pad, \strlen($number) - $n).$last;
        }

        return $last;
    }

    /**
     * Retorna los $n primeros numeros del RUT.
     *
     * El digito verificador no es considerado.
     */
    public function first(int $n, string $pad = ''): string
    {
        $number = (string) $this->number;
        $first = \substr($number, 0, $n);
        if ($pad !== '') {
            $first .= \str_repeat($pad, \strlen($number) - $n);
        }

        return $first;
    }

    /**
     * Computa el digito verificador de un RUT a partir del numero.
     */
    public static function computeVerifier(int $number): Verifier
    {
        $sequence = \array_reverse(\array_map(
            static fn (string $d): int => (int) $d,
            \str_split((string) $number)
        ));

        $x = 2;
        $s = 0;
        foreach ($sequence as $digit) {
            if ($x > 7) {
                $x = 2;
            }
            $s += $digit * $x;
            ++$x;
        }

        return Verifier::from(11 - ($s % 11));
    }
}
