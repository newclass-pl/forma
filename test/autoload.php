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

$vendors=[
    'Forma'=>'src',
    'Judex'=>'vendor/newclass/judex/src'
];

spl_autoload_register(function ($className) use ($vendors){
    $path=realpath(__DIR__.'/..');
    $classPath=str_replace('\\', '/', $className);
    if(strpos($classPath, 'Test')===0){
        $classPath='test/'.substr($classPath, 5);
    }
    else{
        foreach($vendors as $kVendor=>$vendor){
            if(strpos($classPath, $kVendor)===0){
                $classPath=$vendor.'/'.$classPath;
                break;
            }

        }
    }
    $classPath=$path.'/'.$classPath.'.php';
    if(!file_exists($classPath)){
        return;
    }
    /** @noinspection PhpIncludeInspection */
    require_once $classPath;
});