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

    <?php
    $levelCnameTitle = "";
    if (isset($_GET['search_name'])) {
        //使用關鍵字查詢
        $levelCnameTitle = "全部商品";
    } elseif (isset($_GET['level']) && isset($_GET['classid'])) {
        //選擇第一層類別
        $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=%d AND classid=%d", $_GET['level'], $_GET['classid']);
        $classid_rs = mysqli_query($link, $SQLstring);
        $data = mysqli_fetch_array($classid_rs);
        $levelCnameTitle = $data['cname'];
    } elseif (isset($_GET['classid'])) {
        //選擇第二層類別
        $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=2 AND classid=%d", $_GET['classid']);
        $classid_rs = mysqli_query($link, $SQLstring);
        $data = mysqli_fetch_array($classid_rs);
        $levelCnameTitle = $data['cname'];
    } ?>
    <div class="className">
        <div class="row mt-5">
            <div class="col-sm-4">
                <?php require_once('breadcrumb.php'); ?>
            </div>
            <div class="col-sm-4 text-center">
                <h2 class="fz-4"><?php echo $levelCnameTitle ?></h2>
                <hr>
            </div>
        </div>

    </div>

    <div class="production">
        <div class="container">
            <?php require_once('product_list.php'); ?>
        </div>
    </div>

    <hr class="mt-5">
    <div class="footer">
        <?php require_once('footer.php'); ?>
    </div>

    <?php require_once('jsfile.php'); ?>
</body>

</html>