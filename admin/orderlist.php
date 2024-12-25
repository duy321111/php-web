<?php 
  include 'inc/header.php'; 
  include '../classes/order.php';
  include '../classes/customer.php';
?>
<?php 
  $customer = new customer();
  $order = new order();
?>
<script src="js/ajax_order.js"></script>
<link rel="stylesheet" href="css/order.css">
<h1 class="dashboard-title">Đơn hàng</h1>
<div class="customer-list-wrapper">
  <div class="customer-box">
    <select id="status-filter" onchange="filterTable()">
      <option value="">Tất cả trạng thái</option>
      <option value="pending">Đang xử lý</option>
      <option value="shipping">Đang giao</option>
      <option value="completed">Hoàn tất</option>
      <option value="cancel">Hủy</option>
    </select>
    <select id="payment-status-filter" onchange="filterTable()">
      <option value="">Tất cả tình trạng thanh toán</option>
      <option value="pending">Chưa thanh toán</option>
      <option value="completed">Đã thanh toán</option>
    </select>

    <input type="text" id="search-box" placeholder="Tìm kiếm..." oninput="filterTable()">
    <div class="table-wrapper">
      <table class="customer-table" id="customer-table">
      <thead>
        <tr>
          <th onclick="sortOrderTable(0)">Mã đơn</th>
          <th onclick="sortOrderTable(1)">Tên người nhận</th>
          <th onclick="sortOrderTable(2)">Số điện thoại</th>
          <th onclick="sortOrderTable(3)">Email tài khoản đặt hàng</th>
          <th onclick="sortOrderTable(4)">Ngày đặt</th>
          <th onclick="sortOrderTable(5)">Tình trạng đơn hàng</th>
          <th onclick="sortOrderTable(6)">Phương thức thanh toán</th>
          <th onclick="sortOrderTable(7)">Tình trạng thanh toán</th>
          <th onclick="sortOrderTable(8)">Địa chỉ</th>
          <th onclick="sortOrderTable(9)">Ghi chú</th>
          <th onclick="sortOrderTable(10)">Tổng đơn</th>
          <th>Tùy chọn</th>
        </tr>
      </thead>
        <tbody>
          <?php 
            $show_order = $order->show_order();
            if ($show_order) {
              $i = 0;
              while($result = $show_order->fetch_assoc()) {
                $Cus_in_order = $customer->show_customer($result['customerId']);
                while($row_Cus_in_order = $Cus_in_order->fetch_assoc()){
          ?>
          <tr class="customer-row">
            <td><?php echo $result['orderId'] ?></td>
            <td><?php echo $result['receiverName'] ?></td>
            <td><?php echo $result['receiverPhone'] ?></td>
            <td><?php echo $row_Cus_in_order['email'] ?></td>
            <td><?php echo $result['orderDate'] ?></td>
            <td>
                <select name="status" onchange="updateStatus(this.value, <?php echo $result['orderId']; ?>)">
                    <option value="pending" <?php echo $result['status'] === 'pending' ? 'selected' : ''; ?>>Đang xử lý</option>
                    <option value="shipping" <?php echo $result['status'] === 'shipping' ? 'selected' : ''; ?>>Đang giao</option>
                    <option value="completed" <?php echo $result['status'] === 'completed' ? 'selected' : ''; ?>>Hoàn tất</option>
                    <option value="cancel" <?php echo $result['status'] === 'cancel' ? 'selected' : ''; ?>>Hủy</option>
                </select>
            </td>
            <td><?php echo $result['paymentMethod'] ?></td>
            <td>
                <select name="paymentStatus" onchange="updatePaymentStatus(this.value, <?php echo $result['orderId']; ?>)">
                    <option value="pending" <?php echo $result['paymentStatus'] === 'pending' ? 'selected' : ''; ?>>Chưa thanh toán</option>
                    <option value="completed" <?php echo $result['paymentStatus'] === 'completed' ? 'selected' : ''; ?>>Đã thanh toán</option>
                </select>
            </td>

            <td><?php echo $result['shippingAddress'] ?></td>
            <td><?php echo $result['notes'] ?></td>
            <td><?php echo number_format($result['totalAmount']) ?>đ</td>
            <td>
              <div>
                <a href="orderdetail.php?orderid=<?php echo $result['orderId']; ?>" class="action-link">Chi tiết</a> 
              </div>  
            </td>
          </tr>
          <?php 
                }
              }
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

      
<script src="js/orderlist.js"></script>
<?php 
  include 'inc/footer.php'; 
?>