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
 * A FormattedRut encapsulates logic for formatting a Rut.
 */
class FormattedRut
{
    private const HYPHENED = 1;
    private const DOTTED = 2;
    private const OBFUSCATED = 4;

    private Rut $rut;
    private int $flags;

    /**
     * FormattedRut constructor.
     */
    public function __construct(Rut $rut)
    {
        $this->rut = $rut;
        $this->flags = 0;
    }

    public function hyphened(): FormattedRut
    {
        return $this->add(self::HYPHENED);
    }

    public function dotted(): FormattedRut
    {
        return $this->add(self::DOTTED);
    }

    public function obfuscated(): FormattedRut
    {
        return $this->add(self::OBFUSCATED);
    }

    private function add(int $flag): FormattedRut
    {
        $clone = clone $this;
        $clone->flags += $flag;

        return $clone;
    }

    public function __toString(): string
    {
        $number = (string) $this->rut->getNumber();
        $verifier = $this->rut->getVerifier();
        if ($this->has(self::OBFUSCATED)) {
            $replace = str_repeat('*', strlen($number) - 3);
            $number = substr_replace($number, $replace, 0, -3);
        }

        if ($this->has(self::DOTTED)) {
            $number = substr_replace($number, '.', -3, 0);
            $number = substr_replace($number, '.', -7, 0);
        }
        if ($this->has(self::HYPHENED)) {
            return $number.'-'.$verifier;
        }

        return $number.$verifier;
    }

    private function has(int $flag): bool
    {
        return ($this->flags & $flag) !== 0;
    }
}
