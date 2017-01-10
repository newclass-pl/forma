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


namespace Forma\Formatter;

use Forma\FieldFormatter;
use Forma\FormBuilder;
use Forma\FormFormatter;

/**
 * Class SimpleFormFormatter
 * @package Forma
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class SimpleFormFormatter implements FormFormatter
{
	/**
	 * @var SimpleFieldFormatter
	 */
	private $fieldRender;

	public function __construct()
	{
		$this->fieldRender = new SimpleFieldFormatter();
	}

	/**
	 * Method generated html for form open html element
	 *
	 * @param FormBuilder $builder
	 * @return string
	 */
	public function beginRender(FormBuilder $builder)
	{
		$attributes = $builder->getAttributes();
		$template = '<FORM ';
		foreach ($attributes as $kAttribute => $attribute) {
			if ($attribute !== '' && $attribute !== null) {
				$template .= $kAttribute . '="' . $attribute . '" ';
			}
		}

		$template .= ' >';

		return $template;
	}

	/**
	 * Method generated html for form close html element
	 * @param FormBuilder $builder
	 * @return string
	 */
	public function endRender(FormBuilder $builder)
	{
		return '</FORM>';
	}

	/**
	 * @param FormBuilder $builder
	 * @return string
	 */
	public function fieldsRender(FormBuilder $builder)
	{
		$template = '';
		foreach ($builder->getFields() as $field) {
			$template .= $field->render();
		}

		return $template;
	}

	/**
	 * @param FormBuilder $builder
	 * @return string
	 */
	public function render(FormBuilder $builder)
	{
		$template = $this->beginRender($builder);
		$template .= $this->fieldsRender($builder);
		$template .= $this->endRender($builder);
		return $template;
	}

	/**
	 * @return FieldFormatter
	 */
	public function getFieldFormatter()
	{
		return $this->fieldRender;
	}
}