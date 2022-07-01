<?php require_once('connections/conn_db.php') ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('head.php'); ?>

    <link rel="stylesheet" href="./css/hot.css">
    <style>
        .col-9.productInfo{
            padding-left: 24px;
        }
    </style>
</head>

<body>
    <div class="header">
        <?php require_once('header.php'); ?>
    </div>

    <div class="className">
        <div class="row mt-5 justify-content-md-center">
            <div class="col-sm-4 text-center">
                <h2 class="fz-4">購物袋</h2>
                <hr>
            </div>
        </div>
    </div>


    <div class="production">
        <div class="container">
            <div class="row justify-content-center mt-3 mb-3">
                <?php require_once('cart_content.php'); ?>
            </div>
            <p class="text-center" onclick="window.history.go(-1)" style="cursor:pointer;">>繼續購物</p>
        </div>
    </div>

    <hr class="mt-5">
    <div class="footer">
        <?php require_once('footer.php'); ?>
    </div>

    <?php require_once('jsfile.php'); ?>
    <script>
        //更改數量寫入資料庫
        $("#cartForm1 input").change(function() {
            var qty = $(this).val();
            const cartid = $(this).attr("cartid");
            if (qty <= 0 || qty >= 50) {
                alert("更改數量需大於0以上，以及小於50以下！")
                return false;
            }
            //利用jquery $.ajax函數呼叫後台的addcart.php
            $.ajax({
                url: 'change_qty.php',
                type: 'post',
                dataType: 'json',
                data: {
                    cartid: cartid,
                    qty: qty,
                },
                success: function(data) {
                    if (data.c == true) {
                        // alert(data.m);
                        window.location.reload();
                    } else {
                        alert(data.m);
                    }
                },
                error: function(data) {
                    alert("系統目前無法連接到後台資料庫。")
                }
            });
        })
    </script>
</body>

</html>