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

/**
 * Class NumberFieldTest
 * @package Test\Forma\Field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class NumberFieldTest extends \PHPUnit_Framework_TestCase
{

	/**
	 *
	 */
	public function testGetData()
	{
		$field = new NumberField();

		$field->setData('10');
		$this->assertEquals('10', $field->getData());

	}

	/**
	 *
	 */
	public function testValidator()
	{
		$field = new NumberField([
			'min' => -20,
			'max' => 30,
		]);

		$field->setData('-20');
		$this->assertTrue($field->validate()->isValid());

		$field->setData('30');
		$this->assertTrue($field->validate()->isValid());

		$field->setData('');
		$this->assertTrue($field->validate()->isValid());


		$field = new NumberField([
			'required' => true,
			'min' => -20,
			'max' => 30,
		]);

		$field->setData('0');
		$field->validate();
		$this->assertTrue($field->isValid());

		$field->setData('');
		$field->validate();
		$this->assertFalse($field->isValid());
		$this->assertEquals(['Value can\'t be empty.'], $field->getErrors());

		$field->setData('-21');
		$field->validate();
		$this->assertFalse($field->isValid());
		$this->assertEquals(['Value is too small. Min value is -20.'], $field->getErrors());

		$field->setData('31');
		$field->validate();
		$this->assertFalse($field->isValid());
		$this->assertEquals(['Value is too big. Max value is 30.'], $field->getErrors());

	}

	/**
	 *
	 */
	public function testRender()
	{
		$field = new NumberField([
			'label' => 'My label',
			'name' => 'field-name',
			'required' => true,
			'id' => 'field1',
			'min' => 10,
			'max' => 20,
		]);

		$this->assertEquals('<label for="field1">My label</label>', $field->labelRender());
		$this->assertEquals('<input name="field-name"  id="field1"  required min="10" max="20" type="number" />', $field->componentRender());

	}
}