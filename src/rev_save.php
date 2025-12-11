<?php
require_once 'model.php';
$review_save = new Review();

function readBlob($key) {
    if (!empty($_FILES[$key]['tmp_name'])) {
        return file_get_contents($_FILES[$key]['tmp_name']);  // バイナリ取得
    }
    return null;
}

$data =[
     'eval_point'=> $_POST['eval_point']
    ,'review_comment'=> $_POST['review_comment'] ?? null
    ,'rst_id'=> $_SESSION['rst_id']
    ,'user_id'=> $_SESSION['user_id']
    ,'photo1'=> readBlob('photo1')
    ,'photo2'=> readBlob('photo2')
    ,'photo3'=> readBlob('photo3')
    ,'rev_state'=> true
];

$review_save->insert($data);

header('Location:rst_detail.php');