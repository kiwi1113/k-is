<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json;charsat=utf-8'); //return json string

require_once('connections/conn_db.php');

if(isset($_POST['cartid']) && isset($_POST['qty'])){
    $cartid = $_POST['cartid'];
    $qty = $_POST['qty'];
    $query = sprintf("UPDATE cart SET qty = '%d' WHERE cart.cartid=%d;",$qty,$cartid);
    $result =mysqli_query($link, $query);
    if ($result){
        $retcode = array ("c" => "1","m" => '謝謝您！產品數量已經更新。');
    }else{
        $recode = array ("c" => "0","m" =>'抱歉，資料無法寫入後台資料庫，請聯絡管理人員。');
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return ;
?>