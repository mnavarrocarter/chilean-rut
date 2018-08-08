<?php

/*
 * This file is part of the MNC\ChileanRut library.
 *
 * (c) Matías Navarro Carter <mnavarrocarter@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\ChileanRut\Exception;

use MNC\ChileanRut\Rut;

/**
 * Class InvalidRutException.
 *
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class InvalidRutException extends \LogicException
{
    /**
     * @var Rut
     */
    private $rut;

    /**
     * InvalidRutException constructor.
     *
     * @param Rut         $rut
     * @param string|null $message
     */
    public function __construct(Rut $rut, string $message = null)
    {
        if (null === $message) {
            $message = sprintf('Rut %s is not a valid rut.', $rut->format(Rut::FORMAT_READABLE));
        }
        $this->rut = $rut;
        parent::__construct($message);
    }

    /**
     * @return Rut
     */
    public function getRut(): Rut
    {
        return $this->rut;
    }
}
