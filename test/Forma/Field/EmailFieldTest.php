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

/**
 * Class EmailFieldTest
 * @package Test\Forma\Field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class EmailFieldTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetData(){
        $field=new EmailField();

        $field->setData('test@newclass.pl');
        $this->assertEquals('test@newclass.pl',$field->getData());

    }

    /**
     *
     */
    public function testValidator(){
        $field=new EmailField();

        $field->setData('test@newclass.pl');
        $this->assertTrue($field->validate()->isValid());

        $field->setData('');
        $this->assertTrue($field->validate()->isValid());

        $field->setData('test.newclass.pl');
        $result=$field->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals(['Value is not valid format email.'],$result->getErrors());

        $field=new EmailField([
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
        $field=new EmailField([
            'label'=>'My label',
            'name'=>'field-name',
            'required'=>true,
            'id'=>'field1',
        ]);

        $this->assertEquals('<label for="field1">My label</label>',$field->labelRender());
        $this->assertEquals('<input name="field-name"  id="field1"  required type="email" />',$field->componentRender());

    }
}