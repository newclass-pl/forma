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
        $this->setTag('pattern', $pattern);
        $this->addValidator(new RegExValidator($pattern));
    }

    /**
     * Get value of html tag pattern
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->getTag('pattern');
    }

    /**
     * Set value field
     *
     * @param mixed $value - value field
     */
    public function setValue($value)
    {
        $this->setTag('value', $value);
    }

    /**
     * Get value field
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->getTag('value');
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
    public function componentRender()
    {
        $template = '<input ';
        foreach ($this->getTags() as $kTag => $tag) {
            if (in_array($tag,['',false,null],true)) {
                continue;
            }
            $template .= $kTag;

            if ($tag !== true) {
                $template .= '="' . htmlspecialchars($tag) . '"';
            }

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