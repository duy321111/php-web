// =============================================================================
//                        Đổi màu mỗi combobox
// =============================================================================
const statusFilter = document.getElementById("status-filter");

statusFilter.addEventListener("change", function () {
  const selectedValue = statusFilter.value;

  switch (selectedValue) {
    case "pending":
      statusFilter.style.backgroundColor = "rgb(223, 216, 154)"; // Vàng
      break;
    case "shipping":
      statusFilter.style.backgroundColor = "rgb(164, 204, 230)"; // Xanh da trời
      break;
    case "completed":
      statusFilter.style.backgroundColor = "rgb(133, 255, 103)"; // Xanh lá
      break;
    case "cancel":
      statusFilter.style.backgroundColor = "rgb(255, 99, 71)"; // Đỏ cam
      break;
    default:
      statusFilter.style.backgroundColor = "white"; // Mặc định
  }
});
// =============================================================================
//                        Input search và combobox status
// =============================================================================
function filterTable() {
  const searchInput = document.getElementById("search-box").value.toLowerCase();
  const statusFilter = document.getElementById("status-filter").value;
  const table = document.getElementById("customer-table");
  const rows = table.getElementsByTagName("tr");

  for (let i = 1; i < rows.length; i++) {
    const row = rows[i];
    const cells = row.getElementsByTagName("td");
    const statusCell = row.querySelector("select[name='status']");
    let rowContainsSearchTerm = false;

    // Kiểm tra nội dung tìm kiếm
    for (let j = 0; j < cells.length; j++) {
      if (cells[j].textContent.toLowerCase().includes(searchInput)) {
        rowContainsSearchTerm = true;
        break;
      }
    }

    // Kiểm tra trạng thái
    const matchesStatus =
      !statusFilter || (statusCell && statusCell.value === statusFilter);

    // Hiển thị hàng nếu cả hai điều kiện đều đúng
    row.style.display = rowContainsSearchTerm && matchesStatus ? "" : "none";
  }
}
