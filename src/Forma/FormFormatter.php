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
     * @param AbstractField $field
     */
    public function renderField(AbstractField $field);

    /**
     * Method generated html for form open html element
     *
     * @param string[] $tags - tag list
     */
    public function renderFormBegin($tags);

    /**
     * Method generated html for form close html element
     */
    public function renderFormEnd();

    /**
     * Method generated html for form submit button
     *
     * @param string[] $tags - tag list
     */
    public function renderSubmit($tags);

}