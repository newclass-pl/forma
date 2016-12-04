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


namespace Forma;

/**
 * Throw when file not found in request provider.
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class FieldNotFoundException extends FormException
{

    /**
     * Constructor.
     *
     * @param string $name field name
     */
    public function __construct($name)
    {
        parent::__construct('Field "' . $name . '" not found.');
    }
}