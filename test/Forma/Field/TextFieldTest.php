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
use Forma\Field\TextField;

/**
 * Class TextFieldTest
 * @package Test\Forma\Field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class TextFieldTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetData(){
        $field=new TextField();

        $field->setData('data');
        $this->assertEquals('data',$field->getData());

    }

    /**
     *
     */
    public function testValidator(){
        $field=new TextField([
            'pattern'=>'\d{2}',
        ]);

        $field->setData('');
        $this->assertTrue($field->validate()->isValid());

        $field->setData('35');
        $this->assertTrue($field->validate()->isValid());

        $field=new TextField([
            'required'=>true,
            'pattern'=>'^\d{2}$',
        ]);

        $field->setData('');
        $result=$field->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals(['Value can\'t be empty.'],$result->getErrors());

        $field->setData('saw');
        $result=$field->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals(['Value is not validated by pattern.'],$result->getErrors());

        $field->setData('364');
        $result=$field->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals(['Value is not validated by pattern.'],$result->getErrors());

    }

    /**
     *
     */
    public function testRender(){
        $field=new TextField([
            'label'=>'My label',
            'name'=>'field-name',
            'required'=>true,
            'id'=>'field1',
            'pattern'=>'template'
        ]);

        $this->assertEquals('<label for="field1">My label</label>',$field->labelRender());
        $this->assertEquals('<input name="field-name"  id="field1"  required pattern="template" type="text" />',$field->componentRender());

    }
}