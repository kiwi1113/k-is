<?php require_once('connections/conn_db.php') ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>
<?php
//取得要返回的php頁面
if(isset($_GET['sPath'])){
    $sPath = $_GET['sPath'] . ".php";
}else{
    //登入完成預設要進入的頁面
    $sPath = "index.php";
}
if(isset($_SESSION['login'])){
    header(sprintf("location: %s",$sPath));
}
?>

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
        <div class="row mt-5 justify-content-center">
            <div class="card login">
                <div class="card-body">
                    <h2 class="card-title mt-2 text-center">登入會員</h2>
                    <form action="" method="POST" id="form1">
                        <div class="form-group">
                            <label for="exampleInputEmail1">帳號</label>
                            <input type="email" id="inputAccount" name="inputAccount" class="form-control" placeholder="Account" required autofocus" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">密碼</label><small><a href="#" class="ml-3">忘記密碼請點我</a></small>
                            <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-main btn-block">登入</button>
                        <div class="text-center mt-2"><span>還不是會員？</span><a href="./register.php">請點我註冊</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr class="mt-5">
    <div class="footer">
        <?php require_once('footer.php'); ?>
    </div>

    <?php require_once('jsfile.php'); ?>
    <script src="./js/commlib.js"></script>
    <script>
        $(function(){
            $('#form1').submit(function(){
                const inputAccount = $('#inputAccount').val();
                const inputPassword = MD5($('#inputPassword').val());
                $('#loading').show();
                //利用$ajax函數呼叫後台的auth_user.php驗證碼
                $.ajax({
                    url: 'auth_user.php',
                    type : 'post',
                    dataType: 'json',
                    data:{
                        inputAccount:inputAccount,
                        inputPassword: inputPassword,
                    },
                    success: function(data){
                        if (data.c == true){
                            alert(data.m);
                            window.location.href=<?php echo $sPath; ?>
                        }else{
                            alert(data.m);
                        }
                    },
                    error: function(data){
                        alert("系統目前無法連到後台資料庫");
                    }
                });
            });
        })
    </script>
    <div id="loading" name="loading" style="display: none;position:fixed;width:100%;height:100%;top:0;left:0;background-color:rgba(255,255,255,.5);z-index:9999;"><i class="fas fa-spinner fa-spin fa-5x fa-fw" style="position:absolute;top:50%;left:50%;"></i></div>
    </script>
</body>

</html>