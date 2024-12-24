<?php
    include 'inc/header.php';
?>
<script src="js/ajax_load_search.js"></script>
<?php 
    // Xử lý Get khi nhận được từ thanh tìm kiếm
    if (!isset($_GET['search-bar']) || $_GET['search-bar'] == NULL) {
        echo "<script>window.location = 'page404.php'</script>";
    } else {
        $search_name = $_GET['search-bar']; 
        $btn = true;
    }
?>

<!-- Nội dung trang -->
<div class="wrapper">
    <!-- ============================================================================== -->
    <!--                             Title của trang                                    -->
    <!-- ============================================================================== -->
    <?php
        $titlePrefix = "Kết quả tìm kiếm cho: ";
    ?>
    <span class="list_title"><?php echo $titlePrefix . htmlspecialchars($search_name) ?></span>
    <!-- ============================================================================== -->
    <!--                          List card sản phẩm                                    -->
    <!-- ============================================================================== -->
    <div class="listcard-button">
        <div class="listcard" id="product-list">
            <?php
                $products = $product->search_products($search_name);
                
                // Kiểm tra kết quả truy vấn
                if ($products && $products->num_rows > 0) {
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