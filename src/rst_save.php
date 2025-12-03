<?php
require_once 'model.php';
$rst_save = new Restaurant();

$holiday = array_sum($_POST['rst_holiday'] ?? []);

$data =[
     'rst_name'=> $_POST['rst_name']
    ,'rst_address'=> $_POST['rst_address']
    ,'start_time'=> $_POST['start_time']
    ,'end_time'=> $_POST['end_time']
    ,'tel_num'=> $_POST['tel_num']
    ,'rst_holiday'=> $holiday
    ,'rst_pay'=> null
    ,'rst_info'=> $_POST['rst_info'] ?? null
    ,'photo'=> $_POST['photo'] ?? null
    ,'user_id'=> $_POST['user_id']
    ,'discount'=> false
];
if(isset($_POST['rst_pay'])){
    $pay = array_sum($_POST['rst_pay'] ?? []);
    $data['rst_pay'] = $pay;
}

$rst_save->insert($data);

header('Location:rst_list.php');