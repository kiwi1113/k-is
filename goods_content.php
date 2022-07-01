<div class="card mb-3 border-0">
    <div class="row no-gutters d-flex justify-content-around">
        <div class="col-md-5 offset-md-1">
            <?php
            //取得產品圖片檔名資料
            $SQLstring = sprintf("SELECT * FROM product_img WHERE product_img.p_id=%d ORDER BY sort", $_GET['p_id']);
            $img_rs = mysqli_query($link, $SQLstring);
            $imgList = mysqli_fetch_array($img_rs);
            ?>
            <img id="showGoods" name="showGoods" src="./images/<?php echo $imgList['img_file'] ?>" alt="<?php echo $data['p_name'] ?>" title="<?php echo $data['p_name'] ?>" class="img-fluid">
            <div class="row mt-1">
                <?php do { ?>
                    <div class="col-3 pl-0"><a href="./images/<?php echo $imgList['img_file'] ?>" rel="group" class="fancybox" title="<?php echo $data['p_name'] ?>">
                            <img src="./images/<?php echo $imgList['img_file'] ?>" alt="<?php echo $data['p_name'] ?>" title="<?php echo $data['p_name'] ?>" class="img-fluid"></a>
                    </div>
                <?php } while ($imgList = mysqli_fetch_array($img_rs)); ?>
            </div>
        </div>
        <div class="col-md-5 offset-md-1">
            <div class="card-body pl-0">
                <h2 class="card-title fz-4"><?php echo $data['p_name'] ?></h2>
                <p class="card-text"><?php echo $data['p_intro'] ?></p>
                <p class="card-text pt-2"><?php echo $data['p_content'] ?></p>
                <h4 class="fz-2 pt-2">$<?php echo $data['p_price'] ?></h4>
                <div class="row mt-3">
                    <div class="col-6 pl-0">
                        <div class="input-group">
                            <span class="my-auto">數量</span>
                            <input type="number" class="form-control ml-1 search" aria-label="sizing example input" id="qty" name="qty" value="1" aria-describedby="inputGroup-sizing">
                        </div>
                    </div>
                    <div class="col-6 pl-0 my-auto">
                        <button type="button" id="button01" name="button01" class="btn btn-main fz-1 mt-n2 btn-lg my-auto" onclick="addcart(<?php echo $data['p_id']; ?>)">加入購物車</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>