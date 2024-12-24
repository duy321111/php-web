<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../classes/product.php');

    $product = new Product();

    $search_Name = $_POST['search_Name'] ?? "";
    $search_Cat = $_POST['search_Cat'] ?? "";
    $limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 2;
    $offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0;
    $products = $product->get_product_by_search($search_Name, $search_Cat, $limit, $offset);

    if ($products) {
        while ($result = $products->fetch_assoc()) {
            $measures = $product->get_measures_by_product($result['productId']);
            $measureText = $result['productName'];
            if ($measures) {
                while ($measure = $measures->fetch_assoc()) {
                    $measureText .= " / " . $measure['measureName'] . " " . $measure['measureValue'];
                }
            }
            echo "<div class='card'>
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
                    <form>
                        <input type='hidden' id='proid' value='{$result['productId']}' />
                        <button class='btnMua buy-now' data-action='buy'>Mua ngay</button>
                    </form>
                </div>";
        }
    }
?>
