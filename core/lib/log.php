<?php
namespace core\lib;

class log
{
    public static $class;
    
    /**
     * 1.确定日志的存储方式 
     * 2.写日志
     */
    public static function init(){
        //确定存储方式
        $drive = conf::get('DRIVE', 'log');
        $class = DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'drive'.DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.$drive;
        self::$class = new $class;
    }
    
    public static function log($name,$file){
        self::$class->log($name,$file);
    }
    
}