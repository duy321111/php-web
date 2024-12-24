function filterAdminTable() {
  const input = document.getElementById("search-input");
  const filter = input.value.toLowerCase();
  const table = document.getElementById("admin-table");
  const rows = table.getElementsByTagName("tr");

  for (let i = 1; i < rows.length; i++) {
    // Bỏ qua hàng tiêu đề (index 0)
    const row = rows[i];
    let visible = false;

    // Kiểm tra từng cột trong hàng
    const cells = row.getElementsByTagName("td");
    for (let j = 0; j < cells.length - 1; j++) {
      // Không kiểm tra cột "Tùy chọn"
      const cell = cells[j];
      if (cell && cell.textContent.toLowerCase().includes(filter)) {
        visible = true;
        break;
      }
    }
    row.style.display = visible ? "" : "none";
  }
}
