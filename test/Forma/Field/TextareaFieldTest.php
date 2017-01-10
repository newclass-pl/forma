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

use Forma\Field\DateField;
use Forma\Field\EmailField;
use Forma\Field\NumberField;
use Forma\Field\PasswordField;
use Forma\Field\TextareaField;

/**
 * Class PasswordFieldTest
 * @package Test\Forma\Field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class TextareaFieldTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetData(){
        $field=new TextareaField();

        $field->setData('admin1');
        $this->assertEquals('admin1',$field->getData());

    }

    /**
     *
     */
    public function testValidator(){
        $field=new TextareaField([
        ]);

        $field->setData('test');
        $this->assertTrue($field->validate()->isValid());

        $field->setData('');
        $this->assertTrue($field->validate()->isValid());


        $field=new TextareaField([
            'required'=>true,
        ]);

        $field->setData('');
        $result=$field->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals(['Value can\'t be empty.'],$result->getErrors());

    }

    /**
     *
     */
    public function testRender(){
        $field=new TextareaField([
            'label'=>'My label',
            'name'=>'field-name',
            'required'=>true,
            'id'=>'field1',
        ]);

        $this->assertEquals('<label for="field1">My label</label>',$field->labelRender());
        $this->assertEquals('<textarea name="field-name"  id="field1"  required ></textarea>',$field->componentRender());

    }
}