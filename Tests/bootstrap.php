<?php
// Define some constants
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
}
if (!defined('FILES_PATH')) {
    define('FILES_PATH', ROOT_PATH . '/Tests/_files');
}

// Add library path to include path
if (!defined('INCLUDE_PATH_SET')) {
    set_include_path(
        ROOT_PATH . PATH_SEPARATOR .
        get_include_path()
    );
    define('INCLUDE_PATH_SET', 1);
}

// Register autoloader
function testAutoload($className)
{
    $fileName = str_replace('_', '/', $className) . '.php';
    include $fileName;
    return class_exists($className, false);
}
spl_autoload_register('testAutoload');