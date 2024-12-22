<?php
// Database connection
require_once dirname(__DIR__) . '/lib/connection_no_class.php';
require_once dirname(__DIR__) . '/classes/product.php'; // Adjust the path to the correct location
// Instantiate the Product class
$product = new Product($conn);

?>


<!-- Banner -->
<div class="wrapper-banner">
    <div class="banner">
        <a href="#">
        <?php 
                $get_slider = $product->show_slider();
                if ($get_slider) {
                    while ($result_slider = $get_slider->fetch_assoc()) {
                        if($result_slider['sliderType'] == 0){
                ?>
                <img src="admin/upload/<?php echo htmlspecialchars($result_slider['sliderImage']); ?>" alt="banner1">
                <?php
                    }
                }
                }
                ?>
        </a>
    </div>
</div>

