<?php

namespace MNC\ChileanRut\Exception;

use MNC\ChileanRut\Rut\Rut;

/**
 * Class InvalidRutException
 * @package MNC\ChileanRut\Rut
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
     * @param Rut $rut
     */
    public function __construct(Rut $rut)
    {
        $message = sprintf('Rut %s is not a valid rut.', $rut->format(Rut::FORMAT_READABLE));
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