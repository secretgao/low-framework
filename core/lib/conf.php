<?php
namespace core\lib;


use core\SECRET;

class conf
{
  public static $conf = [];  
     
  
  /**
   * 读取指定配置
   * @param unknown $name
   * @param unknown $file
   * @throws \Exception
   * @return mixed|unknown
   */
  public static function get($name,$file){
      /**
       * 1.判断配置文件是否存在
       * 2.判断配置是否存在
       * 3.缓存配置
       */
      if ( isset(self::$conf[$file]) ){
          return self::$conf[$file][$name];
      } else {
          $path = SECRET.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.$file.'.php';
       
        if (is_file($path)) { 
            
            $conf = include $path;
            
            if ( isset($conf[$name]) ) {
                self::$conf[$file] = $conf;
                return $conf[$name];
            } else {
                throw new \Exception('没有这个配置项:'.$conf[$name]);
            }
            
            
        } else {
            throw new \Exception('找不到配置文件:'.$file);
        }
      }
  }
  
  /**
   * 读取配置文件里的所有配置
   * @param unknown $name
   * @param unknown $file
   * @throws \Exception
   * @return mixed|unknown
   */
  
  public static function all($file){
      /**
       * 1.判断配置文件是否存在
       * 2.判断配置是否存在
       * 3.缓存配置
       */
      if ( isset(self::$conf[$file]) ){
          return self::$conf[$file];
      } else {
          $path = SECRET.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.$file.'.php';
          
          if (is_file($path)) {            
              $conf = include $path;                         
              self::$conf[$file] = $conf;
              return $conf;
             
          } else {
              throw new \Exception('找不到配置文件:'.$file);
          }
      }
  }
}