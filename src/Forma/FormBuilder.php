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

use Forma\Field\FileField;
use Forma\Formatter\SimpleFormFormatter;
use Forma\Transformer\BasicFormTransformer;

/**
 * Generator form. Support for mapping data, validation and generate html code.
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class FormBuilder
{
    /**
     * @var FormFormatter
     */
    private $formatter;
    /**
     * @var AbstractField[]
     */
    private $fields = [];
    /**
     * @var string[]
     */
    private $attributes = [];
    /**
     * @var bool
     */
    private $isConfirmed = false;
    /**
     * @var Designer
     */
    private $designer;
    /**
     * @var FormFormatter
     */
    private $transformer;
    /**
     * @var int
     */
    private $maxFieldId = 0;
    /**
     * @var Request
     */
    private $request;

    /**
     * FormBuilder constructor.
     */
    public function __construct()
    {
        $this->setFormatter(new SimpleFormFormatter());
        $this->transformer = new BasicFormTransformer();
        $this->attributes = [
            'method' => 'post',
            'id' => null,
            'class' => null,
            'enctype' => null
        ];
    }

    /**
     * Set formatter with html rule pattern
     *
     * @param FormFormatter $formatter
     * @return FormBuilder
     */
    public function setFormatter(FormFormatter $formatter)
    {
        $this->formatter = $formatter;
        return $this;
    }

    /**
     * @return FormFormatter
     */
    public function getFormatter(){
        return $this->formatter;
    }

    /**
     * Set designer with rule to generate fields
     *
     * @param Designer $designer
     * @return FormBuilder
     */
    public function setDesigner(Designer $designer)
    {
        $this->designer = $designer;
        $this->designer->build($this);
        return $this;
    }

    /**
     * Set transformer with rule to encode/decode data
     *
     * @param Transformer $transformer
     * @return FormBuilder
     */
    public function setTransformer(Transformer $transformer)
    {
        $this->transformer = $transformer;
        return $this;
    }

    /**
     * Get transformer with rule to encode/decode data
     *
     * @return Transformer
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * @param string $name
     * @param string $value
     * @return FormBuilder
     */
    public function setAttribute($name,$value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Add form field
     *
     * @param AbstractField $field
     * @return FormBuilder
     */
    public function addField(AbstractField $field)
    {

        $this->fields[] = $field;

        $maxFieldId = $this->maxFieldId++;
        if ($field->getName() === null) {
            $field->setName('name_' . $maxFieldId);
        }

        if ($field->getId() === null) {
            $field->setId('id_' . $maxFieldId);
        }

        if ($field instanceof FileField) {//FIXME change on event?
            $this->attributes['enctype'] = 'multipart/form-data';
        }

        if(!$field->isCustomFormatter()){
            $field->setFormatter($this->getFormatter()->getFieldFormatter());
        }

        return $this;
    }

    /**
     * Remove field from generator
     *
     * @param string $name - field name
     * @return FormBuilder
     */
    public function removeField($name)
    {
        for ($i = 0; $i < count($this->fields); $i++) {
            if ($this->fields[$i]->getName() === $name) {
                array_splice($this->fields, $i, 1);
                break;
            }
        }

        return $this;
    }

    /**
     * Generate html form string
     *
     * @return string - with html form
     */
    public function render()
    {
        return $this->formatter->render($this);
    }

    /**
     * Generate html string for fields
     *
     * @return string with html fields
     */
    public function fieldsRender()
    {
        return $this->formatter->fieldsRender($this);
    }

    /**
     * Generate html string for selected field
     *
     * @param string $name - field name
     * @return string with html field
     */
    public function fieldRender($name)
    {
        return $this->getField($name)->render();
    }

    /**
     * Generate html string for open form tag
     *
     * @return string - with html open form tag
     */
    public function beginRender()
    {
        return $this->formatter->beginRender($this);
    }

    /**
     * Generate html string for close form tag
     *
     * @return string - with html close form tag
     */
    public function endRender()
    {
        return $this->formatter->endRender($this);
    }

    /**
     * @return string - with html form
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Get field object
     *
     * @param string $name - field name (html name tag)
     * @return AbstractField
     * @throws FieldNotFoundException
     */
    public function getField($name)
    {
        foreach ($this->fields as $field) {
            if ($field->getName() == $name) {
                return $field;
            }
        }

        throw new FieldNotFoundException($name);
    }

    /**
     * Get all fields object
     *
     * @return AbstractField[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Check confirmed form (clicked submit button in frontend/mailed fields value)
     *
     * @return boolean - if success then true else false
     */
    public function isConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * Check valid form
     *
     * @return boolean - if success then true else false
     * @since 0.13.0
     */
    public function isValid()
    {
        if (!$this->isConfirmed()) {
            return false;
        }

        $errors = $this->getErrors();

        return count($errors) == 0;

    }

    /**
     * Set default values for fields
     *
     * @param mixed[] $data eg:
     * [
     * '{text field name 1}'=>'{text value name 1}'
     * ,'{text field name 2}'=>'{text value name 2}'
     * ]
     */
    public function setData($data)
    {
        $data = $this->transformer->encode($data);
        foreach ($this->fields as $field) {
            if (isset($data[$field->getName()])) {
                $field->setData($data[$field->getName()]);
            }
        }
    }

    /**
     * Get data from fields
     * @return \mixed[]
     * @throws FormException
     */
    public function getData()
    {
        $data = [];
        if(!$this->isValid()){
            return $data;
        }

        foreach ($this->fields as $field) {
            if (preg_match('/^(.*?)(\[.*\])$/', $field->getName(), $result)) {
                if ($result[2] == '') {
                    //FIXME autoincrement field
                } else {

                    if (!preg_match_all('/\[(.*?)\]/', $result[2], $resultDeep)) {
                        throw new FormException('Invalid field name.');//FIXME dedicate exception
                    }
                    $storage =& $data[$result[1]];
                    foreach ($resultDeep[1] as $deep) {
                        if (!isset($storage[$deep])) {
                            $storage[$deep] = [];
                        }
                        $storage =& $storage[$deep];
                    }
                    $storage = $field->getData();
                }
            } else {
                $data[$field->getName()] = $field->getData();
            }
        }

        return $this->transformer->decode($data);
    }

    /**
     * Remove all field data
     */
    public function clearData()
    {
        foreach ($this->fields as $field) {
            $field->clearData();
        }
    }

    /**
     * @param Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * Submit form. Check http confirm and validate fields
     *
     * @throws FormException
     */
    public function submit()
    {
        if (!$this->request) {
            throw new FormException('Request not found. Use method setRequest.');
        }
        $request = $this->request;
        $this->isConfirmed = false;

        if ($this->attributes['method'] === 'post' && $request->getMethod() === 'POST') {
            $this->isConfirmed = true;
        }

        $query = $request->getQuery();
        if (count($this->fields) > 0 && $this->attributes['method'] == 'get' &&
            isset($query[$this->fields[0]->getName()])
        ) {
            $this->isConfirmed = true;
        }

        if (!$this->isConfirmed) {
            return;
        }

        if ($this->attributes['method'] === 'post') {
            $storage = $request->getData();
        } else {
            $storage = $request->getQuery();
        }

        //set field data

        $result = [];
        foreach ($this->fields as $field) {

            if (isset($storage[$field->getName()])) {
                $field->setData($storage[$field->getName()]);
            } else {
                if ($field instanceof FileField) {
                    try {
                        $field->setData($request->getFile($field->getName()));
                    } catch (FileNotUploadedException $e) {
                        $field->setData('');
                    }
                } else {
                    if (preg_match('/^(.*?)(\[.*\])$/', $field->getName(), $result) &&
                        isset($storage[$result[1]])
                    ) {//array
                        if (!preg_match_all('/\[(.*?)\]/', $result[2], $resultDeep)) {
                            throw new FormException('Invalid field name.');//FIXME dedicate exception
                        }

                        $value = $storage[$result[1]];
                        foreach ($resultDeep[1] as $deep) {
                            if (!isset($value[$deep])) {
                                $value = null;
                                break;
                            }
                            $value = $value[$deep];
                        }

                        if ($result[2] == '') {
                            //FIXME autoincrement field
                        } else {
                            $field->setData($value);
                        }
                    } else {//for checkbox or disabled field
                        $field->setData('');
                    }
                }
            }
        }

        //validate
        if (!$request->isFullUploadedData()) {
            foreach ($this->fields as $field) {
                $field->addError('Request data is too large.');
            }
            return;
        }

        foreach ($this->fields as $field) {
            if (!$field->getValidators()) {
                continue;
            }
            $result = $field->validate();
            if ($result->isValid()) {
                continue;
            }
            $field->setError($result->getErrors());
        }
    }

    /**
     * Validate fields and get errors
     *
     * @return array - with errors if success then empty array
     */
    public function getErrors()
    {
        $errors = [];
        foreach ($this->fields as $field) {
            if ($field->isValid()) {
                continue;
            }
            foreach ($field->getErrors() as $error) {
                $errors[] = [
                    'field' => $field->getLabel(),
                    'message' => $error
                ];

            }
        }

        return $errors;
    }

}
