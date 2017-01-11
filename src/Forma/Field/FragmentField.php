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


use Forma\AbstractField;
use Forma\FieldFormatter;
use Forma\FieldNotFoundException;

/**
 * Class FragmentField
 * @package Forma\Field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class FragmentField extends AbstractField
{
    /**
     * @var AbstractField[]
     */
    private $fields=[];
    /**
     * @var mixed[]
     */
    private $data;

    /**
     * FragmentField constructor.
     * @param mixed[] $options
     */
    public function __construct($options=[])
    {
        $this->options=array_merge($this->options,['fields']);

        parent::__construct($options);
    }

    /**
     * Set confirmed data
     *
     * @param mixed $data - confirmed data
     */
    public function setData($data)
    {
        foreach ($this->fields as $field){
            if (isset($data[$field->getName()])) {
                $field->setData($data[$field->getName()]);
            }
        }
    }

    /**
     * Get value field
     *
     * @return mixed
     */
    public function getData()
    {
    	$data=[];
    	foreach($this->fields as $field){
    		$data[$field->getName()]=$field->getData();
		}
        return $data;
    }

    /**
     * Remove field data
     */
    public function clearData()
    {
        $this->data = null;
    }

    /**
     * Implement render html field
     *
     * @return string
     */
    public function componentRender()
    {
        $template='';
        $prefix=$this->getPrefix();
        $prefix[]=$this->getName();
        foreach($this->getFields() as $field){
            $field->setPrefix($prefix);
            $template.=$field->render();
        }
        return $template;
    }

    /**
     * implement render html label
     *
     * @return string
     */
    public function labelRender()
    {
        return '<label for="' . $this->getId() . '">' . htmlspecialchars($this->getLabel()) . '</label>';
    }

    /**
     * @param AbstractField[] $fields
     */
    public function setFields($fields){
        $this->fields=[];
        foreach ($fields as $field){
            $this->addField($field);
        }
    }

    /**
     * @param AbstractField $field
     */
    public function addField($field)
    {
        $this->fields[]=$field;
        if($this->getFormatter() && $field->getFormatter()===null){
            $field->setFormatter($this->getFormatter());
        }
    }

    /**
     * @param FieldFormatter $formatter
     * @return AbstractField
     */
    public function setFormatter(FieldFormatter $formatter)
    {
        foreach ($this->getFields() as $field){
            if($field->getFormatter()===null){
                $field->setFormatter($formatter);
            }
        }
        return parent::setFormatter($formatter);
    }

    /**
     * @return AbstractField[]
     */
    public function getFields(){
        return $this->fields;
    }

    /**
     * @param string $name
     * @return AbstractField
     * @throws FieldNotFoundException
     */
    public function getField($name){
        foreach ($this->fields as $field) {
            if ($field->getName() == $name) {
                return $field;
            }
        }

        throw new FieldNotFoundException($name);
    }

    /**
     * @return AbstractField
     */
    public function validate()
    {
        $errors=[];
        foreach($this->fields as $field){
            $field->validate();
            if($field->isValid()){
               continue;
            }

            foreach($field->getErrors() as $error){
                $errors[]=$field->getLabel().': '.$error;
            }
        }

        $this->setErrors($errors);
        return $this;
    }

    /**
     *
     */
    public function __clone(){
        foreach ($this->fields as &$field){
            $field=clone $field;
        }
    }
}