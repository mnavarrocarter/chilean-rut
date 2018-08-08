<?php

/*
 * This file is part of the MNC\ChileanRut library.
 *
 * (c) Matías Navarro Carter <mnavarrocarter@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MNC\ChileanRut\Tests\Bridge\Symfony\Form;

use MNC\ChileanRut\Bridge\Symfony\Form\RutType;
use MNC\ChileanRut\Rut;
use Symfony\Component\Form\Test\TypeTestCase;

class RutTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $objectToCompare = new Rut('16.894.365-2');

        // $objectToCompare will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(RutType::class);

        // submit the data to the form directly
        $form->submit('16.894.365-2');

        $this->assertTrue($form->isSynchronized());

        $formData = $form->getData();

        // check that $objectToCompare was modified as expected when the form was submitted
        $this->assertInstanceOf(Rut::class, $formData);
        $this->assertTrue($formData->isEqualTo($objectToCompare));

        $view = $form->createView();

        $this->assertSame('16.894.365-2', $view->vars['value']);
    }
}
