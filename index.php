<?php require_once('connections/conn_db.php') ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <?php require_once('head.php'); ?>
</head>

<body>
    <div class="header">
        <?php require_once('header.php'); ?>
    </div>

    <div class="banner">
        <?php require_once('carousel.php'); ?>
    </div>

    <div class="news">
        <?php require_once('news.php'); ?>
    </div>

    <div class="brandImage">
        <div class="container">
            <div class="row justify-content-center mt-5 mb-5">
                <div class="col-sm-8">
                    <div class="card">
                        <img src="./images/brandImage.jpg" class="card-img-top" alt="brandImage">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="production" id="production">
        <div class="container">
            <div class="row justify-content-md-center mt-5">
                <div class="col-sm-4 text-center">
                    <h2 class="fz-3 fw-6">BEST SELLERS<span class="pl-3 pr-3">|</span>熱銷商品</h2>
                    <hr>
                </div>
            </div>
            <?php require_once('hProduction.php'); ?>
        </div>
    </div>

    <hr class="mt-5">

    <div class="footer">
        <?php require_once('footer.php'); ?>
    </div>

    <?php require_once('jsfile.php'); ?>
</body>

</html>