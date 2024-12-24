<?php
    include 'inc/header.php';
    // Một cái banner nữa ở đây, banner này admin đổi ảnh được
    include 'inc/slider.php';
?>
<script src="js/ajax_load_hot_and_new.js"></script>
<div class="wrapper">
    <!-- ============================================================================== -->
    <!--                         List card sản phẩm hot                                 -->
    <!-- ============================================================================== -->
    <span class="list_title">Sản phẩm hot</span>
    <div class="listcard-button">
        <div class="listcard" id="product-list">
            <!-- Các sản phẩm sẽ được thêm vào đây -->
        </div>
        <div class="btn-xemthem-wrapper">
            <!-- Nút "Xem thêm sản phẩm" -->
            <button class="btn-xemthem" id="load-more">Xem thêm sản phẩm</button>
        </div>
    </div>

    <!-- ============================================================================== -->
    <!--                          Banner tự build PC                                    -->
    <!-- ============================================================================== -->
    <span class="list_title">Tự build PC</span>
    <div class="banner">
        <a href="#">
            <img src="img/banner2.jpg" alt="banner1" />
        </a>
    </div>

    <!-- ============================================================================== -->
    <!--                      List card sản phẩm mới                                    -->
    <!-- ============================================================================== -->
    <div class="list_title">Sản phẩm mới</div>
    <div class="listcard-button">
        <div id="product-list-new" class="listcard">
            <!-- Sản phẩm mới sẽ được tải động tại đây -->
        </div>
        <div class="btn-xemthem-wrapper">
            <button id="load-more-new" class="btn-xemthem">Xem thêm sản phẩm mới</button>
        </div>
    </div>

</div>

<?php
    include 'inc/footer.php';
?>