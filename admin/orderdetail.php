<?php 
  include 'inc/header.php'; 
  include '../classes/brand.php';
  include '../classes/category.php';
  include '../classes/product.php';
  include '../classes/order.php';
  include_once '../helpers/format.php';
?>

<?php 
  $ord = new order();
  $fm = new Format();
  $pd = new product();
  if (isset($_GET['orderid'])) {
      $id = $_GET['orderid'];
  }
?>
  <link rel="stylesheet" href="css/productlist.css">
      <h1 class="dashboard-title">Chi tiết đơn hàng</h1>
      <div class="container">
        <div class="box product-list-box">
          <div class="noti">
          </div>
            <div class="table-container">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Danh mục</th>
                            <th>Thương hiệu</th>
                            <th>Độ đo</th>
                            <th>Giá 1 sản phẩm</th>
                            <th>Sô lượng</th>
                            <th>Tạm tính</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $ordlist = $ord->show_order_details($id);
                        if($ordlist) {
                          $i = 0;
                          while($result = $ordlist->fetch_assoc()){
                            $i = 0;
                            $i++;
                            $pdlist = $pd->show_productfull($result['productId']);
                            if($pdlist) {
                              while($resultpd = $pdlist->fetch_assoc()){
                      ?>
                        <tr class="product-row">
                            <td><?php echo $i ?></td>
                            <td><?php echo $resultpd['productName'] ?></td>
                            <td><img class="product-image" src="./upload/<?php echo $resultpd['image'] ?>" alt=""></td>
                            <td><?php echo $resultpd['catName'] ?></td>
                            <td><?php echo $resultpd['brandName'] ?></td>
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
                            <td><?php echo number_format($result['unitPrice'], 0, ',', '.') ?>đ</td>
                            <td><?php echo $result['quantity'] ?></td>
                            <td><?php echo number_format($result['totalPrice'], 0, ',', '.') ?>đ</td>
                            <!-- ================================================= -->
                  
                           
                        </tr>
                      <?php 
                              }
                            }
                          }
                        }
                      ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
      

<?php 
  include 'inc/footer.php'; 
?>

