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
class TextareaField extends AbstractField
{

    /**
     * @var string
     */
    private $data = '';

    /**
     * {@inheritdoc}
     */
    public function __construct($options=[])
    {
        parent::__construct($options);
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
        $template = '<textarea ';
        foreach ($this->getAttributesName() as $attribute) {
            $template.=$this->attributeRender($attribute);
            $template .= ' ';
        }

        $template .= '>' . htmlspecialchars($this->getData()) . '</textarea>';

        return $template;
    }

}