<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../classes/product.php');

    $product = new Product(); // Khởi tạo class sản phẩm

    // Lấy số lượng sản phẩm và offset từ yêu cầu AJAX
    $limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 5;
    $offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0;

    // Gọi hàm lấy sản phẩm từ class Product
    $product_featured = $product->getproduct_featured($limit, $offset);

    if ($product_featured) {
        while ($result = $product_featured->fetch_assoc()) {
            $measures = $product->get_measures_by_product($result['productId']);
            $measureText = $result['productName'];
            if ($measures) {
                while ($measure = $measures->fetch_assoc()) {
                    $measureText .= " / " . $measure['measureName'] . " " . $measure['measureValue'];
                }
            }
            // Xuất HTML sản phẩm
            echo "
            <div class='card'>
                <div class='card-img'>
                    <a href='details.php?proid={$result['productId']}'>
                        <img src='admin/upload/{$result['image']}' alt='Hình ảnh sản phẩm' />
                    </a>
                </div>
                <div class='card-info'>
                    <a href='details.php?proid={$result['productId']}'>
                        <span class='card-name'>{$measureText}</span>
                    </a>
                    <span class='card-price'>" . number_format($result['productPrice'], 0, ',', '.') . "đ</span>
                </div>
                <form id='addToCartForm' method='post'>
                    <input type='text' id='proid' value='{$result['productId']}' hidden />
                    <button class='btnMua buy-now' id='buyNowButton' data-action='buy'>Mua ngay</button>
                </form>
            </div>";
        }
    }
?>
