<?php
/**
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Michal Tomczak <michal.tomczak@newaxis.pl>
 *
 * @copyright     Copyright (c) Newaxis (http://newaxis.pl)
 * @link          https://cogitary-polisy.aria.pl
 * @license       http://www.binpress.com/license/view/l/b0e782df3e50d424a32d613af2c4937b
 */


namespace Forma;


use Judex\AbstractValidator;
use Judex\Result;

class FileValidator extends AbstractValidator
{
	/**
	 * @var string
	 */
	private $accept='';
	/**
	 * @var int
	 */
	private $maxSize;
	/**
	 * @var string
	 */
	private $messageType;
	/**
	 * @var string
	 */
	private $messageTooBig;

	/**
	 * FileValidator constructor.
	 * @param mixed[] $options
	 */
	public function __construct($options = [])
	{
		$options += ['messageType' => 'Value is not valid file type. Allow: "${accept}".', 'messageTooBig' => 'File is too big. Max size is "${maxSize}".'];
		parent::__construct($options);
	}

	/**
	 * @return string
	 */
	public function getAccept()
	{
		return $this->accept;
	}

	/**
	 * @param string $accept
	 * @return FileValidator
	 */
	public function setAccept($accept)
	{
		$this->accept = $accept;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getMaxSize()
	{
		return $this->maxSize;
	}

	/**
	 * @param int $maxSize
	 * @return FileValidator
	 */
	public function setMaxSize($maxSize)
	{
		$this->maxSize = $maxSize;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMessageType()
	{
		return $this->messageType;
	}

	/**
	 * @param string $messageType
	 * @return FileValidator
	 */
	public function setMessageType($messageType)
	{
		$this->messageType = $messageType;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMessageTooBig()
	{
		return $this->messageTooBig;
	}

	/**
	 * @param string $messageTooBig
	 * @return FileValidator
	 */
	public function setMessageTooBig($messageTooBig)
	{
		$this->messageTooBig = $messageTooBig;
		return $this;
	}

	/**
	 * Implement method to validate value.
	 *
	 * @param mixed $value - value to parse
	 * @param Result $result
	 */
	public function validate($value, Result $result)
	{
		$values = ['value' => $value, 'maxSize' => $this->maxSize, 'accept' => $this->accept];
		if (!preg_match('/' . str_replace(['*', '/'], ['.+', '\\/'], $this->accept) . '/', $value->getExtension())) {
			$result->addError($this->messageType, $values);
		}

		if ($this->maxSize!==null && $value->getSize() > $this->maxSize) {
			$result->addError($this->messageTooBig, $values);
		}

	}

}