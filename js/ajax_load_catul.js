// =============================================================================
//                             Ajax load catul
// =============================================================================
document.addEventListener("DOMContentLoaded", function () {
  let limit = 20;
  let offset = 0;

  const loadMoreBtn = document.getElementById("load-more");
  const productList = document.getElementById("product-list");
  const search_cat = document.getElementById("search_cat");
  const search_name = document.getElementById("search_name");

  function loadProducts() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/ajax_fetch_products_catul.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      if (xhr.status === 200) {
        productList.innerHTML += xhr.responseText;
        if (xhr.responseText.trim() === "") {
          loadMoreBtn.style.display = "none";
        } else {
          offset += limit; // Cập nhật offset chỉ khi có dữ liệu
        }
      } else {
        console.error("Error loading products");
      }
    };

    // Truyền dữ liệu qua AJAX
    const data = `limit=${limit}&offset=${offset}&search_Cat=${encodeURIComponent(
      search_cat.value
    )}&search_Name=${encodeURIComponent(search_name.value)}`;
    xhr.send(data);
  }

  loadMoreBtn.addEventListener("click", function () {
    loadProducts();
  });

  loadProducts();
});
