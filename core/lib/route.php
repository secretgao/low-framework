<?php
/**
 * Date: 2018/7/9
 * Time: 16:32
 */
namespace core\lib;
use core\lib\conf;
class route
{
    public $ctrl; //控制器
    public $action; //方法

    public function __construct()
    {
        //xxx.com/index/index
        //xxx.com/index.php/index/index
        /**
         * 1.隐藏index.php
         * 2.获取url参数部分
         * 3.返回对应控制器和方法
         */
        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {
                // /index/index
            $path = $_SERVER['REQUEST_URI'];
            $pathArr = explode('/',trim($path,'/')); //index/index
            if (isset($pathArr[0])) {
                $this->ctrl = $pathArr[0];
                unset($pathArr[0]);
            }
            if (isset($pathArr[1])) {
                $this->action = $pathArr[1];
                unset($pathArr[1]);
            } else {
                $this->action = conf::get('ACTION', 'route');
            }
            //url 多余部分 改成get 参数
            // index/index/id/1

            $count = count($pathArr) + 2;
            $i = 2;
            while ($i < $count) {
                if (isset($pathArr[$i+1])) {
                    $_GET[$pathArr[$i]] = $pathArr[$i+1];
                }
                $i = $i + 2;
            }

        } else {
            $this->action = conf::get('ACTION', 'route');
            $this->ctrl = conf::get('CTRL', 'route');;
        }
    }

}