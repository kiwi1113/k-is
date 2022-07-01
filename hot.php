<?php require_once('connections/conn_db.php') ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('head.php'); ?>

    <link rel="stylesheet" href="./css/hot.css">
</head>

<body>
    <div class="header">
        <?php require_once('header.php'); ?>
    </div>
    
    <div class="className">
        <div class="row justify-content-md-center mt-5">
            <div class="col-sm-4 text-center">
                <h2 class="fz-4">熱銷商品</h2>
                <hr>
            </div>
        </div>
    </div>

    <div class="production">
        <div class="container">
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