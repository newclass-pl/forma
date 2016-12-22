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
        $options['type'] = 'button';
        parent::__construct($options);
    }

    public function setType($type)
    {
        $this->setAttribute('type', $type);
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
        foreach ($this->getAttributes() as $kAttribute => $attribute) {
            if (in_array($attribute, [
                '',
                false,
                null
            ], true)) {
                continue;
            }
            $template .= $kAttribute;

            if ($attribute !== true) {
                $template .= '="' . htmlspecialchars($attribute) . '"';
            }

            $template .= ' ';
        }

        $template .= '>' . htmlspecialchars($this->getLabel()) . '</button>';

        return $template;
    }

}