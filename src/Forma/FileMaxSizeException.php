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
 * Throw when File is too large. Exception for FileValidator
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class FileMaxSizeException extends FormException
{

    /**
     * Constructor.
     * @param int $maxSize
     */
    public function __construct($maxSize)
    {
        parent::__construct('Max size for file is too large. Server limit: ' . $maxSize . '.');
    }
}