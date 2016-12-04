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
    private $accept;
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
     * @param string $messageType
     * @param string $messageTooBig
     */
    public function __construct($messageType='Value is not valid file type. Allow: "${accept}".',$messageTooBig='File is too big. Max size is "${maxSize}".')
    {
        $this->messageType = $messageType;
        $this->messageTooBig = $messageTooBig;
    }

    /**
     * Implement method to validate value.
     *
     * @param mixed $value - value to parse
     * @param Result $result
     */
    public function validate($value, Result $result)
    {
        $values=['value'=>$value,'maxSize'=>$this->maxSize,'accept'=>$this->accept];
        if(!preg_match('/'.str_replace(['*','/'],['.+','\\/'],$this->accept).'/' ,$value->getExtension())){
            $result->addError($this->messageType,$values);
        }

        if($value->getSize()>$this->maxSize){
            $result->addError($this->messageTooBig,$values);
        }

    }

    /**
     * @param string $accept
     */
    public function setAccept($accept)
    {
        $this->accept = $accept;
    }

    /**
     * @param int $maxSize
     */
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
    }
}