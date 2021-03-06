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

use Judex\Validator\DateValidator;

/**
 * FormBuilder field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class DateField extends InputField
{

    /**
     * {@inheritdoc}
     */
    public function __construct($options=[])
    {
        $options['type'] = 'date';

        if (!isset($options['validator'])) {
            $options['validator']=new DateValidator();
        }

        parent::__construct($options);

    }

}