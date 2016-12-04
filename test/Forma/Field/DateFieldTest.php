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

/**
 * Class DateTest
 * @package Test\Forma\Field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class DateFieldTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetData(){
        $field=new DateField();

        $field->setData('2012-01-02');
        $this->assertEquals('2012-01-02',$field->getData());

    }

    /**
     *
     */
    public function testValidator(){
        $field=new DateField();

        $field->setData('2012-12-01');
        $this->assertTrue($field->validate()->isValid());

        $field->setData('');
        $this->assertTrue($field->validate()->isValid());

        $field->setData('2012-31-12');
        $result=$field->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals(['Value is not valid format date YYYY-MM-DD.'],$result->getErrors());

        $field=new DateField([
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
        $field=new DateField([
            'label'=>'My label',
            'name'=>'field-name',
            'value'=>'2012-01-12',
            'required'=>true,
            'id'=>'field1',
        ]);

        $this->assertEquals('<label for="field1">My label</label>',$field->labelRender());
        $this->assertEquals('<input name="field-name" value="2012-01-12" required id="field1" type="date" />',$field->componentRender());

    }
}