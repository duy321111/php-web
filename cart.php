<?php
  include 'inc/header.php'; 
 
  // =============================================================================
  //             Khi nhấn vào tag a có href="?cartid thì sẽ xóa sản phẩm
  // =============================================================================

  if (isset($_GET['cartid'])) {
    $cartid = $_GET['cartid'];
    $delcart = $ct->del_product_cart($cartid);
  }

  // =============================================================================
  //     Khi nhấn button add-item và minus-item sẽ nộp form thay đổi số lượng
  // =============================================================================
  $trigger_outsale = false;
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartId']) && isset($_POST['quantity'])) {
    $cartId = $_POST['cartId'];  // Lấy cartId từ POST
    $quantity = $_POST['quantity'];  // Lấy quantity từ POST
    $productQuantity = $_POST['productQuantity'];
    $trigger_outsale = false;
    if($quantity > $productQuantity){
      $trigger_outsale = true;
    }
    else{
      $update_quantity_cart = $ct->update_quantity_cart($quantity, $cartId);
    }
  }  

  // =============================================================================
  //                  Cập nhật số lượng của bandge giỏ hàng
  // =============================================================================
  $check_cart_reset = $ct->check_cart();
  if($check_cart_reset){
    Session::get('qty');
  }

  $login_check = Session::get('customer_login');
    if($login_check == false){
      header('Location: login.php');
    }
?>



<link rel="stylesheet" href="css/cart.css">

