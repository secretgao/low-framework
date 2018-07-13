<?php
namespace app\model;

use core\lib\model;


class test1Model extends model{
    
   protected $table = 'test1';
   protected $pri_key = 'id';
   
   public function listTest1($columns = "*",$where = '1=1',$orderBy,$page=0,$pageSize=20){
            
       
       $sql = "SELECT {$columns} FROM ".$this->table." WHERE ".$this->_whereBuilder($where);
       if ($orderBy){
           $sql.=" ORDER BY {$orderBy}";
       }
       
       $sql .=" limit {$page},{$pageSize}";
    
       return $this->selectAll($sql);
       
   }
}