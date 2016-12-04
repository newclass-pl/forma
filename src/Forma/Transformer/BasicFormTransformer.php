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


namespace Forma\Transformer;

use Forma\Transformer;

/**
 * Transformer for FormBuilder
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class BasicFormTransformer implements Transformer
{

    /**
     * {@inheritdoc}
     */
    public function decode($data)
    {
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function encode($data)
    {
        return $data;
    }

}