function filterProductTable() {
  const input = document.getElementById("search-input");
  const filter = input.value.toLowerCase();
  const table = document.getElementById("product-table");
  const rows = table.getElementsByTagName("tr");

  for (let i = 1; i < rows.length; i++) {
    // Bỏ qua hàng tiêu đề
    const row = rows[i];
    let visible = false;

    // Kiểm tra từng cột trong hàng (trừ hình ảnh và tùy chỉnh)
    const cells = row.getElementsByTagName("td");
    for (let j = 0; j < cells.length - 2; j++) {
      const cell = cells[j];
      if (cell && cell.textContent.toLowerCase().includes(filter)) {
        visible = true;
        break;
      }
    }
    row.style.display = visible ? "" : "none";
  }
}

// Thanh lọc theo tồn kho
function filterByQuantity() {
  // Lấy giá trị của thanh kéo
  var rangeValue = document.getElementById("quantity-range").value;
  document.getElementById("slider-value").textContent = rangeValue;

  // Lọc các sản phẩm dựa trên Tồn kho
  var rows = document.querySelectorAll(".product-row");
  rows.forEach(function (row) {
    var quantity = parseInt(row.getAttribute("data-quantity"), 10);

    // Hiển thị sản phẩm nếu Tồn kho >= giá trị của thanh kéo
    if (quantity >= rangeValue) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}

// Sắp xếp
let sortDirection = {}; // Lưu trạng thái sắp xếp cho từng cột

function sortTable(columnIndex) {
  const table = document.getElementById("product-table");
  const tbody = table.querySelector("tbody");
  const rows = Array.from(tbody.querySelectorAll("tr"));

  // Đặt trạng thái sắp xếp cho cột
  sortDirection[columnIndex] = !sortDirection[columnIndex];

  // Sắp xếp hàng
  rows.sort((a, b) => {
    let aValue = a.cells[columnIndex].innerText.trim();
    let bValue = b.cells[columnIndex].innerText.trim();

    // Xử lý giá trị cột Giá (cột 2)
    if (columnIndex === 2) {
      aValue = parseFloat(aValue.replace(/\./g, "").replace(/[^\d.-]/g, "")); // Xóa dấu chấm và ký tự không phải số
      bValue = parseFloat(bValue.replace(/\./g, "").replace(/[^\d.-]/g, ""));
    }

    // Nếu cột là số
    if (columnIndex === 0 || columnIndex === 2 || columnIndex === 7) {
      return sortDirection[columnIndex] ? aValue - bValue : bValue - aValue;
    }

    // Nếu cột là chuỗi
    return sortDirection[columnIndex]
      ? aValue.localeCompare(bValue)
      : bValue.localeCompare(aValue);
  });

  // Cập nhật thứ tự hàng trong bảng
  rows.forEach((row) => tbody.appendChild(row));
}
