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


namespace Test\Forma\Field;

use Forma\Field\FileField;
use Forma\RequestFile;

/**
 * Class FileFieldTest
 * @package Test\Forma\Field
 * @author Michal Tomczak (michal.tomczak@newclass.pl)
 */
class FileFieldTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetData()
    {
        $field = new FileField();
        $requestFileMock = $this->createMock(RequestFile::class);

        $field->setData($requestFileMock);
        $this->assertEquals($requestFileMock, $field->getData());

    }

    /**
     *
     */
    public function testValidator()
    {
        $field = new FileField([
            'accept' => 'jpg',
            'maxSize' => 9000,
        ]);

        $requestFileMock = $this->createMock(RequestFile::class);
        $requestFileMock->method('getExtension')->willReturn('jpg');
        $requestFileMock->method('getSize')->willReturn(8000);

        $field->setData($requestFileMock);
        $this->assertTrue($field->validate()->isValid());

        $field->setData('');
        $this->assertTrue($field->validate()->isValid());

        $field = new FileField([
            'required' => true,
            'accept' => 'gif',
            'maxSize' => 100,
        ]);

        $field->setData('');
        $result = $field->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals(['Value can\'t be empty.'], $result->getErrors());

        $field->setData($requestFileMock);
        $this->assertFalse($field->validate()->isValid());
        $this->assertEquals([
            'Value is not valid file type. Allow: "gif".',
            'File is too big. Max size is "100".'
        ], $field->validate()->getErrors());

    }

    /**
     *
     */
    public function testRender()
    {
        $field = new FileField([
            'label' => 'My label',
            'name' => 'field-name',
            'required' => true,
            'id' => 'field1',
            'multiple'=>true,
        ]);

        $this->assertEquals('<label for="field1">My label</label>', $field->labelRender());
        $this->assertEquals('<input name="field-name[]" required id="field1" multiple type="file"  />',
            $field->componentRender());

    }
}