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

namespace MNC\ChileanRut;

/**
 * Rut represents a the Chilean National ID Number.
 *
 * All residents of Chile are uniquely identified by one of these and it is
 * mainly used for tax purposes.
 */
class Rut
{
    private const VALID_VERIFIERS = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'K'];

    /**
     * The actual RUT number.
     */
    private int $number;
    /**
     * The RUT verifier digit.
     */
    private string $verifier;

    public static function parse(string $rut): Rut
    {
        // Remove space, dots and hyphens
        $rut = str_replace([' ', '.', '-'], '', $rut);

        return new self(
            (int) substr($rut, 0, -1),
            substr($rut, -1)
        );
    }

    /**
     * Creates a valid rut out of a number.
     */
    public static function create(int $number): Rut
    {
        $verifier = self::calculateVerifier($number);

        return new Rut($number, $verifier);
    }

    /**
     * Rut constructor.
     *
     * @throws InvalidRut if the verifier digit is invalid
     */
    public function __construct(int $number, string $verifier)
    {
        $this->number = $number;
        $this->verifier = strtoupper($verifier);
        $this->guard();
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getVerifier(): string
    {
        return $this->verifier;
    }

    /**
     * Compares whether a Rut is equal to another or not.
     */
    public function equals(Rut $rut): bool
    {
        return $this->number === $rut->number;
    }

    /**
     * Formats a Rut to a string.
     */
    public function format(): FormattedRut
    {
        return new FormattedRut($this);
    }

    private function guard(): void
    {
        // Check if rut is between zero and 999.999.999
        if ($this->number < 0 || $this->number > 999_999_999) {
            throw InvalidRut::number();
        }
        // Check if the verifier digit is in the range of valid ones
        if (!in_array($this->verifier, self::VALID_VERIFIERS, true)) {
            throw InvalidRut::digit($this->verifier);
        }
        // Check the verifier is algorithmically correct
        if ($this->verifier !== self::calculateVerifier($this->number)) {
            throw InvalidRut::digit($this->verifier);
        }
    }

    /**
     * Calculates a verifier digit from a number.
     */
    private static function calculateVerifier(int $number): string
    {
        /** @var list<int> $sequence */
        $sequence = array_filter(array_reverse(str_split((string) $number)), function($d) {
            return preg_match('/\d/',$d);
        });
        $x = 2;
        $s = 0;
        foreach ($sequence as $digit) {
            if ($x > 7) {
                $x = 2;
            }
            $s += $digit * $x;
            ++$x;
        }
        $dv = 11 - ($s % 11);
        if ($dv === 10) {
            $dv = 'K';
        }
        if ($dv === 11) {
            $dv = '0';
        }

        return (string) $dv;
    }
}
