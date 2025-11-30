<?php
class Model
{
    protected $table;
    protected $db;
    protected static $conf = [
        'host'=>'mysql','user'=>'root','pass'=>'root','dbname'=>'test'
    ];

    protected static $codes = [
        'user_type'=>['1'=>'社員','9'=>'管理者'],
        'rst_genre'=>['1'=>'うどん','2'=>'ラーメン','3'=>'その他麺類','4'=>'定食','5'=>'カレー','6'=>'ファストフード',
        '7'=>'カフェ','8'=>'和食','9'=>'洋食','10'=>'焼肉','11'=>'中華','12'=>'その他'],
        'rst_pay'=>['1'=>'現金','2'=>'QRコード','3'=>'電子マネー','4'=>'クレジットカード']
    ];

    function __construct($conf = null){
        self::$conf = $conf?? self::$conf;
        $conn= new mysqli(
            self::$conf['host'], self::$conf['user'],self::$conf['pass'],self::$conf['dbname']
        );
        if($conn->connect_errno){
            die($conn->connect_error);
        }
        $conn->set_charset('utf8');
        $this->db = $conn;
    }
}