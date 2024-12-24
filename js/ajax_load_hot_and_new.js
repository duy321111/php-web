// =============================================================================
//                        Ajax xem thêm sản phẩm hot
// =============================================================================
document.addEventListener("DOMContentLoaded", function () {
  let limit = 5;
  let offset = 0;

  const loadMoreBtn = document.getElementById("load-more");
  const productList = document.getElementById("product-list");

  function loadProducts() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/ajax_fetch_products_hot.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      if (xhr.status === 200) {
        productList.innerHTML += xhr.responseText;
        offset += limit;
        attachBuyNowEvent();
        if (xhr.responseText.trim() === "") {
          loadMoreBtn.style.display = "none";
        }
      } else {
        console.error("Error loading products");
      }
    };
    xhr.send("limit=" + limit + "&offset=" + offset);
  }

  loadMoreBtn.addEventListener("click", function () {
    loadProducts();
  });

  loadProducts();
});

// =============================================================================
//                        Ajax xem thêm sản phẩm new
// =============================================================================
document.addEventListener("DOMContentLoaded", function () {
  let newLimit = 5;
  let newOffset = 0;

  const loadMoreNewBtn = document.getElementById("load-more-new");
  const newProductList = document.getElementById("product-list-new");

  function loadNewestProducts() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/ajax_fetch_products_new.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      if (xhr.status === 200) {
        newProductList.innerHTML += xhr.responseText;
        newOffset += newLimit;
        attachBuyNowEvent();
        if (xhr.responseText.trim() === "") {
          loadMoreNewBtn.style.display = "none";
        }
      } else {
        console.error("Error loading new products");
      }
    };
    xhr.send("limit=" + newLimit + "&offset=" + newOffset);
  }

  loadMoreNewBtn.addEventListener("click", function () {
    loadNewestProducts();
  });

  loadNewestProducts();
});
