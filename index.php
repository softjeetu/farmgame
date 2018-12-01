<?php
/**
 * Created by PhpStorm.
 * User: jitendra
 * Date: 01/12/18
 * Time: 12:06 PM
 */
/*To show the errors in application*/
error_reporting(E_ALL);
ini_set("display_errors", 0);

/*
 * -------------------------------------------------------------------
 *  set the main path constant
 * -------------------------------------------------------------------
 */
if(!defined('BASEPATH'))
    define('BASEPATH', dirname(__FILE__).'/');
/*
 * -------------------------------------------------------------------
 *  set the view path constant
 * -------------------------------------------------------------------
 */
if(!defined('VIEWPATH'))
    define('VIEWPATH', BASEPATH.'resources/');


/*You need to import auto load so that you can use classes without import:*/
require_once __DIR__.'/vendor/autoload.php';
use \classes\Utility as _utility;

$_utility = new _utility();
/*
 * -------------------------------------------------------------------
 *  set the base url constant
 * -------------------------------------------------------------------
 */
if(!defined('BASEURL'))
    define('BASEURL', $_utility->config['BASE_URL']);

/*
 * -------------------------------------------------------------------
 *  process the whole performance
 * -------------------------------------------------------------------
 */
$_utility->process('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
