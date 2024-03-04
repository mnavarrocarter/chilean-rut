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

namespace MNC\Rut;

/**
 * Representa el digito verificador de un RUT.
 *
 * Internamente, se guarda el modulo del RUT, y no su valor como texto.
 */
enum Verifier: int
{
    case One = 1;
    case Two = 2;
    case Three = 3;
    case Four = 4;
    case Five = 5;
    case Six = 6;
    case Seven = 7;
    case Eight = 8;
    case Nine = 9;
    case K = 10;
    case Zero = 11;

    /**
     * @throws IsInvalid si el verificador es invalido
     */
    public static function fromString(string $v): Verifier
    {
        return match ($v) {
            '1' => self::One,
            '2' => self::Two,
            '3' => self::Three,
            '4' => self::Four,
            '5' => self::Five,
            '6' => self::Six,
            '7' => self::Seven,
            '8' => self::Eight,
            '9' => self::Nine,
            '0' => self::Zero,
            'K' => self::K,
            default => throw IsInvalid::verifier($v)
        };
    }

    /**
     * Retorna la representacion textual del digito verificador.
     */
    public function toString(): string
    {
        return match ($this) {
            self::One => '1',
            self::Two => '2',
            self::Three => '3',
            self::Four => '4',
            self::Five => '5',
            self::Six => '6',
            self::Seven => '7',
            self::Eight => '8',
            self::Nine => '9',
            self::K => 'K',
            self::Zero => '0',
        };
    }
}
