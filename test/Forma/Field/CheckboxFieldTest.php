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

/**
 * Class CheckboxFieldTest
 * @package Test\Forma\Field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class CheckboxFieldTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testChecked(){
        $field=new CheckboxField();

        $field->setData(true);
        $this->assertTrue($field->isChecked());

        $field->setChecked(false);
        $this->assertFalse($field->isChecked());
    }

    /**
     *
     */
    public function testGetData(){
        $field=new CheckboxField();

        $field->setData(true);
        $this->assertEquals('on',$field->getData());

        $field->setValue('val');
        $this->assertEquals('val',$field->getData());

        $field->setData(false);
        $this->assertEquals(null,$field->getData());

    }

    /**
     *
     */
    public function testValidator(){
        $field=new CheckboxField([
            'required'=>true,
        ]);

        $field->setData('on');
        $this->assertTrue($field->validate()->isValid());

        $field->setData('');

        $result=$field->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals(['Value can\'t be empty.'],$result->getErrors());
    }

    /**
     *
     */
    public function testRender(){
        $field=new CheckboxField([
            'label'=>'My label',
            'name'=>'field-name',
            'value'=>'value',
            'required'=>true,
            'id'=>'field1',
            'checked'=>true,
        ]);

        $this->assertEquals('<label for="field1">My label</label>',$field->labelRender());
        $this->assertEquals('<input name="field-name" value="value" required id="field1" checked type="checkbox" />',$field->componentRender());

    }
}