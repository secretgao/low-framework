<?php

/**
 * 记录日志的方式  文件存储 还是数据库存储
 */
return [
    'DRIVE'=>'file', //file or database 
    'OPTION'=>[
        'PATH'=>SECRET.'\log\\',
    ],
];