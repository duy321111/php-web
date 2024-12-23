<?php 
  include 'inc/header.php'; 
  include '../classes/product.php';

?>
<link rel="stylesheet" href="css/slideradd.css">
<!-- ============================================================================== -->
<!--                           PHP xử lý nút submit                                 -->
<!-- ============================================================================== -->
<?php 
  $product = new product();
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $insertSlider = $product->insert_slider($_POST, $_FILES);
  }
?>

<!-- ============================================================================== -->
<!--                               HTML hiển thị                                    -->
<!-- ============================================================================== -->
<div class="container-add-banner">
  <div class="box-add-banner">
    <h1 class="page-title-add-banner">Thêm banner</h1>
    <div class="block-add-banner">
      
      <form action="slideradd.php" method="post" enctype="multipart/form-data">
      <?php
        if (isset($insertSlider)) {
          echo $insertSlider;
        }
      ?>
        <table class="form-add-banner">
          <tr>
            <td class="form-label-cell">
              <label class="form-label-add-banner">Title</label>
            </td>
            <td class="form-input-cell">
              <input
                type="text"
                name="sliderName"
                placeholder="Enter Slider Title..."
                class="input-add-banner"
              />
            </td>
          </tr>
          <tr>
            <td class="form-label-cell">
              <label class="form-label-add-banner">Image</label>
            </td>
            <td class="form-input-cell">
              <input 
                type="file" 
                name="image" 
                class="input-file-add-banner" 
                id="imageInput" 
                accept="image/*"
              />
              <div class="image-preview-container">
                <img id="imagePreview" src="" alt="Image Preview" class="image-preview">
              </div>
            </td>
          </tr>
          
          <tr>
            <td class="form-label-cell">
              <label class="form-label-add-banner">Type</label>
            </td>
            <td class="form-input-cell">
              <select name="type" id="" class="select-add-banner">
                <option value="1">On</option>
                <option value="0">Off</option>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="2" >
              <div class="form-submit-cell">
              <input
                type="submit"
                name="submit"
                value="Save"
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
  document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block'; // Hiển thị ảnh
      };
      reader.readAsDataURL(file); // Đọc file và chuyển thành URL
    } else {
      preview.src = '';
      preview.style.display = 'none'; // Ẩn nếu không có file
    }
  });
</script>


<?php 
  include 'inc/footer.php'; 
?>