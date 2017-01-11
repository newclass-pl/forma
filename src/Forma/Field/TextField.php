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

use Judex\Validator\LengthValidator;
use Judex\ValidatorNotFoundException;

/**
 * FormBuilder field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class TextField extends InputField
{
	/**
	 * {@inheritdoc}
	 */
	public function __construct($options = [])
	{
		$this->options = array_merge($this->options, ['collection', 'emptyRecord', 'maxLength']);

		$options['type'] = 'text';
		parent::__construct($options);
	}

	/**
	 * @param int $maxLength
	 */
	public function setMaxLength($maxLength)
	{
		try {
			$this->removeValidator(LengthValidator::class);
		} catch (ValidatorNotFoundException $e) {
			//ignore
		}

		$this->addValidator(new LengthValidator([
			'max' => $maxLength,
		]));

		$this->setAttribute('maxLength', $maxLength);
	}

}