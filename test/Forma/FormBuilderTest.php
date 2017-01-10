<?php
/**
 * Forma: Form manager
 * Copyright (c) NewClass (http://newclass.pl)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the file LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) NewClass (http://newclass.pl)
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */


namespace Test\Forma\Field;

use Forma\Field\CheckboxField;
use Forma\Field\NumberField;
use Forma\FormBuilder;
use Forma\Request;

/**
 * Class FormBuilderTest
 * @package Test\Forma
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class FormBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testSubmit()
    {
        $builder = new FormBuilder();

        $requestMock = $this->createMock(Request::class);
        $requestMock->method('getData')->willReturn([
            'checkbox' => 'on',
            'number' => '123.32'
        ]);
        $requestMock->method('getMethod')->willReturn('POST');
        $requestMock->method('isFullUploadedData')->willReturn(true);

        $builder->setRequest($requestMock);

        $builder->addField(new CheckboxField([
            'label' => 'Checkbox label',
            'name' => 'checkbox',
        ]));

        $builder->addField(new NumberField([
            'label' => 'Number label',
            'name' => 'number',
        ]));

        $builder->setData([
            'number' => 20,
        ]);

        $builder->submit();

        $this->assertTrue($builder->isConfirmed());
        $this->assertTrue($builder->isValid());
        $data = $builder->getData();
        $this->assertEquals([
            'checkbox' => 'on',
            'number' => 123.32,
        ], $data);

        $this->assertEquals('<FORM method="post"  ><div><label for="id_0">Checkbox label</label><input name="checkbox"  id="id_0"   type="checkbox" checked /></div><div><label for="id_1">Number label</label><input name="number" value="123.32" id="id_1"   type="number" /></div></FORM>',
            $builder->render());
    }

    /**
     *
     */
    public function testSubmitError()
    {
        $builder = new FormBuilder();

        $requestMock = $this->createMock(Request::class);
        $requestMock->method('getData')->willReturn([
            'checkbox' => 'on',
            'number' => 'unknown'
        ]);
        $requestMock->method('getMethod')->willReturn('POST');
        $requestMock->method('isFullUploadedData')->willReturn(true);

        $builder->setRequest($requestMock);

        $builder->addField(new CheckboxField([
            'label' => 'Checkbox label',
            'name' => 'checkbox',
        ]));

        $builder->addField(new NumberField([
            'label' => 'Number label',
            'name' => 'number',
        ]));

        $builder->setData([
            'number' => 20,
        ]);

        $builder->submit();

        $this->assertTrue($builder->isConfirmed());
        $this->assertFalse($builder->isValid());
        $data = $builder->getData();
        $this->assertEquals([], $data);

        $this->assertEquals('<FORM method="post"  ><div><label for="id_0">Checkbox label</label><input name="checkbox"  id="id_0"   type="checkbox" checked /></div><div><label for="id_1">Number label</label><input name="number" value="unknown" id="id_1"   type="number" /><ul class="errors"><li>Value is not valid number.</li></ul></div></FORM>',
            $builder->render());
    }

}