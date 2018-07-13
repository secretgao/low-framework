<?php
/**
 * Date: 2018/7/9
 * Time: 16:28
 */
namespace CORE;
class secret
{
    public static $classMap = array();
    public static $controller = 'Controller';

    public static function run()
    {
        \core\lib\log::init();
   //     \core\lib\log::log($_SERVER,'log'); //记录日志
   
        $route = new \core\lib\route();
     
        $controller = $route->ctrl;
        $action    = $route->action;

        $controllerFile = APP.DIRECTORY_SEPARATOR.self::$controller.DIRECTORY_SEPARATOR.$controller.self::$controller.'.php';
        $ctrlClass = DIRECTORY_SEPARATOR.MODULE.DIRECTORY_SEPARATOR.self::$controller.DIRECTORY_SEPARATOR.$controller.self::$controller;
        if (is_file($controllerFile)) {
            require_once $controllerFile;
            $ctrl = new $ctrlClass();
            $ctrl->$action();
        } else {
            throw new \Exception('找不到'.$controller.'控制器');
        }
    }

    public static function load($class)
    {
        //自动加载类库   
        //判断是否存在不会重复引用
        if (isset($classMap[$class])) {
            return true;
        } else {
            $class = str_replace('\\','/',$class);
            $file  = SECRET.DIRECTORY_SEPARATOR.$class.'.php';

            if (is_file($file)) {
                require_once $file;
                self::$classMap[$class] = $class;
            } else {
                return $file.'.php  file is not found';
            }
        }

    }


    /**给视图赋值
     * @param $name
     * @param $value
     */
    public function assign($name,$value)
    {
        $this->assign[$name] = $value;
    }


    /**
     * 找到控制器对应的视图
     */
    public function display($file){
        
        $route = new \core\lib\route();
        $controller = $route->ctrl;
        $files = APP.'/views/'.$controller.'/'.$file;
        if (is_file($files)) {
            
            \Twig_Autoloader::register();
            $loader = new \Twig_Loader_Filesystem(APP.'/views/'.$controller);
            $twig = new \Twig_Environment($loader,array(
                'cache'=>SECRET.'/log',
                'debug'=>DEBUG,
            ));
            $temp = $twig->loadTemplate($file);
            $temp->display($this->assign? $this->assign : '');       
        } else {
            throw  new \Exception('view :'.$files.'not found');
        }
    }


}