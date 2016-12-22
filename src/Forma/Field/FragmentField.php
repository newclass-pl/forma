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
        if(isset($options['fields'])){
            $this->addFields($options['fields']);
        }
        parent::__construct($options);
    }

    /**
     * Set confirmed data
     *
     * @param mixed $data - confirmed data
     */
    public function setData($data)
    {
        $this->data=$data;
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
        foreach($this->getFields() as $field){
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
    private function addFields($fields){
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
        if(!$field->isCustomFormatter()){
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
            if(!$field->isCustomFormatter()){
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
}