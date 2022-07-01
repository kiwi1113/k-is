<?php
//新版mysql連線
$host = "localhost";
$user = "sales";
$password = "123456";
$database = "expstore";
$link = mysqli_connect($host,$user,$password,$database);
if($link<>false){
    mysqli_query($link,"SET CHARACTER SET UTF8");
}
?>