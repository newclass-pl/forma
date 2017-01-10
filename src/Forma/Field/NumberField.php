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


namespace Forma\Field;

use Judex\Validator\NumberValidator;
use Judex\ValidatorNotFoundException;

/**
 * FormBuilder field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class NumberField extends InputField
{

	/**
	 * {@inheritdoc}
	 */
	public function __construct($options = [])
	{

		$this->options = array_merge($this->options, ['min', 'max']);

		$options['type'] = 'number';

		parent::__construct($options);

		if(!$this->isValidator(NumberValidator::class)){
			$this->addValidator(new NumberValidator());
		}

	}

	/**
	 * Set html tag min
	 *
	 * @param int $value - value of tag min
	 */
	public function setMin($value)
	{
		$this->setAttribute('min', $value);
		try {
			/**
			 * @var NumberValidator $validator
			 */
			$validator = $this->getValidator(NumberValidator::class);
		} catch (ValidatorNotFoundException $e) {
			$validator=new NumberValidator();
			$this->addValidator($validator);
		}

		$validator->setMin($value);

	}

	/**
	 * Get html tag min
	 *
	 * @return int - value of tag min
	 */
	public function getMin()
	{
		return $this->getAttribute('min');
	}

	/**
	 * Set html tag max
	 *
	 * @param int $value - value of tag max
	 */
	public function setMax($value)
	{
		$this->setAttribute('max', $value);
		try {
			/**
			 * @var NumberValidator $validator
			 */
			$validator = $this->getValidator(NumberValidator::class);
		} catch (ValidatorNotFoundException $e) {
			$validator=new NumberValidator();
			$this->addValidator($validator);
		}
		$validator->setMax($value);
	}

	/**
	 * Get html tag max
	 *
	 * @return int - value of tag max
	 */
	public function getMax()
	{
		return $this->getAttribute('max');
	}

}