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

/**
 * Class FragmentField
 * @package Forma\Field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class MultipleField extends AbstractField
{
    /**
     * @var AbstractField
     */
    private $field;
    /**
     * @var mixed[]
     */
    private $data=[];

    /**
     * @var AbstractField[]
     */
    private $dataFields=[];

    /**
     * FragmentField constructor.
     * @param mixed[] $options
     */
    public function __construct($options=[])
    {
		$this->options=array_merge($this->options,['field']);

		parent::__construct($options);
    }

    /**
     * Set confirmed data
     *
     * @param mixed $data - confirmed data
     */
    public function setData($data)
    {
        if(!$data){
            $data=[];
        }
        $this->data=$data;
        $index=0;
        foreach($this->data as $record){
            $prefix=[];
            $prefix[]=$this->getName();
            $prefix[]=$index++;
            $dataField=clone $this->field;
            $dataField->setPrefix($prefix);
            $dataField->setData($record[$dataField->getName()]);
            $this->dataFields[]=$dataField;
        }
    }

    /**
     * Get value field
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
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
        foreach($this->dataFields as $dataField){
            $template.=$dataField->render();
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
     * @param AbstractField $field
     */
    public function setField($field)
    {
        $this->field=$field;
        if($this->getFormatter() && !$field->isCustomFormatter()){
            $field->setFormatter($this->getFormatter());
        }
    }

    /**
     * @param FieldFormatter $formatter
     * @return AbstractField
     */
    public function setFormatter(FieldFormatter $formatter)
    {
        if(!$this->getField()->isCustomFormatter()){
            $this->getField()->setFormatter($formatter);
        }

        return parent::setFormatter($formatter);
    }

    /**
     * @return AbstractField
     */
    public function getField(){
        return $this->field;
    }

    /**
     * @param string $variable
     * @return string
     */
    public function prototypeRender($variable='__index__')
    {
        $prefix=$this->getPrefix();
        $prefix[]=$this->getName();
        $prefix[]=$variable;
        $this->field->setPrefix($prefix);
        return $this->field->render();
    }

    /**
     * @return AbstractField
     */
    public function validate()
    {
        $errors=[];
        $result=$this->validatorManager->validate($this->getData());
        if(!$result->isValid()){
            $errors=$result->getErrors();
        }

        foreach($this->dataFields as $field){
            $field->validate();
            if($field->isValid()){
                continue;
            }

            foreach($field->getErrors() as $error){
                $errors[]=$field->getName().': '.$error;
            }
        }
        $this->setErrors($errors);

        return $this;
    }

}