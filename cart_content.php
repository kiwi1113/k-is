<?php
//建立購物車資料庫查詢
$SQLstring = "SELECT * FROM cart,product,product_img WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid is NULL AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cartid DESC";
$cart_rs = mysqli_query($link, $SQLstring);
$pTotal = 0; //設定累加變數$pTotal
?>
<?php if ($cart_rs->num_rows != 0) { ?>
    <form action="checkout.php" method="post" id="cartForm1" name="cartForm1">
        <?php while ($cart_data = mysqli_fetch_array($cart_rs)) { ?>
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-11 card mb-4">
                    <div class="row no-gutters">
                        <div class="col-3">
                            <img class="img-fluid" src="./images/<?php echo $cart_data['img_file']; ?>" alt="<?php echo $cart_data['p_name']; ?>">
                        </div>
                        <div class="col-9 productInfo">
                            <div class="d-flex justify-content-between">
                                <p class="card-text"><small class="text-muted">產品編號：<?php echo $cart_data['p_id']; ?></small></p>
                                <small><a href="" id="btn[]" name="btn[]" onclick="btn_confirmLink('確定刪除本資料?','shopcart_del.php?mode=1&cartid=<?php echo $cart_data['cartid']; ?>');">移除</a></small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title mt-n3"><?php echo $cart_data['p_name']; ?></h5>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <div class="input-group">
                                    <span class="my-auto">數量</span>
                                    <input type="number" class="form-control col-3 ml-1 search" id="qty[]" name="qty[]" value="<?php echo $cart_data['qty']; ?>" min="1" max="49" cartid="<?php echo $cart_data['cartid']; ?>" required></span>
                                </div>
                                <p class="card-text my-auto"><small class="text-muted">$<?php echo $cart_data['p_price'] * $cart_data['qty']; ?></small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php $pTotal += $cart_data['p_price'] * $cart_data['qty'];
        } ?>

        <div class="row justify-content-center">
            <div class="card col-md-11 mt-2">
                <div class="d-flex justify-content-between mt-3 fz-2 fw-6">
                    <p>訂單總結</p>
                </div>
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
                <button type="submit" class="btn btn-main btn-block mb-3">前往結帳</button>
            </div>
        </div>
    </form>
<?php } else { ?>
    <div class="alert alert-dark" role="alert">購物車目前還沒有放入商品。</div>
<?php } ?>