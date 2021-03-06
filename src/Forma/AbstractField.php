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


namespace Forma;

use Judex\AbstractValidator;
use Judex\Validator\NotEmptyValidator;
use Judex\ValidatorManager;
use Judex\ValidatorNotFoundException;

/**
 * FormBuilder field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
abstract class AbstractField
{

    /**
     * @var mixed[]
     */
    private $tags;

    /**
     * @var ValidatorManager
     */
    private $validatorManager;

    /**
     * @var bool
     */
    private $valid = true;

    /**
     * @var string[]
     */
    private $errors=[];

    /**
     * @var
     */
    private $label;

    /**
     * @param mixed[] $options - array with configure data. All field is optional eg:
     * [
     *    'name'=>'{text}' //tag name
     *    ,'validator'=>'{text}' //validator class name
     *    ,'id'=>'{text}' //tag id
     *    ,'value'=>'{text}' //tag value
     *    ,'required'=>{boolean} //tag required
     *    ,...
     * ]
     */
    public function __construct($options)
    {

        $this->validatorManager = new ValidatorManager();
        if (isset($options['validator'])) {
            $this->addValidator($options['validator']);
            unset($options['validator']);
        }

        if (isset($options['label'])) {
            $this->setLabel($options['label']);
            unset($options['label']);
        }

        $options += [
            'value' => '',
            'name' => null,
            'id' => null,
            'class' => '',
            'required' => false
        ];

        $this->tags = $options;

        $this->setRequired($this->isRequired());//invoke configure validator by execute setters

    }

    /**
     * Set html tag name
     *
     * @param string $name - value of tag name:
     */
    public function setName($name)
    {
        $this->tags['name'] = $name;
    }


    /**
     * Get value of html tag name
     *
     * @return string
     */
    public function getName()
    {
        return $this->tags['name'];
    }

    /**
     * Set html tag id
     *
     * @param string $id - value of tag id:
     */
    public function setId($id)
    {
        $this->tags['id'] = $id;
    }

    /**
     * Get value of html tag id
     *
     * @return string
     */
    public function getId()
    {
        return $this->tags['id'];
    }

    /**
     * Add validator class rule
     *
     * @param AbstractValidator $validator - validator class
     */
    public function addValidator($validator)
    {
        $this->validatorManager->addValidator($validator);
    }

    /**
     * Get validators
     *
     * @return AbstractValidator[]
     */
    public function getValidators()
    {
        return $this->validatorManager->getValidators();
    }

    /**
     * Get validator class
     * @param $className
     * @return AbstractValidator
     * @throws ValidatorNotFoundException
     */
    public function getValidator($className)
    {
        return $this->validatorManager->getValidator($className);
    }

    /**
     * Add part html tag class
     *
     * @param string $name - class name:
     */
    public function addClass($name)
    {
        $classParts = explode(' ', $this->tags['class']);
        foreach ($classParts as $part) {
            if ($name == $part) {
                return;
            }
        }

        $this->tags['class'] .= ' ' . $name;
        $this->tags['class'] = trim($this->tags['class']);
    }

    /**
     * Remove part html tag class
     *
     * @param string $name - class name:
     */
    public function removeClass($name)
    {
        $classParts = explode(' ', $this->tags['class']);
        $className = '';
        foreach ($classParts as $part) {
            if ($name != $part) {
                $className .= ' ' . $part;
            }
        }

        $this->tags['class'] = trim($className);

    }

    /**
     * Get value of html tag class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->tags['class'];
    }

    /**
     * Set label name for field
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Get value of label field
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set html tag required
     *
     * @param bool $flag - if true then required else optional
     */
    public function setRequired($flag)
    {
        $this->tags['required'] = $flag;
        if($flag){
            $this->addValidator(new NotEmptyValidator());
        }
        else{
            try{
                $this->removeValidator(NotEmptyValidator::class);
            }
            catch (ValidatorNotFoundException $e){
                //ignore
            }
        }
    }

    /**
     * Get value of html tag required
     *
     * @return bool
     */
    public function isRequired()
    {
        return $this->tags['required'];
    }

    /**
     * Set html tag
     *
     * @param string $name - tag name
     * @param mixed $value - value of tag
     */
    public function setTag($name, $value)
    {
        $this->tags[$name] = $value;
    }

    /**
     * Get html tag
     *
     * @param string $name - tag name
     * @return mixed
     * @throws AttributeNotFoundException
     */
    public function getTag($name)
    {
        if (!isset($this->tags[$name])) {
            throw new AttributeNotFoundException($name);
        }
        return $this->tags[$name];
    }

    /**
     * Get all html tags
     *
     * @return mixed[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Check valid field
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * Get error message
     *
     * @return string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set error message
     *
     * @param string $error - message
     * @return $this
     */
    public function addError($error)
    {
        $this->errors[] = $error;
        $this->valid = false;
        return $this;
    }

    /**
     * @param string[] $errors
     * @return $this
     */
    public function setError($errors)
    {
        foreach ($errors as $error){
            $this->addError($error);
        }
        return $this;
    }

    /**
     * Implement render html label and field
     *
     * @return string
     */
    abstract public function render();

    /**
     * Set confirmed data
     *
     * @param mixed $data - confirmed data
     */
    abstract public function setData($data);

    /**
     * Get value field
     *
     * @return mixed
     */
    abstract public function getData();

    /**
     * Remove field data
     */
    abstract public function clearData();

    /**
     * Implement render html field
     *
     * @return string
     */
    abstract public function componentRender();

    /**
     * implement render html label
     *
     * @return string
     */
    abstract public function labelRender();

    /**
     * @return \Judex\Result
     */
    public function validate()
    {
        return $this->validatorManager->validate($this->getData());
    }

    /**
     * @param string $validatorName
     */
    private function removeValidator($validatorName)
    {
        $this->validatorManager->removeValidator($validatorName);
    }

}