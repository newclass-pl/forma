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

use Judex\Validator\NumberValidator;
use Judex\ValidatorNotFoundException;

/**
 * FormBuilder field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class NumberField extends InputField
{

    /**
     * {@inheritdoc}
     */
    public function __construct($options)
    {
        $options['type'] = 'number';

        if (!isset($options['validator'])) {
            $this->addValidator(new NumberValidator());
        }

        if (isset($options['min'])) {
            $this->setMin($options['min']);
            unset($options['min']);
        }

        if (isset($options['max'])) {
            $this->setMax($options['max']);
            unset($options['max']);
        }

        parent::__construct($options);
    }

    /**
     * Set html tag min
     *
     * @param int $value - value of tag min
     */
    public function setMin($value)
    {
        $this->setTag('min', $value);
        try {
            /**
             * @var NumberValidator $validator
             */
            $validator = $this->getValidator(NumberValidator::class);
            $validator->setMin($value);
        } catch (ValidatorNotFoundException $e) {
            //ignore
        }
    }

    /**
     * Get html tag min
     *
     * @return int - value of tag min
     */
    public function getMin()
    {
        return $this->getTag('min');
    }

    /**
     * Set html tag max
     *
     * @param int $value - value of tag max
     */
    public function setMax($value)
    {
        $this->setTag('max', $value);
        try {
            /**
             * @var NumberValidator $validator
             */
            $validator = $this->getValidator(NumberValidator::class);
            $validator->setMax($value);
        } catch (ValidatorNotFoundException $e) {
            //ignore
        }
    }

    /**
     * Get html tag max
     *
     * @return int - value of tag max
     */
    public function getMax()
    {
        return $this->getTag('max');
    }

}