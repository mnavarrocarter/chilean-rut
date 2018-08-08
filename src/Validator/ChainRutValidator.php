<?php

/*
 * This file is part of the MNC\ChileanRut library.
 *
 * (c) Matías Navarro Carter <mnavarrocarter@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\ChileanRut\Validator;

use MNC\ChileanRut\Exception\InvalidRutException;
use MNC\ChileanRut\Rut;

/**
 * A ChainRutValidator.
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
     * Appends a RutValidator instance to the validation chain.
     *
     * @param RutValidator $validator
     *
     * @return ChainRutValidator
     */
    public function append(RutValidator $validator): ChainRutValidator
    {
        $this->validators[] = $validator;

        return $this;
    }

    /**
     * @param Rut $rut
     *
     * @throws InvalidRutException on invalid Rut
     */
    public function validate(Rut $rut): void
    {
        foreach ($this->validators as $validator) {
            $validator->validate($rut);
        }
    }
}
