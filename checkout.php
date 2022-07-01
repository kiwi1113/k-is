<?php require_once('connections/conn_db.php') ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>
<?php
if (!isset($_SESSION['login'])) {
    $sPath = "login.php?sPath=checkout";
    header(sprintf(("Location: %s"), $sPath));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('head.php'); ?>

    <link rel="stylesheet" href="./css/hot.css">
    <style>
        .card,
        .col-sm-12.col-md-11.card.mb-4 {
            max-width: 65%;
        }

        .card-body {
            display: flex;
            align-items: center;
        }

        .card-text:last-child {
            margin-bottom: 1rem;
        }

        .justify-content-between .changeadd {
            color: #3D291F;
            text-decoration: underline;
        }

        @media (max-width:768px) {
            .card,
            .col-sm-12.col-md-11.card.mb-4 {
                min-width: 100%;
            }
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

    <div class="info">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-11 mt-2 card mb-4">
                    <?php
                    //取得收件者地址資料
                    $SQLstring = sprintf("SELECT *,city.Name AS ctName,town.Name AS toName FROM addbook,city,town WHERE emailid='%d' AND setdefault='1' AND addbook.myzip=town.Post AND town.AutoNo=city.AutoNo", $_SESSION['emailid']);
                    $addbook_rs = mysqli_query($link, $SQLstring);
                    if ($addbook_rs && $addbook_rs->num_rows != 0) {
                        $data = mysqli_fetch_array($addbook_rs);
                        $cname = $data['cname'];
                        $mobile = $data['mobile'];
                        $myzip = $data['myzip'];
                        $address = $data['address'];
                        $ctName = $data['ctName'];
                        $toName = $data['toName'];
                    }
                    ?>
                    <div class="d-flex justify-content-between mb-2">
                        <h3 class="fz-3">預設寄送資訊</h3>
                        <a href="#" data-toggle="modal" data-target="#staticBackdrop" class="changeadd fz-2 my-auto">變更收件人</a>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>收件人</p>
                        <p><?php echo $cname; ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>收件人電話</p>
                        <p><?php echo $mobile; ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>收件地址</p>
                        <p><?php echo $myzip . $ctName . $toName . $address; ?></p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-11 card mb-4">
                    <h3 class="fz-3 text-left mb-3">付款方式</h3>
                    <select name="pay" id="pay" class="form-control" required>
                        <option value="" id="notWork">請選擇付款方式</option>
                        <option value="home">貨到付款</option>
                        <option value="creditCard">信用卡</option>
                        <option value="transfer">銀行轉帳</option>
                        <option value="epay">電子支付</option>
                    </select>
                    <div class="text-left mt-2 mb-2">
                        <div class="payFor " id="payFor"></div>
                    </div>
                </div>
            </div>

            <?php
            //建立結帳表格資料庫查詢
            $SQLstring = "SELECT * FROM cart,product,product_img WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid is NULL AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cartid DESC";
            $cart_rs = mysqli_query($link, $SQLstring);
            $pTotal = 0; //設定累加變數$pTotal
            ?>
            <div class="row justify-content-center mt-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <p class="card-text col-3">訂單商品</p>
                        <p class="card-text ml-2 col-3">商品名稱</p>
                        <p class="card-text col-2">單價</p>
                        <p class="card-text col-2">數量</p>
                        <p class="card-text text-left col-2">總價</p>
                    </div>
                    <?php while ($cart_data = mysqli_fetch_array($cart_rs)) { ?>
                        <div class="card-body pt-1">
                            <img src="./images/<?php echo $cart_data['img_file']; ?>" alt="<?php echo $cart_data['p_name']; ?>" class="col-3">
                            <p class="card-text ml-2 col-3"><?php echo $cart_data['p_name']; ?></p>
                            <p class="card-text col-2"><?php echo $cart_data['p_price']; ?></p>
                            <p class="card-text col-2"><?php echo $cart_data['qty']; ?></p>
                            <p class="card-text text-left col-2"><?php echo $cart_data['p_price'] * $cart_data['qty']; ?></p>
                        </div>
                    <?php
                        $pTotal += $cart_data['p_price'] * $cart_data['qty'];
                    } ?>
                    <hr>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="d-flex justify-content-between">
                                <p>訂單小計</p>
                                <p>$<?php echo $pTotal; ?></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>訂單運費</p>
                                <p>$100</p>
                            </div>
                            <div class="d-flex justify-content-between fw-6">
                                <p>總金額</p>
                                <p>$<?php echo $pTotal + 100; ?></p>
                            </div>
                            <a href="#" class="btn btn-main btn-block mb-3" id="btn04" name="btn04">確認結帳</a>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center" onclick="window.history.go(-1)" style="cursor:pointer;">>返回購物車</p>
        </div>
    </div>

    <hr class="mt-5">
    <div class="footer">
        <?php require_once('footer.php'); ?>
    </div>

    <?php require_once('jsfile.php'); ?>

    <?php
    //取得所有收件人資料
    $SQLstring = sprintf("SELECT *,city.Name AS ctName,town.Name AS toName FROM addbook,city,town WHERE emailid='%d' AND addbook.myzip=town.Post AND town.AutoNo=city.AutoNo", $_SESSION['emailid']);
    $addbook_rs = mysqli_query($link, $SQLstring);
    ?>
    <div class="modal fade" id="staticBackdrop" data-backdrop="staic" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">收件人資訊</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col">
                                <input type="text" name="cname" id="cname" class="form-control" placeholder="收件人姓名">
                            </div>
                            <div class="col">
                                <input type="tel" name="mobile" id="mobile" class="form-control" placeholder="收件人電話">
                            </div>
                            <div class="col">
                                <select name="myCity" id="myCity" class="form-control">
                                    <option value="">請選擇市區</option>
                                    <?php $city = "SELECT * FROM `city` WHERE State=0 ";
                                    $city_rs = mysqli_query($link, $city);
                                    while ($city_rows = mysqli_fetch_array($city_rs)) { ?>
                                        <option value="<?php echo $city_rows['AutoNo']; ?>">
                                            <?php echo $city_rows['Name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col">
                                <select name="myTown" id="myTown" class="form-control">
                                    <option value="">請選擇地區</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-2">
                                <input type="hidden" name="myzip" id="myzip" value="">
                                <label for="address" id="add_label" name="add_label">郵遞區號：</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="地址">
                            </div>
                        </div>
                        <div class="row mt-4 justify-content-center">
                            <div class="col-auto">
                                <button type="button" class="btn btn-main" id="recipient" name="recipient">新增收件人</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="row">
                        <table class="table">
                            <thead class="mainBGcolor">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">收件人姓名</th>
                                    <th scope="col">電話</th>
                                    <th scope="col">地址</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($data = mysqli_fetch_array($addbook_rs)) { ?>
                                    <tr>
                                        <th scope="row"><input type="radio" name="gridRadios" id="gridRadios[]" value="<?php echo $data['addressid'] ?>" <?php echo ($data['setdefault']) ? 'checked' : ''; ?>></th>
                                        <td><?php echo $data['cname']  ?></td>
                                        <td><?php echo $data['mobile']  ?></td>
                                        <td><?php echo $data['myzip'] . $data['ctName'] . $data['toName'] . $data['address']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">關閉Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="loading" name="loading" style="display: none;position:fixed;width:100%;height:100%;top:0;left:0;background-color:rgba(255,255,255,.5);z-index:9999;"><i class="fas fa-spinner fa-spin fa-5x fa-fw" style="position:absolute;top:50%;left:50%;"></i></div>

    <script>
        //取得縣市碼後察遜鄉鎮市名稱放入#mytown
        $(function() {
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
                        } else {
                            alert("Database reponse error:" + data.m);
                        }
                    },
                    error: function(data) {
                        alert("ajax request error");
                    }
                });
            });
        })

        //選鄉鎮市後，查詢郵遞區號放入#myZip,#add_label
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
                        $('#myzip').val(data.Post);
                        $('#add_label').html('郵遞區號：' + data.Post + data.Cityname + data.Name);
                    } else {
                        alert("Database reponse error:" + data.m);
                    }
                },
                error: function(data) {
                    alert("ajax request error");
                }
            });
        });

        $('#recipient').click(function() {
            var validata = 0,
                msg = "";
            var cname = $("#cname").val();
            var mobile = $("#mobile").val();
            var myzip = $("#myzip").val();
            var address = $("#address").val();
            if (cname == "") {
                msg = msg + "收件人不得為空白！;\n";
                validata = 1;
            }
            if (mobile == "") {
                msg = msg + "電話不得為空白！;\n";
                validata = 1;
            }
            if (myzip == "") {
                msg = msg + "郵遞區號不得為空白！;\n";
                validata = 1;
            }
            if (address == "") {
                msg = msg + "地址不得為空白！;\n";
                validata = 1;
            }
            if (validata) {
                alert(msg);
                return false;
            }
            $.ajax({
                url: 'addbook.php',
                type: 'post',
                dataType: 'json',
                data: {
                    cname: cname,
                    mobile: mobile,
                    myzip: myzip,
                    address: address,
                },
                success: function(data) {
                    if (data.c == true) {
                        alert(data.m)
                        window.location.reload();
                    } else {
                        alert("Database reponse error:" + data.m);
                    }
                },
                error: function(data) {
                    alert("ajax request error");
                }
            });
        })

        $('input[name=gridRadios]').change(function() {
            var addressid = $(this).val();
            $.ajax({
                url: 'changeaddr.php',
                type: 'post',
                dataType: 'json',
                data: {
                    addressid: addressid,
                },
                success: function(data) {
                    if (data.c == true) {
                        alert(data.m)
                        window.location.reload();
                    } else {
                        alert("Database reponse error:" + data.m);
                    }
                },
                error: function(data) {
                    alert("ajax request error");
                }
            });
        })

        $('#btn04').click(function() {
            let msg = "系統將進行結帳處理，請確認產品金額與收件人是否正確！";
            if (!confirm(msg)) return fasle;
            $("#loading").show();
            var addressid = $('input[name=gridRadios]:checked').val();
            $.ajax({
                url: 'addorder.php',
                type: 'post',
                dataType: 'json',
                data: {
                    addressid: addressid,
                },
                success: function(data) {
                    if (data.c == true) {
                        alert(data.m)
                        window.location.href = "index.php";
                    } else {
                        alert("Database reponse error:" + data.m);
                    }
                },
                error: function(data) {
                    alert("ajax request error");
                }
            });
        })

        $('#pay').click(function() {
            $('#notWork').attr('disabled', '');
        })

        $('#pay').change(function() {
            if ($('#pay').val() == 'home') {
                $('#payFor').empty();
                $('#payFor').html(`
                <div class="text-left">
                    <div class="d-flex justify-content-between">
                        <p>收件人</p>
                        <p><?php echo $cname; ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>收件人電話</p>
                        <p><?php echo $mobile; ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>收件地址</p>
                        <p><?php echo $myzip . $ctName . $toName . $address; ?></p>
                    </div>
                </div>
                `);
            } else if ($('#pay').val() == 'creditCard') {
                $('#payFor').empty();
                $('#payFor').html(`
                    <tr>
                        <th scope="row"><input type="radio" name="creditCard" id="creditCard[]" checked></th>
                        <td class="pl-2"><i class="fa-brands fa-cc-visa"></i></td>
                        <td>玉山商業銀行</td>
                        <td>1234 ****</td>
                    </tr>
                    <tr>
                        <th scope="row" class="pt-4"><input type="radio" name="creditCard" id="creditCard[]"></th>
                        <td class="pl-2 pt-4"><i class="fa-brands fa-cc-mastercard"></i></td>
                        <td class="pt-4">玉山商業銀行</td>
                        <td class="pt-4">1234 ****</td>
                    </tr>
                    <tr>
                        <th scope="row" class="pt-4"><input type="radio" name="creditCard" id="creditCard[]"></th>
                        <td class="pl-2 pt-4"><i class="fa-brands fa-cc-jcb"></i></td>
                        <td class="pt-4">玉山商業銀行</td>
                        <td class="pt-4">1234 ****</td>
                    </tr>
                `);
            } else if ($('#pay').val() == 'transfer') {
                $('#payFor').empty();
                $('#payFor').html(`
                    <div class="d-flex justify-content-between">
                        <p>ATM匯款資訊：</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>匯款銀行</p>
                        <p>013 國泰世華銀行</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>姓名</p>
                        <p>林小強</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>匯款帳號</p>
                        <p>1234-4567-7890-1234</p>
                    </div>
                    <p class="card-text">備註：匯款完成後，需要1、2個工作天，待系統入款完成後，將以簡訊通知訂單完成付款。</p>
                `);
            } else if ($('#pay').val() == 'epay') {
                $('#payFor').empty();
                $('#payFor').html(`
                    <tr>
                        <th scope="row"><input type="radio" name="epay" id="epay[]" checked></th>
                        <td class="pl-2">Apple Pay</td>
                    </tr>
                    <tr>
                        <th scope="row" class="pt-4"><input type="radio" name="epay" id="epay[]"></th>
                        <td class="pl-2 pt-4">Line Pay</td>
                    </tr>
                    <tr>
                        <th scope="row" class="pt-4"><input type="radio" name="epay" id="epay[]"></th>
                        <td class="pl-2 pt-4">街口支付</td>
                    </tr>
                `);
            } else {
                $('#payFor').empty();
                $('#payFor').append("<p>請選擇付款方式</p>");
            }
        });
    </script>
</body>

</html>