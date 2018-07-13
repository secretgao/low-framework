<?php
/**
 * Date: 2018/7/9
 * Time: 19:19
 */
namespace app\Controller;
use \core\lib\model;
class IndexController extends \core\SECRET
{
   public function index(){
      
       $conf = \core\lib\conf::get('CTRL', 'route');
       $conf = \core\lib\conf::get('ACTION', 'route');
       p($conf);
     //  $model = new \core\lib\model();
       $test1 = new \app\model\test1Model();
     ///  $columns = "*",$where = '1=1',$orderBy,$page=0,$pageSize=20
       $res = $test1->listTest1('*','1=1','id DESC');
     
       p($res);

        
       //实现视图功能
       $this->assign('data','z这是index控制器返回的数据');
       $this->display('index.html');
   }

}