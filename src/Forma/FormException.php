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
 * Class FormException
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class FormException extends \Exception
{
    /**
     * FormException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }

}