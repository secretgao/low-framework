<?php
/**
 * Date: 2018/7/9
 * Time: 16:21
 */

function p($var)
{
    if(is_bool($var)){
        var_dump($var);
    }elseif(is_null($var)){
        var_dum(null);
    }else{
        echo "<pre style='position:relative;z-index:999;padding:10px;border-radius:5px;background:#ccc;border:1px solid #aaa;font-zize:14px;line-height:18px;opacity:0.9;'>".print_r($var,true)."</pre>";
    }
}