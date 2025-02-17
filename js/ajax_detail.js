// =============================================================================
//                        Ajax detail mua hàng
// =============================================================================
document.addEventListener("DOMContentLoaded", function () {
  const addToCartButton = document.getElementById("addToCartButton");
  const buyNowButton = document.getElementById("buyNowButton_detail");

  addToCartButton.addEventListener("click", function () {
    handleCartAction("add");
  });

  buyNowButton.addEventListener("click", function () {
    handleCartAction("buy");
  });

  function handleCartAction(action) {
    const productId = document.getElementById("proid").value; // Lấy proid từ input
    const quantity = document.getElementById("quantity-input").value; // Lấy quantity từ input
    const productQuantity = parseInt(
      document.getElementById("productQuantity").value,
      10
    );

    // Kiểm tra nếu giá trị proid và quantity hợp lệ
    if (!productId || !quantity) {
      alert("Thông tin sản phẩm không hợp lệ.");
      return;
    }

    if (quantity > productQuantity) {
      document.getElementById("cartMessage").innerHTML =
        "<span class='error'>Số lượng sản phẩm trong kho không đủ</span>";
      return; // Dừng việc gửi AJAX
    }

    // Tạo đối tượng dữ liệu gửi đi qua AJAX
    const data = new FormData();
    data.append("proid", productId);
    data.append("quantity", quantity);
    data.append("action", action); // Thêm action: add hoặc buy

    // Gửi AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/ajax_add_to_cart.php", true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText); // Phản hồi JSON từ server
        if (response.success) {
          document.getElementById("cartMessage").innerHTML =
            "<span class='success'>" + response.message + "</span>"; // Hiển thị thông báo thành công
          if (response.redirect) {
            window.location.href = response.redirect; // Chuyển hướng nếu có
          }
          if (response.numberItems) {
            document.getElementById("cart-note-absolute").innerHTML =
              response.numberItems;
          }
        } else {
          document.getElementById("cartMessage").innerHTML =
            "<span class='error'>Lỗi: " + response.message + "</span>";
          if (response.redirect) {
            window.location.href = response.redirect; // Chuyển hướng nếu có
          }
        }
      }
    };
    xhr.send(data);
  }
});
