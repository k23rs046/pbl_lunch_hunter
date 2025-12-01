<?php
class Model
{
    protected $table;
    protected $db;
    protected static $conf = [
        'host'=>'mysql','user'=>'root','pass'=>'root','dbname'=>'test'
    ];

    protected static $codes = [
        'user_type'=>['1'=>'社員','9'=>'管理者']
    ];
}