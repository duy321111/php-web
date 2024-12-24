<?php
    include 'inc/header.php';
?>
<script src="js/ajax_load_catul.js"></script>
<link rel="stylesheet" href="css/catulproduct.css">
<!-- Trang này thực hiện việc lấy sản phẩm theo category hoặc brand -->
<?php 
    // Xử lý Get khi nhận được từ trang details.php gửi qua
    if (!isset($_GET['search']) || !isset($_GET['name']) || $_GET['name'] == NULL) {
        echo "<script>window.location = 'page404.php'</script>";
    } else {
        $search_cat = $_GET['search'];
        $search_name = $_GET['name']; 
        $btn = true;
    }
?> 

<!-- Nội dung trang -->
<div class="wrapper">
    <!-- ============================================================================== -->
    <!--                             Title của trang                                    -->
    <!-- ============================================================================== -->
    <?php
        $titlePrefix = "Tìm kiếm: ";
    ?>
    <span class="list_title"><?php echo $titlePrefix . $search_cat . " " . $search_name ?></span>
    <!-- ============================================================================== -->
    <!--                          List card sản phẩm                                    -->
    <!-- ============================================================================== -->
    <div class="listcard-button">
        <div class="listcard" id="product-list">
            <?php
                $products = $product->get_product_by_search($search_name, $search_cat);
            
                if ($products) {
            ?>
                <!-- Xuất các phẩn tử card -->
                <!-- card here -->
                
            <?php
                } else {
                    echo "  <div></div>
                            <div></div>
                            <div class='img-out-product'><img src='./img/outproduct.png' alt='Không có sản phẩm'></div>
                            <div></div>
                            <div></div>";
                    $btn = false;
                }
            ?>
        </div>
        <?php
            if (isset($btn) && $btn == true) {
        ?>
            <div class="btn-xemthem-wrapper">
                <input type="text" id="search_name" value="<?php echo $search_name; ?>" hidden />
                <input type="text" id="search_cat" value="<?php echo $search_cat; ?>" hidden />
                <button class="btn-xemthem" id="load-more">Xem thêm sản phẩm</button>
            </div>
        <?php
            } 
        ?>
    </div>
</div>
<?php
    include 'inc/footer.php';
?>