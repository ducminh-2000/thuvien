<?php
require_once 'models/tai_khoan.php';

class LoginController
{
    //chứa nội dung view
    public $content;
    //chứa nội dung lỗi validate
    public $error;

    /**
     * @param $file string Đường dẫn tới file
     * @param array $variables array Danh sách các biến truyền vào file
     * @return false|string
     */
    public function render($file, $variables = []) {
        //Nhập các giá trị của mảng vào các biến có tên tương ứng chính là key của phần tử đó.
        //khi muốn sử dụng biến từ bên ngoài vào trong hàm
        extract($variables);
        //bắt đầu nhớ mọi nội dung kể từ khi khai báo, kiểu như lưu vào bộ nhớ tạm
        ob_start();
        //thông thường nếu ko có ob_start thì sẽ hiển thị 1 dòng echo lên màn hình
        //tuy nhiên do dùng ob_Start nên nội dung của nó đã đc lưu lại, chứ ko hiển thị ra màn hình nữa
        require_once $file;
        //lấy dữ liệu từ bộ nhớ tạm đã lưu khi gọi hàm ob_Start để xử lý, lấy xong rồi xóa luôn dữ liệu đó
        $render_view = ob_get_clean();

        return $render_view;
    }

    public function login() {
        //nếu user đã đăngn hập r thì ko cho truy cập lại trang login, mà chuenr hướng tới backend
        if (isset($_SESSION['user']) && $_SESSION['user']['roleId'] == 1) {
            header('Location: index.php?controller=sach&action=index');
            exit();
        }
        else if(isset($_SESSION['user']) && $_SESSION['user']['roleId'] != 1){
            header('Location: index.php?controller=home');
            exit();
        }
        if (isset($_POST['submit'])) {
//            die;
            $username = $_POST['username'];
            //do password đang lưu trong CSDL sử dụng cơ chế mã hóa md5 nên cần phải thêm
//            hàm md5 cho password
            $password = md5($_POST['password']);
            //validate
            if (empty($username) || empty($password)) {
                $this->error = 'Username hoặc password không được để trống';
            }
            $user_model = new TaiKhoan();
            if (empty($this->error)) {
                $user = $user_model->getAccountByUsernameAndPassword($username, $password);
                if (empty($user)) {
                    $this->error = 'Sai username hoặc password';
                } else {
                    $_SESSION['success'] = 'Đăng nhập thành công';
                    //tạo session user để xác định user nào đang login
                    $_SESSION['user'] = $user;
                    if($user['roleId'] == 1){
                        header("Location: index.php?controller=sach");
                        exit();
                    }
                    else{
                        header("Location: index.php?controller=home");
                        exit();
                    }
                }
            }
        }
        $this->content = $this->render('views/users/login.php');

        require_once 'views/layouts/main_login.php';
    }

    /**
     * Đăng ký tài khoản mới, mặc định tất cả các user đều có quyền guest
     */
    public function register() {

        if (isset($_POST['submit'])) {
            $user_model = new TaiKhoan();
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            $user = $user_model->getAccountByUsername($username);
            //check validate
            if (empty($username) || empty($password) || empty($password_confirm)) {
                $this->error = 'Không được để trống các trường';
            } else if ($password != $password_confirm) {
                $this->error = 'Password nhập lại chưa đúng';
            } else if (!empty($user)) {
                $this->error = 'Username này đã tồn tại';
            }
            //xử lý lưu dữ liệu khi không có lỗi
            if (empty($this->error)) {

                $user_model->username = $username;
                //chú ý password khi lưu vào bảng users sẽ được mã hóa md5 trước khi lưu
                //do đang sử dụng cơ chế mã hóa này cho quy trình login
                $user_model->pass = md5($password);
                $user_model->roleId = 1;
                $is_insert = $user_model->insert();
                if ($is_insert) {
                    $_SESSION['success'] = 'Đăng ký thành công';
                } else {
                    $_SESSION['error'] = 'Đăng ký thất bại';
                }
                header('Location: index.php?controller=login&action=login');
                exit();
            }
        }

        $this->content = $this->render('views/users/register.php');
        require_once 'views/layouts/main_login.php';
    }
}