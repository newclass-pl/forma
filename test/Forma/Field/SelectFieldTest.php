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

use Forma\Field\SelectField;

/**
 * Class SelectFieldTest
 * @package Test\Forma\Field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class SelectFieldTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetData()
    {
        $field = new SelectField();
        $field->setCollection($this->createCollection([
            '1' => 'r1',
            '2' => 'r2',
        ]));
        $field->setData(1);
        $this->assertEquals(1, $field->getData());

    }

    /**
     *
     */
    public function testValidator()
    {
        $field = new SelectField([
            'collection' => $this->createCollection([
                '1' => 'r1',
                '2' => 'r2',
            ]),
        ]);

        $field->setData(1);
        $this->assertTrue($field->validate()->isValid());

        $field = new SelectField([
            'collection' => $this->createCollection([
                '1' => 'r1',
                '2' => 'r2',
            ]),
            'multiple' => true,
        ]);

        $field->setData([
            1,
            2
        ]);
        $this->assertTrue($field->validate()->isValid());

        $field->setData('');
        $this->assertTrue($field->validate()->isValid());

        $field = new SelectField([
            'collection' => $this->createCollection([
                '1' => 'r1',
                '2' => 'r2',
            ]),
            'required' => true,
        ]);


        $field->setData('');
        $result = $field->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals(['Value can\'t be empty.'], $result->getErrors());

        $field->setData(3);
        $result = $field->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals(['Collection does not contain value "3". Available items: "1, 2".'], $result->getErrors());

//        $field->setData([1,2]);//TODO check multiple flag
//        $result = $field->validate();
//        $this->assertFalse($result->isValid());
//        $this->assertEquals(['Value can\'t be empty.'], $result->getErrors());

    }

    /**
     *
     */
    public function testRender()
    {
        $field = new SelectField([
            'label' => 'My label',
            'name' => 'field-name',
            'required' => true,
            'id' => 'field1',
            'collection' => $this->createCollection([
                '1' => 'r1',
                '2' => 'r2',
            ]),
        ]);

        $this->assertEquals('<label for="field1">My label</label>', $field->labelRender());
        $this->assertEquals('<select name="field-name" required id="field1" ><option value="1" >r1</option><option value="2" >r2</option></select>',
            $field->componentRender());

    }

    private function createCollection($data)
    {
        $values=[];
        foreach($data as $key=>$record){
            $values[]=['value'=>$key,'label'=>$record];
        }

        return $values;
    }
}