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


namespace Forma\Field;

use Forma\AbstractField;
use Judex\Validator\CollectionValidator;
use Judex\ValidatorException;

/**
 * FormBuilder field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class SelectField extends AbstractField
{

    /**
     * @var mixed[]
     */
    private $collection = [];

    /**
     * @var int
     */
    private $data = null;

    /**
     * {@inheritdoc}
     */
    public function __construct($options=[])
    {
        $collection=null;
        if (isset($options['collection'])) {
            $collection=$options['collection'];
            unset($options['collection']);
        }

        $validator=null;
        if (!isset($options['validator'])) {
            $validator=new CollectionValidator();
        }

        parent::__construct($options);

        if($validator){
            $this->addValidator($validator);
        }

        if($collection){
            $this->setCollection($collection);
        }
    }

    /**
     * Get collection data (options value)
     *
     * @return mixed[]
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Set collection data (options value)
     *
     * @param mixed[] $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

        try{
            /**
             * @var CollectionValidator $validator
             */
            $validator=$this->getValidator(CollectionValidator::class);
            $validator->setCollection(array_keys($this->getCollection()));
        }
        catch (ValidatorException $e){
            //ignore
        }
    }

    /**
     * Set html tag multiple
     *
     * @param bool $flag - value of tag multiple
     */
    public function setMultiple($flag)
    {
        $this->setTag('multiple', $flag);
    }

    /**
     * Get html tag multiple
     *
     * @return bool
     */
    public function isMultiple()
    {
        $tags = $this->getTags();
        return (isset($tags['multiple']) && $tags['multiple']);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $template = $this->labelRender();
        $template .= $this->componentRender();
        return $template;
    }

    /**
     * {@inheritdoc}
     */
    public function labelRender()
    {
        return '<label for="' . $this->getId() . '">' . htmlspecialchars($this->getLabel()) . '</label>';
    }

    /**
     * {@inheritdoc}
     */
    public function setData($value)
    {
        $this->data = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function clearData()
    {
        return $this->data = null;
    }


    /**
     * {@inheritdoc}
     */
    public function componentRender()
    {
        $template = '<select ';
        foreach ($this->getTags() as $kTag => $tag) {
            if (in_array($tag, [
                '',
                false,
                null
            ], true)) {
                continue;
            }

            $template .= $kTag;

            if ($kTag === 'name' && $this->isMultiple()) {
                $tag .= '[]';
            }

            if ($tag !== true) {
                $template .= '="' . htmlspecialchars($tag) . '"';
            }

            $template .= ' ';

        }

        $template .= '>';
        $values = (is_array($this->getData()) ? $this->getData() : [$this->getData()]);
        foreach ($this->collection as $kOption=>$option) {
            $template .= '<option value="' . htmlspecialchars($kOption) . '" ' .
                (in_array($kOption, $values) ? 'selected' : '') . '>' . htmlspecialchars($option) .
                '</option>';
        }

        $template .= '</select>';
        return $template;
    }
}
