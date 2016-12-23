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

use Forma\Formatter\SimpleFieldFormatter;
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
    private $attributes;
    /**
     * @var ValidatorManager
     */
    protected $validatorManager;
    /**
     * @var bool
     */
    private $valid = true;
    /**
     * @var string[]
     */
    private $errors=[];
    /**
     * @var string
     */
    private $label;
    /**
     * @var FieldFormatter
     */
    private $formatter;
    /**
     * @var string[]
     */
    private $prefix;

    /**
     * @var string[]
     */
    private $specialRender=['id','name'];
    /**
     * @param mixed[] $options - array with configure data. All field is optional eg:
     * [
     *    'name'=>'{text}' //attribute name
     *    ,'validator'=>'{text}' //validator class name
     *    ,'id'=>'{text}' //attribute id
     *    ,'value'=>'{text}' //attribute value
     *    ,'required'=>{boolean} //attribute required
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

        if(isset($options['formatter'])){
            $this->setFormatter($options['formatter']);
            unset($options['formatter']);
        }
        else{
            $this->setFormatter(new SimpleFieldFormatter());
        }

        $options += [
            'name'=>'',
            'value' => '',
            'id' => null,
            'class' => '',
            'required' => false
        ];

        $this->attributes = $options;

        $this->setRequired($this->isRequired());//invoke configure validator by execute setters

    }

    /**
     * @param FieldFormatter $formatter
     * @return AbstractField
     */
    public function setFormatter(FieldFormatter $formatter){
        $this->formatter=$formatter;
        return $this;
    }

    /**
     * @return FieldFormatter
     */
    public function getFormatter()
    {
        return $this->formatter;
    }

    /**
     * @return bool
     */
    public function isCustomFormatter(){
        return !($this->formatter instanceof SimpleFieldFormatter);
    }

    /**
     * Set html attribute name
     *
     * @param string $name - value of attribute name:
     * @return AbstractField
     */
    public function setName($name)
    {
        $this->attributes['name'] = $name;
        return $this;
    }


    /**
     * Get value of html attribute name
     *
     * @return string
     */
    public function getName()
    {
        return $this->attributes['name'];
    }

    /**
     * Set html attribute id
     *
     * @param string $id - value of attribute id:
     * @return AbstractField
     */
    public function setId($id)
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    /**
     * Get value of html attribute id
     *
     * @return string
     */
    public function getId()
    {
        return $this->attributes['id'];
    }

    /**
     * Add validator class rule
     *
     * @param AbstractValidator $validator - validator class
     * @return AbstractField
     */
    public function addValidator($validator)
    {
        $this->validatorManager->addValidator($validator);
        return $this;
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
     * Add part html attribute class
     *
     * @param string $name - class name:
     * @return AbstractField
     */
    public function addClass($name)
    {
        $classParts = explode(' ', $this->attributes['class']);
        foreach ($classParts as $part) {
            if ($name === $part) {
                return $this;
            }
        }

        $this->attributes['class'] .= ' ' . $name;
        $this->attributes['class'] = trim($this->attributes['class']);

        return $this;
    }

    /**
     * Remove part html attribute class
     *
     * @param string $name - class name:
     * @return AbstractField
     */
    public function removeClass($name)
    {
        $classParts = explode(' ', $this->attributes['class']);
        $className = '';
        foreach ($classParts as $part) {
            if ($name != $part) {
                $className .= ' ' . $part;
            }
        }

        $this->attributes['class'] = trim($className);

        return $this;
    }

    /**
     * Get value of html attribute class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->attributes['class'];
    }

    /**
     * Set label name for field
     *
     * @param string $label
     * @return AbstractField
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
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
     * Set html attribute required
     *
     * @param bool $flag - if true then required else optional
     * @return AbstractField
     */
    public function setRequired($flag)
    {
        $this->attributes['required'] = $flag;
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

        return $this;
    }

    /**
     * Get value of html attribute required
     *
     * @return bool
     */
    public function isRequired()
    {
        return $this->attributes['required'];
    }

    /**
     * Set html attribute
     *
     * @param string $name - attribute name
     * @param mixed $value - value of attribute
     * @return AbstractField
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * Get html attribute
     *
     * @param string $name - attribute name
     * @return mixed
     * @throws AttributeNotFoundException
     */
    public function getAttribute($name)
    {
        if (!isset($this->attributes[$name])) {
            throw new AttributeNotFoundException($name);
        }
        return $this->attributes[$name];
    }

    /**
     * Get all html attributes
     *
     * @return mixed[]
     */
    public function getAttributes()
    {
        return $this->attributes;
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
     * @return AbstractField
     */
    public function addError($error)
    {
        $this->errors[] = $error;
        $this->valid = false;
        return $this;
    }

    /**
     * @param string[] $errors
     * @return AbstractField
     */
    public function setErrors($errors)
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
    public function render(){
        return $this->formatter->render($this);
    }

    /**
     * @param string[] $prefix
     */
    public function setPrefix(array $prefix){
        $this->prefix=$prefix;
    }

    /**
     * @return string[]
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

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
     * @return AbstractField
     */
    public function validate()
    {
        $result=$this->validatorManager->validate($this->getData());
        if(!$result->isValid()){
            $this->setErrors($result->getErrors());
        }

        return $this;
    }

    /**
     * @param string $validatorName
     */
    protected function removeValidator($validatorName)
    {
        $this->validatorManager->removeValidator($validatorName);
    }

    /**
     * @return string[]
     */
    public function getAttributesName()
    {
        return array_keys($this->getAttributes());
    }

    /**
     * @param string $name
     * @return string
     */
    protected function attributeRender($name)
    {
        if(in_array($name,$this->specialRender)){
            $method=$name.'Render';
            return call_user_func([$this,$method]);
        }

        $template='';
        $value=$this->getAttribute($name);
        if (in_array($value, [
            '',
            false,
            null
        ], true)) {
            return $template;
        }

        $template .= $name;

        if ($value !== true) {
            $template .= '="' . htmlspecialchars($value) . '"';
        }

        return $template;
    }

    /**
     * @return string
     */
    protected function nameRender(){
        $partsName=$this->prefix;
        $partsName[]=$this->getAttribute('name');
        $nameMain=$partsName[0];
        array_shift($partsName);

        $template='name="';
        $template.=$nameMain;
        foreach($partsName as $partName){
            $template.='['.$partName.']';
        }
        $template.='"';

        return $template;
    }

    /**
     * @return string
     */
    protected function idRender(){
        $partsName=$this->prefix;
        $partsName[]=$this->getAttribute('name');

        $template='id="';
        $template.=implode('_',$partsName);
        $template.='"';

        return $template;
    }

}