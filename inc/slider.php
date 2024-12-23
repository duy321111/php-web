<?php
// Database connection
require_once dirname(__DIR__) . '/lib/connection_no_class.php';
require_once dirname(__DIR__) . '/classes/product.php'; // Adjust the path to the correct location
// Instantiate the Product class
$product = new Product($conn);
?>

<!-- Thêm Slick Carousel CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

<!-- Thêm jQuery và Slick Carousel JavaScript -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<!-- Banner -->
<div class="wrapper-banner">
    <div class="banner slider">
        <?php 
            $get_slider = $product->show_slider();
            if ($get_slider) {
                while ($result_slider = $get_slider->fetch_assoc()) {
                    if($result_slider['sliderType'] == 1){
                        $trigger_slider = true;
        ?>
            <div>
                <img src="admin/upload/<?php echo htmlspecialchars($result_slider['sliderImage']); ?>" alt="banner1">
            </div>
        <?php
                }
            }
        }
        ?>
    </div>
</div>
<?php
    if(isset($trigger_slider) && $trigger_slider == true){
?>
<!-- Khởi tạo Slick Carousel -->
<script type="text/javascript">
    $(document).ready(function(){
        $('.slider').slick({
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: true
        });
    });
</script>
<?php
    }
?>