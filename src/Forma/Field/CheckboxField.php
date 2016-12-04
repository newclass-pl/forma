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

use Judex\Validator\BooleanValidator;

/**
 * FormBuilder field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class CheckboxField extends InputField
{

    /**
     * {@inheritdoc}
     */
    public function __construct($options)
    {
        $options += [
            'checked' => false
        ];

        $options['type'] = 'checkbox';

        if (!isset($options['validator'])) {
            $this->addValidator(new BooleanValidator());
        }

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
            return false;
        }
    }

    /**
     * Get value of tag checked
     *
     * @return boolean
     */
    public function isChecked()
    {
        return $this->getTag('checked');
    }

    /**
     * Set value of tag checked
     *
     * @param boolean $flag - if true then checked else unchecked
     */
    public function setChecked($flag)
    {
        return $this->setTag('checked', $flag);
    }

}