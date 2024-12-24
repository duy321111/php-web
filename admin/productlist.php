<?php 
  include 'inc/header.php'; 
  include '../classes/brand.php';
  include '../classes/category.php';
  include '../classes/product.php';
  include_once '../helpers/format.php';
?>
<script src="js/productlist.js"></script>
<?php 
  $pd = new product();
  $fm = new Format();
  if (isset($_GET['productid'])) {
      $id = $_GET['productid'];
      $delProduct = $pd->del_product($id);
  }
?>
  <link rel="stylesheet" href="css/productlist.css">
      <h1 class="dashboard-title">Danh sách sản phẩm</h1>
      <div class="container">
        <div class="box product-list-box">
          <div class="noti">
          <?php
            if(isset($delProduct)) {
              echo $delProduct;
            }
          ?>
          </div>
          <div class="search-wrapper">
            <input type="text" id="search-input" placeholder="Tìm kiếm sản phẩm..." onkeyup="filterProductTable()" />
          </div>
          <div class="filter-slider">
            <label for="quantity-range">Lọc sản phẩm theo Tồn kho: <span id="slider-value">0</span></label>
            <input type="range" id="quantity-range" min="0" max="200" value="0" step="1" oninput="filterByQuantity()" />
          </div>
            <div class="table-container">
                <table class="product-table" id="product-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Hình ảnh</th>
                            <th>Danh mục</th>
                            <th>Thương hiệu</th>
                            <th>Độ đo</th>
                            <th>Tồn kho</th>
                            <th>Tùy chỉnh</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $pdlist = $pd->show_product();
                        if($pdlist) {
                          $i = 0;
                          while($result = $pdlist->fetch_assoc()){
                            $i++;
                      ?>
                        <tr class="product-row" data-quantity="<?php echo $result['productQuantity']; ?>">
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['productName'] ?></td>
                            <td><?php echo number_format($result['productPrice'], 0, ',', '.') ?>đ</td>
                            <td><img class="product-image" src="./upload/<?php echo $result['image'] ?>" alt=""></td>
                            <td><?php echo $result['catName'] ?></td>
                            <td><?php echo $result['brandName'] ?></td>
                            <!-- ================================================= -->
                            <td>
                                <?php
                                // Lấy các độ đo từ bảng tbl_measure
                                $measures = $pd->get_measures_by_product($result['productId']);
                                if ($measures) {
                                    while ($measure = $measures->fetch_assoc()) {
                                        // Hiển thị từng độ đo
                                        echo "<div class='measure-item'><span>";
                                        echo $measure['measureName'] . ": " . $measure['measureValue'];
                                        echo "</span></div>";
                                    }
                                } else {
                                    echo "<span>Không có độ đo</span>";
                                }
                                ?>
                            </td>
                            <!-- ================================================= -->

                            <td>
                              <?php 
                               echo $result['productQuantity'];
                              ?>
                            </td>
                            <td>
                              <a href="productedit.php?productid=<?php echo $result['productId'] ?>">Edit</a> 
                              | 
                              <a href="?productid=<?php echo $result['productId'] ?>" class="action-link confirmable" data-message="Bạn có muốn xóa sản phẩm này?">Delete</a>
                            </td>
                        </tr>
                      <?php 
                          }
                        }
                      ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
      
    <script>
      function filterByQuantity() {
        // Lấy giá trị của thanh kéo
        var rangeValue = document.getElementById('quantity-range').value;
        document.getElementById('slider-value').textContent = rangeValue;

        // Lọc các sản phẩm dựa trên Tồn kho
        var rows = document.querySelectorAll('.product-row');
        rows.forEach(function(row) {
          var quantity = parseInt(row.getAttribute('data-quantity'), 10);

          // Hiển thị sản phẩm nếu Tồn kho >= giá trị của thanh kéo
          if (quantity >= rangeValue) {
            row.style.display = '';
          } else {
            row.style.display = 'none';
          }
        });
      }
    </script>




<?php 
  include 'inc/footer.php'; 
?>

