// =============================================================================
//                             Ajax load catul
// =============================================================================
document.addEventListener("DOMContentLoaded", function () {
  let limit = 20;
  let offset = 0;

  const loadMoreBtn = document.getElementById("load-more");
  const productList = document.getElementById("product-list");
  const search_name = document.getElementById("search_name");

  function loadProducts() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/ajax_fetch_products_search.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      if (xhr.status === 200) {
        productList.innerHTML += xhr.responseText;
        if (xhr.responseText.trim() === "") {
          loadMoreBtn.style.display = "none";
        } else {
          offset += limit; // Cập nhật offset chỉ khi có dữ liệu
        }
        // Gắn lại sự kiện cho nút "Mua ngay"
        attachBuyNowEvent();
      } else {
        console.error("Error loading products");
      }
    };

    const data = `limit=${limit}&offset=${offset}&search_Name=${encodeURIComponent(
      search_name.value
    )}`;
    xhr.send(data);
  }

  loadMoreBtn.addEventListener("click", function () {
    loadProducts();
  });
  loadProducts();
  attachBuyNowEvent();
});
