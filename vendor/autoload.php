<?php
/**
 * Created by PhpStorm.
 * User: jitendra
 * Date: 29/11/18
 * Time: 10:10 AM
 */


spl_autoload_extensions('.class.php');
spl_autoload_register('_AutoLoader');

function _AutoLoader($className)
{
     /*What it does?
     imports files based on the namespace as folder and class as filename.*/
    $file = str_replace('\\',DIRECTORY_SEPARATOR, $className);
    require_once (__DIR__.'/'.$file . '.class.php');
}