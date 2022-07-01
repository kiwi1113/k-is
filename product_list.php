<?php
//建立product藥妝商品rs
$maxRows_rs = 12; //分頁設定數量
$pageNum_rs = 0; //起啟頁 = 0
if (isset($_GET['pageNum_rs'])) {
    $pageNum_rs = $_GET['pageNum_rs'];
}
$startRow_rs = $pageNum_rs * $maxRows_rs;

if(isset($_GET['search_name'])){
    //使用關鍵字查詢
    $queryFirst = sprintf("SELECT * FROM product,product_img,pyclass WHERE p_open = 1 AND product_img.sort=1 AND product.p_id=product_img.p_id AND product.classid=pyclass.classid AND (product.p_name LIKE '%s' OR product.p_price LIKE '%s') ORDER BY product.p_id DESC", '%'.$_GET['search_name'].'%','%'.$_GET['search_name'].'%');
}elseif(isset($_GET['level']) && $_GET['level']==1){
    //使用第一層類別查詢
    $queryFirst = sprintf("SELECT * FROM product,product_img,pyclass WHERE p_open = 1 AND product_img.sort=1 AND product.p_id=product_img.p_id AND product.classid=pyclass.classid AND pyclass.uplink='%d' ORDER BY product.p_id DESC", $_GET['classid']);
}elseif (isset($_GET['classid'])) {
    //使用產品類別查詢
    $queryFirst = sprintf("SELECT * FROM product,product_img WHERE p_open = 1 AND product_img.sort=1 AND product.p_id=product_img.p_id AND product.classid='%d' ORDER BY product.p_id DESC", $_GET['classid']);
} else {
    //列出產品product資料查詢
    $queryFirst = sprintf("SELECT * FROM product,product_img WHERE p_open = 1 AND product_img.sort=1 AND product.p_id=product_img.p_id ORDER BY product.p_id DESC");
}


$query = sprintf("%s LIMIT %d,%d", $queryFirst, $startRow_rs, $maxRows_rs);
$pList01 = mysqli_query($link, $query);

$i = 1; //控制每列row產生
?>
<?php if ($pList01->num_rows != 0) { ?>
    <?php while ($pList01_Rows = mysqli_fetch_array($pList01)) { ?>
        <?php if ($i % 4 == 1) { ?><div class="row text-center"><?php } ?>
            <div class=" col-sm-6 col-md-3 mt-3 mb-3">
                <div class="card border-0">
                    <a href="goods.php?p_id=<?php echo $pList01_Rows['p_id']; ?>"><img src="./images/<?php echo $pList01_Rows['img_file'] ?>" class="card-img-top" alt="HOT<?php echo $pList01_Rows['h_sort'] ?>" title="<?php echo $pList01_Rows['p_name'] ?>"></a>
                    <div class="card-body">
                        <a href="goods.php?p_id=<?php echo $pList01_Rows['p_id']; ?>">
                            <h3 class="card-title fz-2 mt-n3"><?php echo $pList01_Rows['p_name'] ?></h3>
                        </a>
                        <p class="card-text fz-1 mt-n2">NT$<?php echo $pList01_Rows['p_price'] ?></p>
                        <button type="button" id="button01" name="button01" class="btn btn-main fz-1 mt-n2" onclick="addcart(<?php echo $pList01_Rows['p_id']; ?>)">加入購物車</button>
                    </div>
                </div>
            </div>
            <?php if ($i % 4 == 0 || $i == $pList01->num_rows) { ?>
            </div><?php } ?>
    <?php $i++;
    } ?>
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
            $pages_rs = buildNavigationP($pageNum_rs, $totalPages_rs, $prev_rs, $next_rs, $separator, $max_links, true, 3, "rs");
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
        抱歉！目前沒相關產品。
    </div>
<?php } ?>