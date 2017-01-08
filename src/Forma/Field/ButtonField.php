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
class ButtonField extends AbstractField
{
    /**
     * {@inheritdoc}
     */
    public function __construct($options = [])
    {
        $this->setAttribute('type', 'button');
        parent::__construct($options);
    }

    /**
     * {@inheritdoc}
     */
    public function labelRender()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function setData($value)
    {
        //ignore
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        //ignore
    }

    /**
     * {@inheritdoc}
     */
    public function clearData()
    {
        //ignore
    }

    /**
     * {@inheritdoc}
     */
    public function componentRender()
    {
        $template = '<button ';
        foreach ($this->getAttributesName() as $attribute) {
            $template.=$this->attributeRender($attribute);
            $template .= ' ';
        }

        $template .= '>' . htmlspecialchars($this->getLabel()) . '</button>';

        return $template;
    }

}