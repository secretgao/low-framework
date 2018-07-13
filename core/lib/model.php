<?php
/**
 * Date: 2018/7/10
 * Time: 9:06
 */
namespace core\lib;
use core\lib\conf;
class model extends \PDO
{

    public function __construct()
    {      
        $conf = conf::all('database');     
        try{
            parent::__construct($conf['DSN'], $conf['USER'], $conf['PWD']);
        } catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }

    }
    
    /**
     * where条件构造器
     * @param      string $where
     * @access     public
     * @return     string
     */
    public function _whereBuilder($where_clause,$f = 'and'){
        $f = strtoupper( $f );
        $_where_clause = '';
        
        //如果where条件是数组
        if( is_array( $where_clause ) && !empty( $where_clause ) ) {
            
            //考虑当参数是id数组时，array(1,2,3,4)
            $is_val_number = true;
            $vals = array();
            foreach( $where_clause as $key => $val ) {
                if( !is_numeric( $key ) || !is_numeric( $val ) ) {
                    $is_val_number = false;
                    break;
                }
                $vals[] = intval( $val );
            }
            
            if( $is_val_number ) {
                return $this->pri_key ." in (". implode(',', $vals).")";
            }
            
            //其他情况
            foreach( $where_clause as $key => $val ) {
                //如果键值是数字
                if( is_numeric( $key ) ) {
                    /*
                     $where[0] = array('or'=>array('tid1'=>$tid1,'tid2'=>$tid2));
                     $where[1] = array('or'=>array('aid1'=>$aid1,'aid2'=>$aid2));
                     由and连接的两个or语句 === '(tid1 = $tid1 or tid2=$tid2) and ( aid1 = $aid1 or aid2 = $aid2 )'
                     还比如
                     $where = array('id >0') ====效果为$where[0] = 'id>0';
                     */
                    $_where_clause .= $f . ' ('. $this->_whereBuilder( $val, $f ) . ') ';
                    continue;
                }
                //如果键值不是数字
                $uf = strtoupper($key);
                //如果键值不是数字，并且是 'AND','OR'
                if( in_array( $uf, array('AND','OR') ) ) {
                    //用来解析上面第一种情况 由and连接的两个or语句
                    $_where_clause .= $f . ' ('. $this->_whereBuilder( $val, $uf ) . ') ';
                    continue;
                }
                //如果值是数字
                if( is_numeric( $val ) ) {
                    // 'id=2'
                    $_where_clause .= "{$f} `{$key}` = '{$val}' ";
                } elseif( is_array( $val ) ) { //如果值是数组
                    /**
                     * 支持结构:
                     *  $wheres['status']= array(
                     'gt'=>Cms_Constants::STATUS_DELETED,
                     );
                     */
                    
                    //分析每个为数组的值，并且根据关键字IN等，判断数组怎么显示
                    foreach( $val as $k => $v ) {
                        
                        $k = strtoupper( $k );
                        
                        if( $k == 'IN' ) {
                            $inArr = array();
                            //如果不是数组，则将整个字符串都转化为数组，再进行处理
                            if( is_string($v) ){
                                if( strpos($v, ",") ){
                                    $inArr = explode(',', $v);
                                }else{
                                    $inArr = array($v);
                                }
                            }else{
                                $inArr = $v;
                            }
                            
                            //都转化为数组后
                            if( is_array($inArr) ){
                                $_where_clause .= "{$f} `{$key}` IN ('".implode("','", $inArr)."') ";
                            }
                            
                        }else if( $k == 'NOTIN' ) {
                            $inArr = array();
                            //如果不是数组，则将整个字符串都转化为数组，再进行处理
                            if( is_string($v) ){
                                if( strpos($v, ",") ){
                                    $inArr = explode(',', $v);
                                }else{
                                    $inArr = array($v);
                                }
                            }else{
                                $inArr = $v;
                            }
                            
                            //都转化为数组后
                            if( is_array($inArr) ){
                                $_where_clause .= "{$f} `{$key}` NOT IN ('".implode("','", $inArr)."') ";
                            }
                            
                        }  elseif ( $k == 'LIKE' ) {
                            $_where_clause .= "{$f} `{$key}` LIKE '%". $this->filter($v) ."%' ";
                        } elseif ( $k == 'GT' ) {
                            $_where_clause .= "{$f} `{$key}` > '". $this->escape($v) ."' ";
                        } elseif ( $k == 'LT' ) {
                            $_where_clause .= "{$f} `{$key}` < '". $this->escape($v) ."' ";
                        } elseif ( $k == 'GE' ) {
                            $_where_clause .= "{$f} `{$key}` >= '". $this->escape($v) ."' ";
                        } elseif ( $k == 'LE' ) {
                            $_where_clause .= "{$f} `{$key}` <= '". $this->escape($v) ."' ";
                        } elseif ( $k == 'NE' ) {
                            $_where_clause .= "{$f} `{$key}` != '". $this->escape($v) ."' ";
                        } elseif ( $k == 'CHAR_LENGTH' ) {
                            $_where_clause .= "{$f} CHAR_LENGTH(`{$key}`) = '". $this->escape($v) ."' ";
                        }
                        
                    }
                    
                } else {
                    $_where_clause .= "{$f} `{$key}` = '". $this->escape( $val ) ."' ";
                }
                
            }
            
            if( !empty( $_where_clause ) ) {
                $_where_clause = substr( $_where_clause, 3 );
            }
            
        } else {//如果where条件不是数组
            
            $_where_clause = empty($where_clause) ? ' 1=1' : $where_clause;
        }
        
        return $_where_clause;
        
    }

    /**
     * 
     */
    public function selectAll($sql){
        
        $data = $this->query($sql);
        
        return $data->fetchall();
    }
}
