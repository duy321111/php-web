<?php
include 'inc/header.php';
require_once '../classes/Product.php';

$product = new Product();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $slider = $product->get_slider_by_id($id);
    if ($slider) {
        $slider = $slider->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_slider'])) {
    $sliderName = $_POST['sliderName'];
    $sliderType = $_POST['sliderType'];
    $sliderImage = $_FILES['sliderImage']['name'];
    $tmp_name = $_FILES['sliderImage']['tmp_name'];

    if ($sliderImage) {
        move_uploaded_file($tmp_name, "upload/$sliderImage");
    } else {
        $sliderImage = $slider['sliderImage'];
    }

    $update_slider = $product->update_slider($id, $sliderName, $sliderType, $sliderImage);
    if ($update_slider) {
        header('Location: sliderlist.php');
    }
}
?>
<link rel="stylesheet" href="css/slideradd.css">

<div class="container-add-banner">
  <div class="box-add-banner">
    <h1 class="page-title-add-banner">Chỉnh sửa Slider</h1>
    <div class="block-add-banner">
      <form action="" method="post" enctype="multipart/form-data">
        <table class="form-add-banner">
          <tr>
            <td class="form-label-cell">
              <label class="form-label-add-banner">Title</label>
            </td>
            <td class="form-input-cell">
              <input
                type="text"
                name="sliderName"
                value="<?php echo htmlspecialchars($slider['sliderName']); ?>"
                class="input-add-banner"
                placeholder="Enter Slider Title..."
              />
            </td>
          </tr>
          <tr>
            <td class="form-label-cell">
              <label class="form-label-add-banner">Type</label>
            </td>
            <td class="form-input-cell">
              <select name="sliderType" class="select-add-banner">
                <option value="1" <?php if ($slider['sliderType'] == 1) echo 'selected'; ?>>On</option>
                <option value="0" <?php if ($slider['sliderType'] == 0) echo 'selected'; ?>>Off</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="form-label-cell">
              <label class="form-label-add-banner">Image</label>
            </td>
            <td class="form-input-cell">
              <input 
                type="file" 
                name="sliderImage" 
                class="input-file-add-banner" 
                id="imageInput"
                accept="image/*"
              />
              
              <div class="image-preview-container">
                <img 
                  id="imagePreview" 
                  src="upload/<?php echo htmlspecialchars($slider['sliderImage']); ?>" 
                  alt="Image Preview" 
                  class="image-preview"
                />
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="form-submit-cell">
                <input
                  type="submit"
                  name="update_slider"
                  value="Update"
                  class="button-add-banner"
                />
              </div>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>

<script>
    // Lấy phần tử preview để hiển thị ảnh
    const preview = document.getElementById('imagePreview');

    // Kiểm tra xem ảnh đã có sẵn chưa và hiển thị nó
    const initialImage = 'upload/<?php echo htmlspecialchars($slider["sliderImage"]); ?>';
    preview.src = initialImage;  // Gán ảnh đã có sẵn vào src
    preview.style.display = 'block';  // Hiển thị ảnh

    // Lắng nghe sự kiện thay đổi của input để thay ảnh khi người dùng chọn file mới
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;  // Gán ảnh mới vào preview
                preview.style.display = 'block';  // Hiển thị ảnh mới
            };
            reader.readAsDataURL(file);  // Đọc file ảnh và chuyển thành URL
        } else {
            preview.src = initialImage;  // Nếu không có ảnh mới, hiển thị ảnh cũ
            preview.style.display = 'block';  // Hiển thị ảnh cũ
        }
    });
</script>


<?php 
    include 'inc/footer.php'; 
?>