README
======

![license](https://img.shields.io/packagist/l/bafs/via.svg?style=flat-square)
![PHP 5.5+](https://img.shields.io/badge/PHP-5.5+-brightgreen.svg?style=flat-square)

What is Forma?
-----------------

Forma is a PHP form manager. Support for base html tag:
- textarea
- date
- text
- file
- number
- password
- email
- checkbox
- select

Auto validate data and render HTML template.

Auto match data from HTTP request.

Installation
------------

The best way to install is to use the composer by command:

composer require newclass/forma

composer install

Use example

    use Forma\Field\CheckboxField;
    use Forma\Field\NumberField;
    use Forma\FormBuilder;
    use Forma\Request;

    $builder = new FormBuilder();
    $request = new RequestImpl(); //your http request class

    $builder->setRequest($request);

    //add checkbox field
    $builder->addField(new CheckboxField([
        'label' => 'Checkbox label',
        'name' => 'checkbox',
    ]));

    //add number field
    $builder->addField(new NumberField([
        'label' => 'Number label',
        'name' => 'number',
    ]));

    //set default data for number field
    $builder->setData([
        'number' => 20,
    ]);

    //confirm data
    $builder->submit();

    $valid=$builder->isValid(); //return true or false. If invalid then execute $builder->getErrors() to get error messages.

    if(!$valid){
        echo $builder->render(); //show form when invoke errors or not confirmed
    }

    //get data from request and default field config
    $data = $builder->getData();

    var_dump($data);