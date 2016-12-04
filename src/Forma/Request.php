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
 * Interface Request
 * @package Forma
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
interface Request
{

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return array
     */
    public function getQuery();

    /**
     * @return array
     */
    public function getData();

    /**
     * @param string $name
     * @return RequestFile
     */
    public function getFile($name);

    /**
     * @return bool
     */
    public function isFullUploadedData();
}