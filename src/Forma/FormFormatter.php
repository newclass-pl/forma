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
 * Interface for form formatter. Definition how generate view for FormBuilder.
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
interface FormFormatter
{
    /**
     * Method generated html for form open html element
     *
     * @param FormBuilder $builder
     * @return string
     */
    public function beginRender(FormBuilder $builder);

    /**
     * Method generated html for form close html element
     * @param FormBuilder $builder
     * @return string
     */
    public function endRender(FormBuilder $builder);

    /**
     * @param FormBuilder $builder
     * @return string
     */
    public function fieldsRender(FormBuilder $builder);

    /**
     * @param FormBuilder $builder
     * @return string
     */
    public function render(FormBuilder $builder);

    /**
     * @return FieldFormatter
     */
    public function getFieldFormatter();
}