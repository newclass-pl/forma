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


class MethodOptionNotFoundException extends FormException
{

    /**
     * MethodOptionNotFoundException constructor.
     * @param string $kOption
     */
    public function __construct($kOption)
    {
        parent::__construct('Method for option "'.$kOption.'" not found.');
    }
}