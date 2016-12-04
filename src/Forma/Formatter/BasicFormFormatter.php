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


namespace Forma\Formatter;

use Forma\AbstractField;
use Forma\FormFormatter;

/**
 * Formatter for FormBuilder
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class BasicFormFormatter implements FormFormatter
{

    /**
     * {@inheritdoc}
     */
    public function renderField(AbstractField $field)
    {
        $html = $field->render();
        if($field->isValid()){
            return $html;
        }

        $html.='<ul class="errors">';

        foreach($field->getErrors() as $error){
            $html.='<li>'.$error.'</li>';
        }
        $html.='</ul>';
        return $html;
    }

    /**
     * {@inheritdoc}
     */
    public function renderFormBegin($tags)
    {
        $template = '<FORM ';
        foreach ($tags as $kTag => $tag) {
            if ($tag != '') {
                $template .= $kTag . '="' . $tag . '" ';
            }
        }

        $template .= ' >';

        return $template;
    }

    /**
     * {@inheritdoc}
     */
    public function renderFormEnd()
    {
        return '</FORM>';
    }

    /**
     * {@inheritdoc}
     */
    public function renderSubmit($tags)
    {
        $template = '<BUTTON ';
        $value = $tags['value'];
        unset($tags['value']);

        foreach ($tags as $kTag => $tag) {
            if ($tag != '') {
                $template .= $kTag . '="' . $tag . '" ';
            }
        }

        $template .= ' >' . $value . '</BUTTON>';

        return $template;

    }
}