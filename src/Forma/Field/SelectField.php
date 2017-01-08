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
use Judex\Validator\CollectionValidator;
use Judex\ValidatorNotFoundException;

/**
 * FormBuilder field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class SelectField extends AbstractField
{

    /**
     * @var mixed[]
     */
    private $collection = [];

    /**
     * @var int
     */
    private $data = null;

    /**
     * @var string
     */
    private $emptyRecord;

    /**
     * {@inheritdoc}
     */
    public function __construct($options = [])
    {
        $this->options = array_merge($this->options, [
            'collection',
            'emptyRecord'
        ]);

        parent::__construct($options);
    }

    /**
     * Get collection data (options value)
     *
     * @return mixed[]
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Set collection data (options value)
     *
     * @param mixed[] $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

        try {
            $this->removeValidator(CollectionValidator::class);
        } catch (ValidatorNotFoundException $e) {
            //ignore
        }

        $values = array_map(function ($item) {
            return $item['value'];
        }, $this->getCollection());

        $this->addValidator(new CollectionValidator($values));

    }

    /**
     * @param string $label
     */
    public function setEmptyRecord($label)
    {
        $this->emptyRecord = $label;
    }

    /**
     * Set html tag multiple
     *
     * @param bool $flag - value of tag multiple
     */
    public function setMultiple($flag)
    {
        $this->setAttribute('multiple', $flag);
    }

    /**
     * Get html tag multiple
     *
     * @return bool
     */
    public function isMultiple()
    {
        $tags = $this->getAttributes();
        return (isset($tags['multiple']) && $tags['multiple']);
    }

    /**
     * {@inheritdoc}
     */
    public function labelRender()
    {
        return '<label for="' . $this->getId() . '">' . htmlspecialchars($this->getLabel()) . '</label>';
    }

    /**
     * {@inheritdoc}
     */
    public function setData($value)
    {
        $this->data = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function clearData()
    {
        return $this->data = null;
    }


    /**
     * {@inheritdoc}
     */
    public function componentRender()
    {
        $template = '<select ';
        foreach ($this->getAttributesName() as $attribute) {
            $template .= $this->attributeRender($attribute);
            $template .= ' ';
        }

        $template .= '>';
        $values = (is_array($this->getData()) ? $this->getData() : [$this->getData()]);
        $options = $this->getCollection();
        if ($this->emptyRecord) {
            $options = array_merge([
                [
                    'value' => '',
                    'label' => htmlspecialchars($this->emptyRecord)
                ]
            ], $options);
        }

        foreach ($options as $option) {
            $template .= '<option value="' . htmlspecialchars($option['value']) . '" ' .
                (in_array($option['value'], $values) ? 'selected' : '') . '>' . htmlspecialchars($option['label']) .
                '</option>';
        }

        $template .= '</select>';
        return $template;
    }

    /**
     * @return string
     */
    protected function nameRender()
    {
        $template = parent::nameRender();
        if (!$this->isMultiple()) {
            return $template;
        }
        return rtrim($template, '"') . '[]"';
    }
}
