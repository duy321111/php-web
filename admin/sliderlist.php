<?php 
    include 'inc/header.php'; 
    require_once '../classes/Product.php'; 
?>
<!-- ============================================================================== -->
<!--                           Link Jquery, CSS, Script                             -->
<!-- ============================================================================== -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="css/sliderlist.css">

<!-- ============================================================================== -->
<!--                   PHP Xử lý khi nhấn nút del và update slider                  -->
<!-- ============================================================================== -->
<?php 
    $product = new Product();
    if (isset($_GET['del_slider'])) {
        $id = $_GET['del_slider'];
        $type = isset($_GET['type']) ? $_GET['type'] : null;
        $del_slider = $product->del_slider($id);
    } 
    if (isset($_GET['type_slider']) && isset($_GET['type'])) {
        $id = $_GET['type_slider'];
        $type = $_GET['type'];
        $update_type_slider = $product->update_type_slider($id, $type);
    }
?>
<!-- ============================================================================== -->
<!--                           Hiện danh sách slider                                -->
<!-- ============================================================================== -->
<h1 class="page-title-banner-list">Danh sách Banner</h1>
<div class="container-banner">
    <div class="box-banner-list">
        <div class="block-banner-list">
            <table class="table-banner-list" id="table-banner-list">
                <thead>
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 15%;">Title</th>
                        <th style="width: 50%;">Image</th>
                        <th style="width: 5%;">Type</th>
                        <th style="width: 25%;">Action</th>
                    </tr>
                </thead>         
                <tbody>
                    <?php 
                        $product = new Product();
                        $get_slider = $product->show_slider();
                        if ($get_slider) {
                            $i = 0;
                            while ($result_slider = $get_slider->fetch_assoc()) {
                                $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($result_slider['sliderName']); ?></td>
                        <td>
                            <img src="./upload/<?php echo htmlspecialchars($result_slider['sliderImage']); ?>" alt="Slider Image">
                        </td>
                        <td>
                            <?php if($result_slider['sliderType'] == 1) { ?>
                                <a href="?type_slider=<?php echo $result_slider['sliderId']; ?>&type=0">On</a>
                                
                            <?php } else { ?>
                                <a href="?type_slider=<?php echo $result_slider['sliderId']; ?>&type=1">Off</a>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="edit_slider.php?id=<?php echo $result_slider['sliderId']; ?>">Edit</a> |
                            <a href="#" onclick="confirmDelete(<?php echo $result_slider['sliderId']; ?>); return false;">Delete</a>
                        </td>
                    </tr>
                    <?php
                            }
                        } else {
                            echo '<tr><td colspan="5">No sliders found.</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <script src="js/sliderlist.js"></script>

<?php 
    include 'inc/footer.php'; 
?>