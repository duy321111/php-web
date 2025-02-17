 <?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/session.php');
    Session::checkLogin();

    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
 ?>
 
 <?php
    class adminlogin {
        private $db;
        private $fm;

        public function __construct() {
            $this->db =new Database();
            $this->fm =new Format();
        }

        public function login_admin($adminUser, $adminPass) {
            // Xử lý và kiểm tra dữ liệu đầu vào
            $adminUser = $this->fm->validation($adminUser);
            $adminPass = $this->fm->validation($adminPass);
        
            $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
            $adminPass = mysqli_real_escape_string($this->db->link, $adminPass);
        
            if (empty($adminUser) || empty($adminPass)) {
                $alert = "Tài khoản và mật khẩu không được để trống";
                return $alert;
            } else {
                // Kiểm tra thông tin đăng nhập
                $query = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' AND adminPass = '$adminPass' LIMIT 1";
                $result = $this->db->select($query);
        
                if ($result != false) {
                    $value = $result->fetch_assoc();
        
                    // Cập nhật thời gian đăng nhập gần nhất
                    $adminId = $value['adminId'];
                    $updateQuery = "UPDATE tbl_admin SET lastLogin = NOW() WHERE adminId = '$adminId'";
                    $this->db->update($updateQuery);
        
                    // Lưu thông tin vào session
                    Session::set('adminlogin', true);
                    Session::set('adminId', $value['adminId']);
                    Session::set('adminUser', $value['adminUser']);
                    Session::set('adminName', $value['adminName']);
        
                    // Chuyển hướng đến trang quản trị
                    header('Location:index.php');
                } else {
                    $alert = "<span class='error'>Tài khoản hoặc mật khẩu sai</span>";
                    return $alert;
                }
            }
        }
    }
 ?>