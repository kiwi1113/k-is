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

        @media (min-width:757px) {
            .col-md-10>a {
                display: none
            }
        }

        @media (max-width:756px) {
            .row .col-md-2 {
                display: none;
            }

            .col-md-10>a {
                color: rgba(102, 102, 102, 0.9);
                transition: 0.5s;
            }

            .col-md-10>a:hover {
                color: rgba(61, 41, 31, 0.6);
            }

            .col-md-10>h2 {
                display: none;
            }
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
                    <li><a class="btn btn-main btn-block btn-lg">查詢訂單</a></li>
                    <li><a class="btn btn-outline-secondary btn-block btn-lg mt-5" onclick="btn_confirmLink('是否確定登出？','logout.php')">會員登出</a></li>
                </ul>
            </div>
            <div class="col-md-10">
                <?php
                //建立訂單查詢
                $maxRows_rs = 5;
                $pageNum_rs = 0;
                if (isset($_GET['pageNum_order_rs'])) {
                    $pageNum_rs = $_GET['pageNum_order_rs'];
                }
                $startRow_rs = $pageNum_rs * $maxRows_rs;
                $queryFirst = sprintf("SELECT *,uorder.create_date as udata FROM uorder,addbook WHERE uorder.emailid='%d' AND uorder.addressid=addbook.addressid ORDER BY uorder.create_date DESC", $_SESSION['emailid']);
                $query = sprintf("%s LIMIT %d,%d", $queryFirst, $startRow_rs, $maxRows_rs);
                $order_rs = mysqli_query($link, $query);
                $i = 1;
                ?>
                <a href="#" onclick="window.history.go(-1)">
                    <h2 class="fz-4">>訂單查詢</h2>
                </a>
                <h2 class="fz-4">訂單查詢</h2>
                <?php if ($order_rs->num_rows != 0) { ?>
                    <div class="accordion mt-3" id="accordion_order">
                        <?php while ($data01 = mysqli_fetch_array($order_rs)) { ?>
                            <div class="card">
                                <div class="card-header" id="heading1<?php echo $i; ?>">
                                    <a data-toggle="collapse" href="#collapse1<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse1<?php echo $i; ?>">
                                        <div class="table-responsive-md">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td width="10%" class="border-0">訂單編號</td>
                                                        <td width="20%" class="border-0">下單日期時間</td>
                                                        <td width="15%" class="border-0">付款方式</td>
                                                        <td width="15%" class="border-0">訂單狀態</td>
                                                        <td width="10%" class="border-0">收件人</td>
                                                        <td width="20%" class="border-0">地址</td>
                                                        <td width="10%" class="border-0">備註說明</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $data01['orderid']; ?></td>
                                                        <td><?php echo $data01['udata']; ?></td>
                                                        <td><?php echo epayCode($data01['howpay']); ?></td>
                                                        <td><?php echo processCode($data01['status']); ?></td>
                                                        <td><?php echo $data01['cname']; ?></td>
                                                        <td><?php echo $data01['address']; ?></td>
                                                        <td><?php echo $data01['remark']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </a>
                                </div>
                                <?php
                                //建立購物車資料庫查詢
                                $subQuery = sprintf("SELECT * FROM cart,product,product_img WHERE cart.orderid='%s' AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cart.create_date DESC", $data01['orderid']);
                                $details_rs = mysqli_query($link, $subQuery);
                                $pTotal = 0; //設定累加變數$pTotal
                                ?>
                                <div id="collapse1<?php echo $i; ?>" class="collapse <?php echo ($i == 1) ? 'show' : ''; ?>" aria-labelledby="heading1<?php echo $i; ?>" data-parent="#accordion_order">
                                    <div class="card-body">
                                        <h3 class="fz-3">訂單詳情</h3>
                                        <div class="table-responsive-md">
                                            <table class="table table-hover mt-3">
                                                <thead>
                                                    <tr>
                                                        <td width="10%">產品編號</td>
                                                        <td width="10%">圖片</td>
                                                        <td width="25%">名稱</td>
                                                        <td width="15%">價格</td>
                                                        <td width="10%">數量</td>
                                                        <td width="15%">小計</td>
                                                        <td width="15%">狀態</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($data02 = mysqli_fetch_array($details_rs)) { ?>
                                                        <tr>
                                                            <td><?php echo $data02['p_id']; ?></td>
                                                            <td><img src="./images/<?php echo $data02['img_file']; ?>" alt="<?php echo $data02['p_name']; ?>" class="img-fluid">
                                                            </td>
                                                            <td><?php echo $data02['p_name']; ?></td>
                                                            <td>
                                                                <p class="color_e600a0 pt-1"><?php echo $data02['p_price']; ?></p>
                                                            </td>
                                                            <td>
                                                                <p><?php echo $data02['qty']; ?></p>
                                                            </td>
                                                            <td>
                                                                <p class="color_e600a0 pt-1"><?php echo $data02['p_price'] * $data02['qty']; ?></p>
                                                            </td>
                                                            <td><?php echo processCode($data01['status']); ?></td>
                                                        </tr>
                                                    <?php $pTotal += $data02['p_price'] * $data02['qty'];
                                                    } ?>
                                                </tbody>
                                            </table>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <?php $i++;
                        } ?>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <?php
                            //取得目前頁數
                            if (isset($_GET['totalRow_rs'])) {
                                $totalRows_rs = $_GET['totalRow_rs'];
                            } else {
                                $all_rs = mysqli_query($link, $queryFirst);
                                $totalRows_rs = mysqli_num_rows($all_rs);
                            }
                            $totalPages_rs = ceil($totalRows_rs / $maxRows_rs) - 1;
                            ?>
                            <?php
                            //呼叫分頁功能
                            $prev_rs = "&laquo;";
                            $next_rs = "&raquo;";
                            $separator = " | ";
                            $max_links = 20;
                            $pages_rs = buildNavigationP($pageNum_rs, $totalPages_rs, $prev_rs, $next_rs, $separator, $max_links, true, 3, "order_rs");
                            ?>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <?php echo $pages_rs[0] . $pages_rs[1] . $pages_rs[2]; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-dark" role="alert">
                        您目前尚未購買任何商品。
                    </div>
                    <a href="hot.php" class="btn btn-main btn-lg btn-block">前往選購</a>
                <?php } ?>
            </div>
        </div>
    </div>

    <hr class="mt-5">
    <div class="footer">
        <?php require_once('footer.php'); ?>
    </div>

    <?php require_once('jsfile.php'); ?>
</body>

</html>