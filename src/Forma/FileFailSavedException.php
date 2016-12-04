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
 * Throw when FileUploaded can not save file.
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class FileFailSavedException extends FormException
{

    /**
     * Constructor.
     *
     * @param string $reason
     */
    public function __construct($reason)
    {
        parent::__construct("File fail saved. Reason: " . $reason . ".");
    }
}