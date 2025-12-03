<?php
require_once 'model.php';
$user_save = new User();

$user_account = "{$_POSET['user_l_name']} {$_POST['user_f_name']}";

$data =[
     'user_id'=> $_POST['user_id']
    ,'user_l_name'=> $_POST['user_l_name']
    ,'user_f_name'=> $_POST['user_f_name']
    ,'user_l_kana'=> $_POST['user_l_kana']
    ,'user_f_kana'=> $_POST['user_f_kana']
    ,'user_account'=> $user_account
    ,'password'=> $_POST['password']
    ,'user_type_id'=> 1
];

$user_save->insert($data);

header('Location:rst_list.php');