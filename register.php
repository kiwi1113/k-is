<?php require_once('connections/conn_db.php') ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('head.php'); ?>

    <link rel="stylesheet" href="./css/hot.css">
    <style>
        span.error-tips,
        span.error-tips::before {
            font-family: "Font Awesome 5 Free";
            color: red;
            font-weight: 900;
        }

        span.valid-tips,
        span.valid-tips::before {
            font-family: "Font Awesome 5 Free";
            color: yellow;
            font-weight: 900;
        }
    </style>
</head>

<body>
    <div class="header">
        <?php require_once('header.php'); ?>
        <script src="./js/commlib.js"></script>
    </div>

    <?php
    if (isset($_POST['formct1']) and $_POST['formct1'] == 'reg') {
        $email = $_POST['email'];
        $pw1 = md5($_POST['pw1']);
        $cname = $_POST['cname'];
        $birthday = $_POST['birthday'];
        $mobile = $_POST['mobile'];
        $myzip = $_POST['myZip'] == '' ? NULL : $_POST['myZip'];
        $address = $_POST['address'] == '' ? NULL : $_POST['address'];
        $insertsql = "INSERT INTO member (email,pw1,cname,birthday) VALUES ('" . $email . "','" . $pw1 . "','" . $cname . "','" . $birthday . "')";
        $Result = mysqli_query($link, $insertsql);
        if ($Result) {
            //讀取刷新的會員編號
            $sqlString = sprintf("SELECT emailid FROM member WHERE email='%s'", $email);
            $Result1 = mysqli_query($link, $sqlString);
            $data = mysqli_fetch_array($Result1);
            //將會員的姓名、電話、地址、郵遞區號寫入addbook
            $insertsql = "INSERT INTO addbook (emailid,setdefault,cname,mobile,myzip,address) VALUES ('" . $data['emailid'] . "','1','" . $cname . "','" . $mobile . "','" . $myzip . "','" . $address . "')";
            $Result = mysqli_query($link, $insertsql);
            //設定會員直接登入
            $_SESSION['login'] = true;
            $_SESSION['emailid'] = $data['emailid'];
            $_SESSION['email'] = $email;
            $_SESSION['cname'] = $cname;
            echo "<script>alert('謝謝您，會員資料已完成註冊');location.href='index.php';</script>";
        }
    }
    ?>
    <div class="className">
        <div class="row mt-5 justify-content-center">
            <div class="card login">
                <div class="card-body">
                    <h2 class="card-title mt-2 text-center">加入會員</h2>
                    <form id="reg" name="reg" action="register.php" method="post">
                        <div class="form-group">
                            <label for="email">帳號(請填Email)</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="請輸入email">
                        </div>
                        <div class="form-group">
                            <label for="pw1">密碼</label>
                            <input type="password" class="form-control" id="pw1" name="pw1" placeholder="請至少輸入六碼">
                        </div>
                        <div class="form-group">
                            <label for="pw2">再次輸入密碼</label>
                            <input type="password" class="form-control" id="pw2" name="pw2" placeholder="請輸入相同密碼">
                        </div>
                        <div class="form-group">
                            <label for="cname">姓名</label>
                            <input type="text" class="form-control" id="cname" name="cname" placeholder="請輸入姓名">
                        </div>
                        <div class="form-group">
                            <label for="birthday">生日</label>
                            <input type="text" class="form-control" id="birthday" name="birthday" onfocus="(this.type='date')" placeholder="請選擇生日">
                        </div>
                        <div class="form-group">
                            <label for="mobile">手機號碼</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="請輸入手機號碼">
                        </div>
                        <div class="form-group">
                            <label for="myCity">居住地</label>
                            <select class="form-control" id="myCity" name="myCity">
                                <option value="">請選擇市區</option>
                                <?php $city = "SELECT * FROM `city` where State=0";
                                $city_rs = mysqli_query($link, $city);
                                while ($city_rows = mysqli_fetch_array($city_rs)) { ?>
                                    <option value="<?php echo $city_rows['AutoNo']; ?>">
                                        <?php echo $city_rows['Name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <select class="form-control" id="myTown" name="myTown">
                                <option value="">請選擇地區</option>
                            </select>
                        </div>
                        <div class="row form-group">
                            <p id="zipcode" name="zipcode">郵遞區號：地址</p>
                            <input type="hidden" id="myZip" name="myZip" value="">
                            <input type="text" class="form-control" id="address" name="address" placeholder="請輸入後續地址">
                        </div>
                        <div class="row form-group">
                            <input type="hidden" id="captcha" name="captcha" value="">
                            <script>
                                gencode01(60, 25, 8, 5, 'gray', 'black', 5, 250, 5, 'captcha', 'new');
                            </script>
                            <a href="javascript:void(0);" onclick="gencode01(60,25,8,5,'gray','black',5,250,5,'captcha','renew');" class="ml-2" title="按我更新認證碼"><i class="fa-solid fa-arrows-rotate"></i></a>
                            <input type="text" class="form-control" id="recaptcha" name="recaptcha" placeholder="請輸入驗證碼">
                        </div>
                        <button type="submit" class="btn btn-main btn-block">註冊</button>
                        <input type="hidden" id="formct1" name="formct1" value="reg">
                    </form>
                    <div class="text-center mt-2"><span>已經是會員？</span><a href="./login.php">請點我登入</a></div>
                </div>
            </div>
        </div>
    </div>

    <hr class="mt-5">
    <div class="footer">
        <?php require_once('footer.php'); ?>
    </div>

    <?php require_once('jsfile.php'); ?>
    <script src="./js/jquery.validate.js"></script>
    <script>
        //驗證form #reg表單
        $('#reg').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: 'checkemail.php'
                },
                pw1: {
                    required: true,
                    maxlength: 20,
                    minlength: 6,
                },
                pw2: {
                    required: true,
                    equalTo: '#pw1'
                },
                cname: {
                    required: true,
                },
                birthday: {
                    required: true,
                },
                mobile: {
                    required: true,
                    checkphone: true,
                },
                address: {
                    required: true,
                },
                recaptcha: {
                    required: true,
                    equalTo: '#captcha',
                }
            },
            messages: {
                email: {
                    required: 'email信箱不得為空白',
                    email: 'email信箱格式有誤',
                    remote: 'email信箱已註冊'
                },
                pw1: {
                    required: '密碼不得為空白',
                    maxlength: '密碼最大長度為20位(6-20位英文字母與數字的組合)',
                    minlength: '密碼最小長度為6位(6-20位英文字母與數字的組合)',
                },
                pw2: {
                    required: '確認密碼不得為空白',
                    equalTo: '兩次輸入的密碼必須一致！'
                },
                cname: {
                    required: '使用者名稱不得為空白',
                },
                birthday: {
                    required: '生日不得為空白',
                },
                mobile: {
                    required: '手機號碼不得為空白',
                    checkphone: '手機號碼格式有誤',
                },
                address: {
                    required: '地址不得為空白',
                },
                recaptcha: {
                    required: '驗證碼不得為空白',
                    equalTo: '驗證碼需相同',
                }
            },
        })
        //自訂電話驗證
        jQuery.validator.addMethod("checkphone", function(value, element, peram) {
            var checkphone = /^[0-9]{10}$/;
            return this.optional(element) || (checkphone.test(value));
        }, "電話格式有誤！");
        //自訂驗證碼格式驗證
        jQuery.validator.addMethod("captcha", function(value, element, peram) {
            var captcha = /^[0-9a-z_A-Z]{5}$/;
            return this.optional(element) || (captcha.test(value));
        }, "驗證碼格式有誤！");
    </script>

    <script>
        //取得縣市碼後查詢鄉鎮市名稱放入#myTown
        $("#myCity").change(function() {
            var CNo = $('#myCity').val();
            $.ajax({
                url: 'Town_ajax.php',
                type: 'post',
                dataType: 'json',
                data: {
                    CNo: CNo
                },
                success: function(data) {
                    if (data.c == true) {
                        $('#myTown').html(data.m);
                        $('#myZip').val(""); //避免重新選擇縣市後郵遞區號還存在，所以在重新選擇縣市後郵遞區號欄位先清空
                    } else {
                        alert("Database reponse error:" + data.m);
                    }
                },
                error: function(data) {
                    alert("ajax request error");
                }
            });
        });

        //選鄉鎮市後，查詢郵遞區號放入#myZip,#zipcode
        $("#myTown").change(function() {
            var AutoNo = $('#myTown').val();
            $.ajax({
                url: 'Zip_ajax01.php',
                type: 'get',
                dataType: 'json',
                data: {
                    AutoNo: AutoNo
                },
                success: function(data) {
                    if (data.c == true) {
                        $('#myZip').val(data.Post);
                        $('#zipcode').html(data.Post + data.Cityname + data.Name);
                    } else {
                        alert("Database reponse error:" + data.m);
                    }
                },
                error: function(data) {
                    alert("ajax request error");
                }
            });
        });
    </script>
</body>

</html>