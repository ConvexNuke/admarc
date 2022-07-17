<?php
include("../connection/Functions.php");
$operation = new Functions();

//echo '<pre>';
//print_r($_POST);
//echo '<pre>';
//die();

if (isset($_POST['is_approved']) && isset($_POST['id'])) {
    $is_approved = addslashes($_POST['is_approved']);
    $sale_id = addslashes($_POST['id']);
    $table = 'admarc_sales';
    $data = [
        'is_approved' => $is_approved
    ];
    $where = 'sale_id = ' . $sale_id;
    if ($operation->updateData($table, $data, $where)) {
        echo json_encode(array("code" => 1, "msg" => "Success, redirecting, please wait!"));

    }else{
        echo json_encode(array("code" => 2, "msg" => "Success, redirecting, please wait!"));

    }
}
