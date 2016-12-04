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

/**
 * Class PasswordFieldTest
 * @package Test\Forma\Field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class PasswordFieldTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetData(){
        $field=new PasswordField();

        $field->setData('admin1');
        $this->assertEquals('admin1',$field->getData());

    }

    /**
     *
     */
    public function testValidator(){
        $field=new PasswordField([
        ]);

        $field->setData('test');
        $this->assertTrue($field->validate()->isValid());

        $field->setData('');
        $this->assertTrue($field->validate()->isValid());


        $field=new PasswordField([
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
        $field=new PasswordField([
            'label'=>'My label',
            'name'=>'field-name',
            'value'=>'20',
            'required'=>true,
            'id'=>'field1',
        ]);

        $this->assertEquals('<label for="field1">My label</label>',$field->labelRender());
        $this->assertEquals('<input name="field-name" value="20" required id="field1" type="password" />',$field->componentRender());

    }
}