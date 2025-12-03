<?php
require_once 'model.php';
$review_save = new Review();

$data =[
     'eval_point'=> $_POST['eval_point']
    ,'review_comment'=> $_POST['review_comment'] ?? null
    ,'rst_id'=> $_SESSION['rst_id']
    ,'user_id'=> $_SESSION['user_id']
    ,'photo1'=> $_POST['photo1'] ?? null
    ,'photo2'=> $_POST['photo2'] ?? null
    ,'photo3'=> $_POST['photo3'] ?? null
    ,'rev_state'=> true
];

$review_save->insert($data);

header('Location:rst_detail.php');