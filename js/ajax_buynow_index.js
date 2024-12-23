// =============================================================================
//                        Ajax nút mua ngay index
// =============================================================================
document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".buy-now");

  buttons.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault(); // Ngăn chặn hành động mặc định

      const productId = this.closest("form").querySelector("#proid").value;
      const quantity = 1;

      if (!productId) {
        alert("Thông tin sản phẩm không hợp lệ.");
        return;
      }

      // Tạo đối tượng dữ liệu gửi đi qua AJAX
      const data = new FormData();
      data.append("proid", productId);
      data.append("quantity", quantity);
      data.append("action", "buy");

      // Gửi AJAX request
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "../ajax/ajax_buynow_index.php", true);
      xhr.onload = function () {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            if (response.redirect) {
              window.location.href = response.redirect;
            }
          } else {
            if (response.redirect) {
              window.location.href = response.redirect;
            }
          }
        }
      };
      xhr.send(data);
    });
  });
});
