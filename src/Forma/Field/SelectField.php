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
     * {@inheritdoc}
     */
    public function __construct($options)
    {
        if (isset($options['collection'])) {
            $this->collection = $options['collection'];
            unset($options['collection']);
        }

        if (!isset($options['validator'])) {
//			$this->addValidator(new TextValidator()); //TODO add CollectionValidator
        }


        parent::__construct($options);
    }

    /**
     * Get collection data (options value)
     *
     * @return mixed[] - eg:
     * [
     *    [
     *        'value'=>'{string}'
     *        ,'label'=>'{string}'
     *    ]
     *    ,...
     * ]
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Set collection data (options value)
     *
     * @param mixed[] $collection - eg:
     * [
     *    [
     *        'value'=>'{string}'
     *        ,'label'=>'{string}'
     *    ]
     *    ,...
     * ]
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    /**
     * Set html tag multiple
     *
     * @param bool $flag - value of tag multiple
     */
    public function setMultiple($flag)
    {
        $this->setTag('multiple', $flag);
    }

    /**
     * Get html tag multiple
     *
     * @return bool
     */
    public function isMultiple()
    {
        $tags = $this->getTags();
        return (isset($tags['multiple']) && $tags['multiple']);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $template = $this->labelRender();
        $template .= $this->componentRender();
        return $template;
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
        foreach ($this->getTags() as $kTag => $tag) {
            if ($tag != '') {
                if ($kTag == 'name' && $this->isMultiple()) {
                    $tag .= '[]';
                }

                $template .= $kTag . '="' . htmlspecialchars($tag) . '" ';

            }
        }

        $template .= '>';
        $values = (is_array($this->getData()) ? $this->getData() : [$this->getData()]);
        foreach ($this->collection as $option) {
            $template .= '<option value="' . htmlspecialchars($option['value']) . '" ' .
                (in_array($option['value'], $values) ? 'selected' : '') . '>' . htmlspecialchars($option['label']) .
                '</option>';
        }

        $template .= '</select>';
        return $template;
    }
}
