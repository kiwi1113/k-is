<?php require_once('connections/conn_db.php') ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>
<?php
if (!isset($_SESSION['login'])) {
    $sPath = "login.php?sPath=member";
    header(sprintf(("Location: %s"), $sPath));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('head.php'); ?>
    <link rel="stylesheet" href="./css/hot.css">

    <style>
        .card-body {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <div class="header">
        <?php require_once('header.php'); ?>
    </div>

    <div class="className">
        <div class="row mt-5">
            <div class="col-md-2">
                <ul>
                    <li><a href="./orders.php" class="btn btn-main btn-block btn-lg">查詢訂單</a></li>
                    <li><a class="btn btn-outline-secondary btn-block btn-lg mt-5" onclick="btn_confirmLink('是否確定登出？','logout.php')">會員登出</a></li>
                </ul>
            </div>
        </div>

    </div>

    <hr class="mt-5">
    <div class="footer">
        <?php require_once('footer.php'); ?>
    </div>

    <?php require_once('jsfile.php'); ?>
    
    <script>
        function reportWindowSize() {
            // console.log(document.body.clientWidth)
            if (document.body.clientWidth > 756) {
                location.href = '/K%20is//orders.php'
            }
        }

        window.onresize = reportWindowSize;
        reportWindowSize();
    </script>
</body>

</html>