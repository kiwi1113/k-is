<?php require_once('connections/conn_db.php') ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('head.php'); ?>

    <link rel="stylesheet" href="./css/hot.css">
    <link rel="stylesheet" href="./fancybox-2.1.7/source/jquery.fancybox.css">
</head>

<body>
    <div class="header">
        <?php require_once('header.php'); ?>
    </div>

    <div class="className">
        <div class="row mt-5">
            <div class="col-sm-6">
                <?php require_once('breadcrumb.php'); ?>
            </div>
        </div>
    </div>

    <div class="production">
        <div class="container">
            <div class="row">
                <?php require_once('goods_content.php'); ?>
            </div>
        </div>
    </div>

    <hr class="mt-5">
    <div class="footer">
        <?php require_once('footer.php'); ?>
    </div>

    <?php require_once('jsfile.php'); ?>
    <script src="./fancybox-2.1.7/source/jquery.fancybox.js"></script>
    <script>
        $(function() {
            //定義在滑鼠滑過圖片檔名填入主圖src中
            $(".card .row.d-flex .col-md-5 a").mouseover(function() {
                var imgsrc = $(this).children("img").attr("src");
                $("#showGoods").attr({
                    "src": imgsrc
                });
            })
            //將子圖片放到lightbox展示
            $(".fancybox").fancybox();
        })
    </script>
</body>

</html>