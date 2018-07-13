<?php
namespace core\lib\drive\log;
use core\lib\conf;

/***
 * 文件日志
 * 
 */
class file {
    
    public $path; //日志存储位置
       
    public function __construct()
    {
        $conf = conf::get('OPTION', 'log');  
        $this->path =$conf['PATH'];
    }
    public function log($message,$file = 'log'){
        /**
         * 1.判断日志文件存储位置是否存在
         *   如果不存在新建目录
         * 2。 写入日志
         */
      
        if ( !is_dir($this->path) ) {
            mkdir($this->path,'0777');
        }
        //每小时生成一个配置文件 防止 并发高时日志文件过大;
        return file_put_contents($this->path.date('YmdH').$file.'.log', date('Y-m-d H:i:s').':'.json_encode($message).PHP_EOL,FILE_APPEND);
        
        
        
    }
}