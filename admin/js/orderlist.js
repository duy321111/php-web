// =============================================================================
//                        Đổi màu mỗi combobox
// =============================================================================
// Đổi màu mỗi combobox
const statusFilterDropdown = document.getElementById("status-filter");

statusFilterDropdown.addEventListener("change", function () {
  const selectedValue = statusFilterDropdown.value;

  switch (selectedValue) {
    case "pending":
      statusFilterDropdown.style.backgroundColor = "rgb(223, 216, 154)"; // Vàng
      break;
    case "shipping":
      statusFilterDropdown.style.backgroundColor = "rgb(164, 204, 230)"; // Xanh da trời
      break;
    case "completed":
      statusFilterDropdown.style.backgroundColor = "rgb(133, 255, 103)"; // Xanh lá
      break;
    case "cancel":
      statusFilterDropdown.style.backgroundColor = "rgb(255, 99, 71)"; // Đỏ cam
      break;
    default:
      statusFilterDropdown.style.backgroundColor = "white"; // Mặc định
  }
});

// =============================================================================
//                        Input search và combobox status
// =============================================================================
function filterTable() {
  const searchInput = document.getElementById("search-box").value.toLowerCase();
  const statusFilter = document.getElementById("status-filter").value;
  const paymentStatusFilter = document.getElementById(
    "payment-status-filter"
  ).value; // Lấy giá trị từ combo box "Tình trạng thanh toán"
  const table = document.getElementById("customer-table");
  const rows = table.getElementsByTagName("tr");

  for (let i = 1; i < rows.length; i++) {
    const row = rows[i];
    const cells = row.getElementsByTagName("td");
    const statusCell = row.querySelector("select[name='status']");
    const paymentStatusCell = row.querySelector("select[name='paymentStatus']"); // Trường tình trạng thanh toán
    let rowContainsSearchTerm = false;

    // Kiểm tra nội dung tìm kiếm
    for (let j = 0; j < cells.length; j++) {
      if (cells[j].textContent.toLowerCase().includes(searchInput)) {
        rowContainsSearchTerm = true;
        break;
      }
    }

    // Kiểm tra trạng thái đơn hàng
    const matchesStatus =
      !statusFilter || (statusCell && statusCell.value === statusFilter);

    // Kiểm tra tình trạng thanh toán
    const matchesPaymentStatus =
      !paymentStatusFilter ||
      (paymentStatusCell && paymentStatusCell.value === paymentStatusFilter);

    // Hiển thị hàng nếu cả hai điều kiện đều đúng
    row.style.display =
      rowContainsSearchTerm && matchesStatus && matchesPaymentStatus
        ? ""
        : "none";
  }
}

// =============================================================================
//                        Input search và combobox status
// =============================================================================
// Khai báo biến toàn cục để theo dõi trạng thái sắp xếp cho từng cột
let sortDirection = {};

function sortOrderTable(columnIndex) {
  const table = document.getElementById("customer-table");
  const tbody = table.querySelector("tbody");
  const rows = Array.from(tbody.querySelectorAll("tr"));

  // Nếu chưa có trạng thái sắp xếp cho cột này, gán giá trị mặc định
  if (sortDirection[columnIndex] === undefined) {
    sortDirection[columnIndex] = true; // Mặc định là tăng dần
  } else {
    // Đảo ngược trạng thái
    sortDirection[columnIndex] = !sortDirection[columnIndex];
  }

  // Sắp xếp các hàng
  rows.sort((a, b) => {
    let aValue = a.cells[columnIndex].innerText.trim();
    let bValue = b.cells[columnIndex].innerText.trim();

    // Nếu cột là "Tổng đơn" (cột 10), chuyển đổi giá trị thành số
    if (columnIndex === 10) {
      aValue = parseFloat(aValue.replace(/\./g, "").replace(/[^\d.-]/g, ""));
      bValue = parseFloat(bValue.replace(/\./g, "").replace(/[^\d.-]/g, ""));
    }

    // Sắp xếp theo kiểu số nếu cột là ID hoặc Tổng đơn
    if (columnIndex === 0 || columnIndex === 10) {
      return sortDirection[columnIndex] ? aValue - bValue : bValue - aValue;
    }

    // Sắp xếp theo kiểu chuỗi cho các cột khác
    return sortDirection[columnIndex]
      ? aValue.localeCompare(bValue)
      : bValue.localeCompare(aValue);
  });

  // Cập nhật thứ tự hàng trong bảng
  rows.forEach((row) => tbody.appendChild(row));
}
