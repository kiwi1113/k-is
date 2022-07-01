<div class="container">
    <?php
    //建立新聞查詢
    $SQLstring = "SELECT * FROM news order by news_num DESC";
    $news = mysqli_query($link, $SQLstring);
    ?>
    <div class="row justify-content-md-center mt-5 mb-3">
        <div class="col-sm-4 text-center">
            <h2 class="fz-3 fw-6">NEWS<span class="pl-3 pr-3">|</span>最新消息</h2>
            <hr>
        </div>
    </div>
    <div class="row text-center mt-3">
        <?php while ($nList = mysqli_fetch_array($news)) { ?>
            <div class="col-sm-6 col-md-3">
                <div class="card border-0">
                    <a href="">
                        <img src="./images/<?php echo $nList['news_photo']; ?>" class="card-img-top" alt="<?php echo $nList['news_title']; ?>">
                        <div class="card-body">
                            <p class="card-text fz-1 mt-n1"><?php echo $nList['news_update']; ?></p>
                            <p class="card-text fz-2 mt-n3"><?php echo $nList['news_title']; ?></p>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>