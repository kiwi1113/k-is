<?php
//列出產品類別第一層
$SQLstring = "SELECT * FROM pyclass where level=1 order by sort";
$pyclass01 = mysqli_query($link, $SQLstring);
$i = 1; //控制編號排序
?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <h1 class="mb-n1"><a class="navbar-brand" href="./index.php" target="_top"><img src="./images/logo-60.png" class="img-fluid" alt="K is."></a></h1>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <?php
    //讀取後台購物車內產品數量
    $SQLstring = "SELECT * FROM cart WHERE orderid is NULL AND ip='".$_SERVER['REMOTE_ADDR']."'";
    $cart_rs = mysqli_query($link,$SQLstring);
    ?>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link nav1" href="hot.php"></a>
            </li>
            <?php while ($pyclass01_Rows = mysqli_fetch_array($pyclass01)) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav<?php echo $i + 1; ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                    </a>
                    <?php
                    //列出產品類別第二層
                    $SQLstring = "SELECT * FROM pyclass where level=2 AND uplink = " . $pyclass01_Rows['classid'] . " order by sort";
                    $pyclass02 = mysqli_query($link, $SQLstring);
                    ?>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php while ($pyclass02_Rows = mysqli_fetch_array($pyclass02)) { ?>
                            <a class="dropdown-item" href="./classitem.php?classid=<?php echo $pyclass02_Rows['classid']; ?>"><?php echo $pyclass02_Rows['cname']; ?></a>
                        <?php } ?>
                    </div>
                </li>
            <?php $i++;
            } ?>
            <li class="nav-item">
                <a class="nav-link nav5" href="#"></a>
            </li>
        </ul>
        <div class="my-2 my-lg-0">
            <ul class="navbar-nav mr-auto">
                <li>
                    <form name="search" id="search" action="classitem.php" method="get">
                        <div class="input-group">
                            <input type="text" name="search_name" id="search_name" class="form-control search" placeholder="Search..." value="<?php echo (isset($_GET['search_name'])) ? $_GET['search_name'] : ''; ?>" required>
                            <span class="input-group-bnt"><button class="btn btn-default" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button></span>
                        </div>
                    </form>
                </li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fa-regular fa-comment fa-lg"></i></a></li>
                <?php if(isset($_SESSION['login'])){ ?>
                <li class="nav-item"><a class="nav-link" href="./member.php"><i class="fa-regular fa-user fa-lg"></i></a></li>
                <?php }else{ ?>
                    <li class="nav-item"><a class="nav-link" href="./login.php"><i class="fa-regular fa-user fa-lg"></i></a></li>
                    <?php } ?>
                <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fa-solid fa-bag-shopping fa-lg""></i><span class="badge badge-dark"><?php echo ($cart_rs)?$cart_rs->num_rows:''; ?></span></a></li>
            </ul>
        </div>
    </div>
</nav>