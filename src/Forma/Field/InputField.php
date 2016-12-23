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
use Judex\Validator\RegExValidator;

/**
 * FormBuilder field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
abstract class InputField extends AbstractField
{

    /**
     * {@inheritdoc}
     */
    public function __construct($options)
    {
        parent::__construct($options);
        if(isset($options['pattern'])){
            $this->setPattern($options['pattern']);
        }

    }

    /**
     * Set html tag pattern
     *
     * @param string $pattern - value of tag pattern (regular expression)
     */
    public function setPattern($pattern)
    {
        $this->setAttribute('pattern', $pattern);
        $this->addValidator(new RegExValidator($pattern));
    }

    /**
     * Get value of html tag pattern
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->getAttribute('pattern');
    }

    /**
     * Set value field
     *
     * @param mixed $value - value field
     */
    public function setValue($value)
    {
        $this->setAttribute('value', $value);
    }

    /**
     * Get value field
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->getAttribute('value');
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
    public function componentRender()
    {
        $template = '<input ';
        foreach ($this->getAttributesName() as $attribute) {
            $template.=$this->attributeRender($attribute);
            $template .= ' ';
        }

        $template .= '/>';
        return $template;

    }

    /**
     * {@inheritdoc}
     */
    public function setData($value)
    {
        $this->setValue($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function clearData()
    {
        return $this->setValue(null);
    }
}