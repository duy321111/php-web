function confirmDelete(id) {
  Swal.fire({
    title: "Bạn có chắc là muốn xóa?",
    text: "Bạn sẽ không thể hoàn tác hành động này!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Có, xóa nó!",
    cancelButtonText: "Hủy",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "?del_slider=" + id;
    }
  });
}

$(document).ready(function () {
  setupLeftMenu();
  $(".datatable").dataTable();
  setSidebarHeight();
});

