<?php
require_once 'controllers/Controller.php';
require_once 'models/role.php';
require_once 'models/Pagination.php';

class RoleController extends Controller
{

  public function index()
  {
    //hiển thị danh sách role
    $role_model = new Role();
    //do có sử dụng phân trang nên sẽ khai báo mảng các params
    $params = [
      'limit' => 5, //giới hạn 5 bản ghi 1 trang
      'query_string' => 'page',
      'controller' => 'role',
      'action' => 'index',
      'full_mode' => FALSE,
    ];
//    mặc đinh page hiện tại là 1
    $page = 1;
    //nếu có truyền tham số page lên trình duyêt - tương đương đang ở tại trang nào, thì gán giá trị đó cho biến $page
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    }
    //xử lý form tìm kiếm
    if (isset($_GET['name'])) {
      $params['query_additional'] = '&name=' . $_GET['name'];
    }

    //lấy tổng số bản ghi dựa theo các điều kiện có được từ mảng params truyền vào
    $count_total = $role_model->getTotal();
    $params['total'] = $count_total;

    //gán biến name cho mảng params với key là name
    $params['page'] = $page;
    $pagination = new Pagination($params);
    //lấy ra html phân trang
    $pages = $pagination->getPagination();

    //lấy danh sách role sử dụng phân trang
    $roles = $role_model->getAllPagination($params);

    $this->content = $this->render('views/roles/index.php', [
      //truyền biến $categories ra vew
      'roles' => $roles,
      //truyền biến phân trang ra view
      'pages' => $pages,
    ]);

    //gọi layout để nhúng thuộc tính $this->content
    require_once 'views/layouts/main.php';
  }

  public function create()
  {
    if (isset($_POST['submit'])) {
      $name = $_POST['name'];
      //check validate
      if (empty($name)) {
        $this->error = 'Cần nhập tên';
      }
      if (empty($this->error)) {
        //lưu vào csdl
        //gọi model để thực  hiện lưu
        $role_model = new role();
        //gán các giá trị từ form cho các thuộc tính của role
        $role_model->name = $name;
        // $role_model->avatar = $avatar;
        // $role_model->description = $description;
        // $role_model->accountId = $_SESSION['user']['id'];
        //gọi phương thức insert
        $is_insert = $role_model->insert();
        if ($is_insert) {
          $_SESSION['success'] = 'Thêm mới thành công';
        } else {
          $_SESSION['error'] = 'Thêm mới thất bại';
        }
        header('Location: index.php?controller=role&action=index');
        exit();
      }

    }

    //lấy nội dung view create.php
    $this->content = $this->render('views/roles/create.php');
    //gọi layout để nhúng nội dung view create vừa lấy đc
    require_once 'views/layouts/main.php';
  }

  public function update()
  {
    //về cơ bản update sẽ khá giống create
    //lấy role theo id bắt đươc
    //check validate nếu id không tồn tại thì báo lỗi
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      $_SESSION['error'] = 'ID role không hợp lệ';
      header('Location: index.php?controller=role&action=index');
      exit();
    }

    $id = $_GET['id'];
    $role_model = new role();
    $role = $role_model->getById($id);
    //submit form
    if (isset($_POST['submit'])) {
      $name = $_POST['name'];
      // $description = $_POST['description'];
      // $status = $_POST['status'];
      // $avatar_files = $_FILES['avatar'];

      //check validate
      if (empty($name)) {
        $this->error = 'Cần nhập tên';
      } 
      if (empty($this->error)) {
        //lưu vào csdl
        //gọi model để thực  hiện lưu
        $role_model = new role();
        //gán các giá trị từ form cho các thuộc tính của role
        $role_model->name = $name;
        // $role_model->avatar = $avatar;
        // $role_model->description = $description;
        // $role_model->status = $status;
        $role_model->updated_at = date('Y-m-d H:i:s');
        //gọi phương thức update theo id
        $is_update = $role_model->update($id);
        if ($is_update) {
          $_SESSION['success'] = 'Update thành công';
        } else {
          $_SESSION['error'] = 'Update thất bại';
        }
        header('Location: index.php?controller=role&action=index');
        exit();
      }

    }

    //lấy nội dung view create.php
    $this->content = $this->render('views/roles/update.php', ['role' => $role]);
    //gọi layout để nhúng nội dung view create vừa lấy đc
    require_once 'views/layouts/main.php';
  }

  public function delete()
  {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      $_SESSION['error'] = 'ID không hợp lệ';
      header('Location: index.php?controller=role&action=index');
      exit();
    }
    $id = $_GET['id'];
    $role_model = new role();
    $is_delete = $role_model->delete($id);
    if ($is_delete) {
      $_SESSION['success'] = 'Xóa thành công';
    } else {
      $_SESSION['error'] = 'Xóa thất bại';
    }
    header('Location: index.php?controller=role&action=index');
    exit();
  }

  public function detail()
  {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      $_SESSION['error'] = 'ID không hợp lệ';
      header('Location: index.php?controller=role&action=index');
      exit();
    }
    $id = $_GET['id'];
    $role_model = new role();
    $role = $role_model->getById($id);
    //lấy nội dung view create.php
    $this->content = $this->render('views/roles/detail.php', [
      'role' => $role
    ]);
    //gọi layout để nhúng nội dung view detail vừa lấy đc
    require_once 'views/layouts/main.php';

  }
}
