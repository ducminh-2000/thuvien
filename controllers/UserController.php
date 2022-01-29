<?php
require_once 'controllers/Controller.php';
require_once 'models/tai_khoan.php';
require_once 'models/Pagination.php';
require_once 'models/role.php';
class UserController extends Controller {

    function __construct(){
        $role_model = new Role();
        $roles = $role_model->getAll();
    }

    public function index() {
        $user_model = new TaiKhoan();
        $role_model = new Role();
        $roles = $role_model->getAll();
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $total = $user_model->getTotal();
        $query_additional = '';
        if (isset($_GET['username'])) {
            $query_additional .= "&username=" . $_GET['username'];
        }
        $params = [
            'total' => $total,
            'limit' => 5,
            'query_string' => 'page',
            'controller' => 'user',
            'action' => 'index',
            'page' => $page,
            'query_additional' => $query_additional
        ];
        $pagination = new Pagination($params);
        $pages = $pagination->getPagination();
       
        $users = $user_model->getAllPagination($params);

        // if($_SESSION['user']['roleId'] == 1){
            $this->content = $this->render('views/users/index.php', [
                'users' => $users,
                'roles' => $roles,
                'pages' => $pages,
            ]);

            require_once 'views/layouts/main.php';
        // }
        // else{
        //     $this->content = $this->render('views/homes/home.php', [
        //         'user' => $_SESSION['user'],
        //         'roles' => $roles
        //     ]);

        //     require_once 'views/layouts/main_home.php';
        // }
    }

    public function create() {
        $role_model = new Role();
        $roles = $role_model->getAll();
        $user_model = new TaiKhoan();
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            $name = $_POST['name'];
            $roleId = $_POST['roleId'];
            //xử lý validate
            if (empty($username)) {
                $this->error = 'Username không được để trống';
            } else if (empty($password)) {
                $this->error = 'Password không được để trống';
            } else if (empty($password_confirm)) {
                $this->error = 'Password confirm không được để trống';
            } else if ($password != $password_confirm) {
                $this->error = 'Password confirm chưa đúng';
            } else if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error = 'Email không đúng định dạng';
            } else if (!empty($username)) {
                //kiếm tra xem username đã tồn tại trong DB hay chưa, nếu tồn tại sẽ báo lỗi
                $count_user = $user_model->getUserByUsername($username);
                if ($count_user) {
                    $this->error = 'Username này đã tồn tại trong CSDL';
                }
            }

            //xủ lý lưu dữ liệu khi biến error rỗng
            if (empty($this->error)) {
                $user_model->username = $username;
                //lưu password dưới dạng mã hóa, hiện tại sử dụng cơ chế md5
                $user_model->pass = md5($password);
                $user_model->name = $name;
                $user_model->roleId = $roleId;
                $is_insert = $user_model->insert();
                if ($is_insert) {
                    $_SESSION['success'] = 'Insert dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Insert dữ liệu thất bại';
                }
                header('Location: index.php?controller=user');
                exit();
            }
        }

        $this->content = $this->render('views/users/create.php', ['roles' => $roles]);

        require_once 'views/layouts/main.php';
    }

    public function update() {
        $role_model = new Role();
        $roles = $role_model->getAll();
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header("Location: index.php?controller=user");
            exit();
        }

        $id = $_GET['id'];
        $user_model = new TaiKhoan();
        $user = $user_model->getById($id);
        if (isset($_POST['submit'])) {
            $roleId = $_POST['roleId'];
            $name = $_POST['name'];
            $pass = $_POST['password'];

            //xử lý validate
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error = 'Email không đúng định dạng';
            }

            //xủ lý lưu dữ liệu khi biến error rỗng
            if (empty($this->error)) {
                //xử lý upload ảnh nếu có
                //lưu password dưới dạng mã hóa, hiện tại sử dụng cơ chế md5
                $user_model->name = $name;
                $user_model->pass = md5($pass);
                $user_model->roleId = $roleId;
                $is_update = $user_model->update($id);
                if ($is_update) {
                    $_SESSION['success'] = 'Update dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Update dữ liệu thất bại';
                }
                if($_SESSION['user']['roleId'] == 1){
                    header('Location: index.php?controller=user');
                    exit();
                }
                else{
                    header('Location: index.php?controller=user&action=detail&id='.$_SESSION['user']['id']);
                    exit();
                }
            }
        }
        if($_SESSION['user']['roleId'] == 1){
            $this->content = $this->render('views/users/update.php', [
                'user' => $user,
                'roles' => $roles
            ]);

            require_once 'views/layouts/main.php';
        }
        else{
            $this->content = $this->render('views/users/update_home.php', [
                'user' => $user,
                'roles' => $roles
            ]);

            require_once 'views/layouts/main_home.php';
        }
    }

    public function changePass(){
        $id = $_GET['id'];
        $user_model = new TaiKhoan();
        if (isset($_POST['submit'])) {
            $username = $_SESSION['user']['username'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            $name = $_SESSION['user']['name'];
            $roleId = $_SESSION['user']['roleId'];
            //xử lý validate
            if (empty($password)) {
                $this->error = 'Password không được để trống';
            } else if (empty($password_confirm)) {
                $this->error = 'Password confirm không được để trống';
            } else if ($password != $password_confirm) {
                $this->error = 'Password confirm chưa đúng';
            } 
            //xủ lý lưu dữ liệu khi biến error rỗng
            if (empty($this->error)) {
                $user_model->username = $username;
                //lưu password dưới dạng mã hóa, hiện tại sử dụng cơ chế md5
                $user_model->pass = md5($password);
                $user_model->name = $name;
                $user_model->roleId = $roleId;
                $is_update = $user_model->update($id);
                if ($is_update) {
                    $_SESSION['success'] = 'Đổi thành công';
                } else {
                    $_SESSION['error'] = 'Đổi liệu thất bại';
                }
                // if($_SESSION['user']['roleId'] == 1)
                header('Location: index.php?controller=login&action=login');
                exit();
            }
            
        }
        $this->content = $this->render('views/users/changePass.php');

        require_once 'views/layouts/main_login.php';
    }

    public function delete() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=user');
            exit();
        }

        $id = $_GET['id'];
        $user_model = new TaiKhoan();
        $is_delete = $user_model->delete($id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa dữ liệu thành công';
        } else {
            $_SESSION['error'] = 'Xóa dữ liệu thất bại';
        }
        header('Location: index.php?controller=user');
        exit();
    }

    public function detail() {
        $role_model = new Role();
        $roles = $role_model->getAll();
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header("Location: index.php?controller=user");
            exit();
        }
        $id = $_GET['id'];
        $user_model = new TaiKhoan();
        $user = $user_model->getById($id);
        if($_SESSION['user']['roleId'] == 1){
            $this->content = $this->render('views/users/detail.php', [
                'user' => $user,
                'roles' => $roles,
            ]);
            require_once 'views/layouts/main.php';
        }
        else{
            $this->content = $this->render('views/users/detail_home.php', [
                'user' => $user,
                'roles' => $roles,
            ]);
            require_once 'views/layouts/main_home.php';
        }

        
    }

    public function logout() {

//        session_destroy();
        $_SESSION = [];
        session_destroy();
//        unset($_SESSION['user']);
        $_SESSION['success'] = 'Logout thành công';
        header('Location: index.php?controller=login&action=login');
        exit();
    }
}