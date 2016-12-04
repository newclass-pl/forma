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
 * Implementation for auto generate field list in FormBuilder
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
interface Designer
{

    /**
     * @param FormBuilder $formBuilder
     * @return mixed
     */
    public function build(FormBuilder $formBuilder);
}