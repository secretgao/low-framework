<?php
/**
 * 入口文件
 * 1.定义常量
 * 2. 加载函数库
 * 3. 启动框架
 */
#定义常量
define('SECRET',__DIR__);
define('CORE',SECRET.DIRECTORY_SEPARATOR.'core');
define('APP',SECRET.DIRECTORY_SEPARATOR.'app');
define('DEBUG',true);
define('MODULE','app');
include 'vendor/autoload.php';
if (DEBUG) {
    $Whoops = new \Whoops\Run;
    $title = "哎呀~不小心出错了";
    $option = new \Whoops\Handler\PrettyPageHandler();
    $option->setPageTitle($title);
    $Whoops->pushHandler($option);
    $Whoops->register();
    ini_set('display_errors','On');
} else {
    ini_set('display_errors','Off');
}

# 加载函数库
require_once CORE.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'function.php';
require_once CORE.DIRECTORY_SEPARATOR.'secret.php';
spl_autoload_register(DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'secret::load');
# 启动框架
\core\SECRET::run();