<!-- Nội dung trang -->
<div class="wrapper">
  <div class="wraper-cart-title">
    <span class="cart-title">Giỏ hàng</span>
  </div>
  <div class="wrapper-cart-items">

    <!-- ============================================================================== -->
    <!--           Xuất thông báo sau khi update hoặc delete thay vì ajax               -->
    <!-- ============================================================================== -->
    <?php
      if(isset($delcart)) {
        echo "<span class='success'>" . $delcart . "</span>";
      }
      if (isset($update_quantity_cart)) {
        echo "<span class='success'>" . $update_quantity_cart . "</span>";
      }
    ?>

    <!-- ============================================================================== -->
    <!--     Trường hợp nếu có sản phẩm trong giỏ hàng thì sẽ xuất ra list sản phẩm     -->
    <!-- ============================================================================== -->
    <?php 
      $qty = 0;
      $get_product_cart = $ct->get_product_cart();
      if($get_product_cart){
        $subtotal = 0;
        $total = 0;
        while($result =$get_product_cart->fetch_assoc()){
          // Lấy thông số kỹ thuật của sản phẩm và gắn vào tên để hiện thị đẹp hơn
          $measures = $product->get_measures_by_product($result['productId']);
          $measureText = $result['productName']; 
          if ($measures) {
              while ($measure = $measures->fetch_assoc()) {
                  $measureText .= " / " . $measure['measureName'] . " " . $measure['measureValue'];
              }
          }
          $get_productQuantity = $product->getproductbyId($result['productId']);
          while($get_productQuantity_result =$get_productQuantity->fetch_assoc()){
            $productQuantity_text = $get_productQuantity_result['productQuantity'];
          }

    ?>
      <!-- form để tăng giảm số lượng sản phẩm -->
      <!-- ============================================================================== -->
        <!-- Phần thông tin -->
          <!-- ============================================================================== -->
          <form method="POST" action="">
          <div class="cart-item-info-button">
            <div class="cart-item-info">
              <div class="cart-item-name-image">
                <div class="cart-item-image">
                  <img
                    src="admin/upload/<?php echo $result['image']; ?>"
                    alt="Hình ảnh sản phẩm"
                  />
                </div>
                <span class="cart-item-name"><?php echo $measureText; ?></span>
              </div>
              <div class="cart-item-price">
                <?php echo number_format($result['productPrice'], 0, ',', '.'); ?>đ
              </div>
            </div>
        <!-- Phần nút xóa và tăng giảm -->
          <!-- ============================================================================== -->
              <div class="cart-button">
                <?php
                  if(isset($trigger_outsale) && $trigger_outsale == true){
                    echo "<div class='div-span-error'><span class='error'>Số lượng vừa thêm không khả dụng</span></div>";
                  }
                ?>
                <!-- ========================== -->
                <!-- Nút xóa -->
                <button class="reset-this-item">
                  <a href="?cartid=<?php echo $result['cartId'] ?>">Xóa</a>
                </button>
                <?php
                  if( $productQuantity_text > 0){
                ?>
                <!-- ========================== -->
                <!-- Nút giảm -->
                <button class="minus-item" name="minus" value="minus">
                  <img src="img/minus.png" alt="-" />
                </button>

                <!-- ========================== -->
                <!-- Input này chứa cartID và hidden để phục vụ tính toán, không có mục đích gì thêm -->
                <input
                  type="hidden"
                  name="cartId"
                  value="<?php echo $result['cartId']; ?>"
                />
                <!-- Input số -->
                <input
                  type="number"
                  name="quantity"
                  class="quantity-input"
                  value="<?php echo $result['quantity']; ?>"
                  required
                  min="1"
                  step="1"
                />

                <input
                  hidden
                  type="number"
                  name="productQuantity"
                  value="<?php echo $productQuantity_text; ?>"
                />
                  
                <!-- ========================== -->
                <!-- Nút thêm -->
                <button class="add-item" name="add" value="add">
                  <img src="img/plus.png" alt="+" />
                </button>
                <?php
                  $qty = $qty + $result['quantity'];
                  $total = $result['productPrice'] * $result['quantity'];
                } else{
                  $trigger_het_hang_luc_mua = true;
                  echo "<span class='error'>Sản phẩm hiện đã hết</span>";
                }
                ?>
              </div>
            </div>
          </form>
          <hr>
      <!-- ============================================================================== -->
    <?php
        // Tính tổng tiền = giá mỗi món nhân số lượng
        $subtotal = $subtotal + $total;
        }
      }
    ?>

    <!-- ============================================================================== -->
    <!--     Trường hợp nếu có sản phẩm trong giỏ hàng thì sẽ xuất ra tổng giá tiền     -->
    <!-- ============================================================================== -->
    <?php
    // Kiểm tra có sản phẩm trong giỏ hay không
      $check_cart =$ct->check_cart();
      if($check_cart){
    ?>
    <!-- Nếu có tiến hành in ra tổng tiền -->
      <div class="total">
        <p>Tạm tính:</p>
        <p id="subtotal">
          <?php 
            echo number_format($subtotal, 0, ',', '.'); 
          ?>đ</p>
      </div>
      <!-- <div class="vat">
        <p>Thuế:</p>
        <p id="vat">10%</p> 
      </div> -->
    <?php 
      $grandtotal = $subtotal;
      Session::set('qty',$qty);
    ?>
      </div>
      <!-- ============================================= -->
      <!--  Kết thúc phần giỏ, đây là phần thanh toán    -->
      <!-- ============================================= -->
        <div class="wrapper-cart-items-method">
          <div class="grandtotal">
            <p>Tổng:</p>
            <p id="grandtotal"><?php echo number_format($grandtotal, 0, ',', '.'); ?>đ</p>
          </div>
          <div class="div-thanhtoan">
            <?php 
              // Kiểm tra trigger
              $disableButton = isset($trigger_outsale) && $trigger_outsale === true || isset($trigger_het_hang_luc_mua) && $trigger_het_hang_luc_mua === true;
            ?>
            <a 
              class="thanhtoanbtn <?php echo $disableButton ? 'disabled' : ''; ?>" 
              href="<?php echo !$disableButton ? 'payment.php' : '#'; ?>"
              style="<?php echo $disableButton ? 'background-color: #ccc; color: #ff6600; cursor: not-allowed;' : ''; ?>"
            >
              Đặt mua
            </a>
          </div>
        </div>
      </div>
    <!-- ============================================================================== -->
    <!--  Trường hợp nếu không có sản phẩm trong giỏ hàng thì sẽ xuất ra giỏ hàng trống -->
    <!-- ============================================================================== -->
    <?php
      } else {
        echo "<div class='not-choose'><img src='img/cart-empty.png' alt=''></div>";
        echo "Giỏ hàng chưa có gì.";
        echo "</div></div></form>";
      }
    ?>

<script src="js/cart.js"></script>
<?php
    include 'inc/footer.php';
?>
