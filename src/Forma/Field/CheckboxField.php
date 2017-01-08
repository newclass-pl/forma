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

/**
 * FormBuilder field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class CheckboxField extends InputField
{

    /**
     * {@inheritdoc}
     */
    public function __construct($options=[])
    {
        $this->options=array_merge($this->options,['checked']);

        $options['type'] = 'checkbox';
        $options+=['checked'=>false];

        parent::__construct($options);

    }

    /**
     * {@inheritdoc}
     */
    public function setData($value)
    {
        $this->setChecked((boolean)$value);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        if ($this->isChecked()) {
            if ($this->getValue()) {
                return $this->getValue();
            } else {
                return 'on';
            }
        } else {
            return null;
        }
    }

    /**
     * Get value of tag checked
     *
     * @return boolean
     */
    public function isChecked()
    {
        return $this->getAttribute('checked');
    }

    /**
     * Set value of tag checked
     *
     * @param boolean $flag - if true then checked else unchecked
     * @return \Forma\AbstractField
     */
    public function setChecked($flag)
    {
        return $this->setAttribute('checked', $flag);
    }

}