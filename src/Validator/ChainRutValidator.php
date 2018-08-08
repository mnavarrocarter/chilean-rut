<?php

namespace MNC\ChileanRut\Validator;

use MNC\ChileanRut\Exception\InvalidRutException;
use MNC\ChileanRut\Rut\Rut;

/**
 * A ChainRutValidator
 *
 * Use this implementation when you want to validate a Rut against multiple
 * validators. Add the validators in order by calling addValidator().
 *
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class ChainRutValidator implements RutValidator
{
    /**
     * @var RutValidator[]
     */
    private $validators;

    /**
     * ChainRutValidator constructor.
     */
    public function __construct()
    {
        $this->validators = [];
    }

    /**
     * @param RutValidator $validator
     * @return ChainRutValidator
     */
    public function addValidator(RutValidator $validator): ChainRutValidator
    {
        $this->validators[] = $validator;
        return $this;
    }

    /**
     * @param Rut $rut
     * @throws InvalidRutException on invalid Rut.
     */
    public function validate(Rut $rut): void
    {
        foreach ($this->validators as $validator) {
            $validator->validate($rut);
        }
    }
}