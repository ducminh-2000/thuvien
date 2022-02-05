<?php
require_once 'controllers/Controller.php';
require_once 'models/sach.php';
require_once 'models/danh_muc_sach.php';
require_once 'models/Pagination.php';

class SachController extends Controller
{
  public function index()
  {
    $sach_model = new Sach();

    //lấy tổng số bản ghi đang có trong bảng sachs
    $count_total = $sach_model->countTotal();
    //        xử lý phân trang
    $query_additional = '';
    if (isset($_GET['title'])) {
      $query_additional .= '&title=' . $_GET['title'];
    }
    if (isset($_GET['danhmucsach_id'])) {
      $query_additional .= '&danhmucsach_id=' . $_GET['danhmucsach_id'];
    }
    $arr_params = [
        'total' => $count_total,
        'limit' => 5,
        'query_string' => 'page',
        'controller' => 'sach',
        'action' => 'index',
        'full_mode' => false,
        'query_additional' => $query_additional,
        'page' => isset($_GET['page']) ? $_GET['page'] : 1
    ];
    $sachs = $sach_model->getAllPagination($arr_params);
    $pagination = new Pagination($arr_params);

    $pages = $pagination->getPagination();

    //lấy danh sách danhmucsach đang có trên hệ thống để phục vụ cho search
    $danhmucsach_model = new DanhMucsach();
    $danhmucsachs = $danhmucsach_model->getAll();
    if($_SESSION['user']['roleId'] == 1){
      $this->content = $this->render('views/sach/index.php', [
          'sachs' => $sachs,
          'danhmucsachs' => $danhmucsachs,
          'pages' => $pages,
      ]);
      require_once 'views/layouts/main.php';
    }
    else{
      $this->content = $this->render('views/sach/menu.php', [
        'sachs' => $sachs,
        'danhmucsachs' => $danhmucsachs,
        'pages' => $pages,
      ]);
  
      require_once 'views/layouts/main_home.php';
    }
  }

  public function create()
  {
    //xử lý submit form
    if (isset($_POST['submit'])) {
      $danhmucsach_id = $_POST['danhmucsach_id'];
      $name = $_POST['name'];
      $quantity = $_POST['quantity'];
      $author = $_POST['author'];
      $xuatBan = $_POST['xuatBan'];
      $description = $_POST['description'];
      //xử lý validate
      if (empty($name)) {
        $this->error = 'Không được để trống name';
      } else if ($_FILES['avatar']['error'] == 0) {
        //validate khi có file upload lên thì bắt buộc phải là ảnh và dung lượng không quá 2 Mb
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        $arr_extension = ['jpg', 'jpeg', 'png', 'gif'];

        $file_size_mb = $_FILES['avatar']['size'] / 1024 / 1024;
        //làm tròn theo đơn vị thập phân
        $file_size_mb = round($file_size_mb, 2);

        if (!in_array($extension, $arr_extension)) {
          $this->error = 'Cần upload file định dạng ảnh';
        } else if ($file_size_mb > 2) {
          $this->error = 'File upload không được quá 2MB';
        }
      }

      //nếu ko có lỗi thì tiến hành save dữ liệu
      if (empty($this->error)) {
        $filename = '';
        //xử lý upload file nếu có
        if ($_FILES['avatar']['error'] == 0) {
          $dir_uploads = __DIR__ . '/../assets/uploads';
          if (!file_exists($dir_uploads)) {
            mkdir($dir_uploads);
          }
          //tạo tên file theo 1 chuỗi ngẫu nhiên để tránh upload file trùng lặp
          $filename = time() . '-sach-' . $_FILES['avatar']['name'];
          move_uploaded_file($_FILES['avatar']['tmp_name'], $dir_uploads . '/' . $filename);
        }
        //save dữ liệu vào bảng sachs
        $sach_model = new Sach();
        $sach_model->danhMucId = $danhmucsach_id;
        $sach_model->name = $name;
        $sach_model->avatar = $filename;
        $sach_model->quantity = $quantity;
        $sach_model->author = $author;
        $sach_model->xuatBan = $xuatBan;
        $sach_model->description = $description;
        $is_insert = $sach_model->insert();
        if ($is_insert) {
          $_SESSION['success'] = 'Insert dữ liệu thành công';
        } else {
          $_SESSION['error'] = 'Insert dữ liệu thất bại';
        }
        header('Location: index.php?controller=sach');
        exit();
      }
    }

    //lấy danh sách danhmucsach đang có trên hệ thống để phục vụ cho search
    $danhmucsach_model = new DanhMucSach();
    $danhmucsachs = $danhmucsach_model->getAll();

    $this->content = $this->render('views/sach/create.php', [
        'danhmucsachs' => $danhmucsachs
    ]);
    require_once 'views/layouts/main.php';
  }

  public function detail()
  {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      $_SESSION['error'] = 'ID không hợp lệ';
      header('Location: index.php?controller=sach');
      exit();
    }

    $id = $_GET['id'];
    $sach_model = new sach();
    $sach = $sach_model->getById($id);

    $this->content = $this->render('views/sach/detail.php', [
        'sach' => $sach
    ]);
    require_once 'views/layouts/main.php';
  }

  public function update()
  {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      $_SESSION['error'] = 'ID không hợp lệ';
      header('Location: index.php?controller=sach');
      exit();
    }

    $id = $_GET['id'];
    $sach_model = new Sach();
    $sach = $sach_model->getById($id);
    //xử lý submit form
    if (isset($_POST['submit'])) {
      $danhmucsach_id = $_POST['danhmucsach_id'];
      $name = $_POST['name'];
      $quantity = $_POST['quantity'];
      $author = $_POST['author'];
      $xuatBan = $_POST['xuatBan'];
      $description = $_POST['description'];
      //xử lý validate
      if (empty($name)) {
        $this->error = 'Không được để trống title';
      } else if ($_FILES['avatar']['error'] == 0) {
        //validate khi có file upload lên thì bắt buộc phải là ảnh và dung lượng không quá 2 Mb
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        $arr_extension = ['jpg', 'jpeg', 'png', 'gif'];

        $file_size_mb = $_FILES['avatar']['size'] / 1024 / 1024;
        //làm tròn theo đơn vị thập phân
        $file_size_mb = round($file_size_mb, 2);

        if (!in_array($extension, $arr_extension)) {
          $this->error = 'Cần upload file định dạng ảnh';
        } else if ($file_size_mb > 2) {
          $this->error = 'File upload không được quá 2MB';
        }
      }

      //nếu ko có lỗi thì tiến hành save dữ liệu
      if (empty($this->error)) {
        $filename = $sach['avatar'];
        //xử lý upload file nếu có
        if ($_FILES['avatar']['error'] == 0) {
          $dir_uploads = __DIR__ . '/../assets/uploads';
          //xóa file cũ, thêm @ vào trước hàm unlink để tránh báo lỗi khi xóa file ko tồn tại
          @unlink($dir_uploads . '/' . $filename);
          if (!file_exists($dir_uploads)) {
            mkdir($dir_uploads);
          }
          //tạo tên file theo 1 chuỗi ngẫu nhiên để tránh upload file trùng lặp
          $filename = time() . '-sach-' . $_FILES['avatar']['name'];
          move_uploaded_file($_FILES['avatar']['tmp_name'], $dir_uploads . '/' . $filename);
        }
        //save dữ liệu vào bảng sachs
        $sach_model = new Sach();
        $sach_model->danhMucId = $danhmucsach_id;
        $sach_model->name = $name;
        $sach_model->avatar = $filename;
        $sach_model->quantity = $quantity;
        $sach_model->author = $author;
        $sach_model->xuatBan = $xuatBan;
        $sach_model->description = $description;
        $sach_model->updated_at = date('Y-m-d H:i:s');

        $is_update = $sach_model->update($id);
        if ($is_update) {
          $_SESSION['success'] = 'Update dữ liệu thành công';
        } else {
          $_SESSION['error'] = 'Update dữ liệu thất bại';
        }
        header('Location: index.php?controller=sach');
        exit();
      }
    }

    //lấy danh sách danhmucsach đang có trên hệ thống để phục vụ cho search
    $danhmucsach_model = new DanhMucSach();
    $danhmucsachs = $danhmucsach_model->getAll();

    $this->content = $this->render('views/sach/update.php', [
        'danhmucsachs' => $danhmucsachs,
        'sach' => $sach,
    ]);
    require_once 'views/layouts/main.php';
  }

  public function delete()
  {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      $_SESSION['error'] = 'ID không hợp lệ';
      header('Location: index.php?controller=sach');
      exit();
    }

    $id = $_GET['id'];
    $sach_model = new sach();
    $is_delete = $sach_model->delete($id);
    if ($is_delete) {
      $_SESSION['success'] = 'Xóa dữ liệu thành công';
    } else {
      $_SESSION['error'] = 'Xóa dữ liệu thất bại';
    }
    header('Location: index.php?controller=sach');
    exit();
  }

  public function showAll() {
    $sach_model = new Sach();
    $count_total = $sach_model->countTotal();
    $params = [];
    $query_additional = '';
    if (isset($_GET['title'])) {
      $query_additional .= '&title=' . $_GET['title'];
    }
    if (isset($_GET['danhmucsach_id'])) {
      $query_additional .= '&danhmucsach_id=' . $_GET['danhmucsach_id'];
    }
    
    $params_pagination = [
      'total' => $count_total,
      'limit' => 5,
      'query_string' => 'page',
      'controller' => 'sach',
      'action' => 'showAll',
      'full_mode' => false,
      'query_additional' => $query_additional,
      'page' => isset($_GET['page']) ? $_GET['page'] : 1
    ];
    //xử lý phân trang
    $pagination_model = new Pagination($params_pagination);
    $pagination = $pagination_model->getPagination();
    //get sachs
    $sach_model = new Sach();
    $sachs = $sach_model->getSachInHomePage($params);

    //get categories để filter
    $danhmucsach_model = new DanhMucSach();
    $danhmucsachs = $danhmucsach_model->getAll();

    $this->content = $this->render('views/sach/menu.php', [
      'sachs' => $sachs,
      'danhmucsachs' => $danhmucsachs,
      'pagination' => $pagination,
    ]);

    require_once 'views/layouts/main_home.php';
  }

  public function detailByGuest() {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      $_SESSION['error'] = 'ID ko hợp lệ';
      $url_redirect = $_SERVER['SCRIPT_NAME'] . '/';
      header("Location: $url_redirect");
      exit();
    }

    $id = $_GET['id'];
    $sach_model = new sach();
    $sach = $sach_model->getById($id);

    $this->content = $this->render('views/sach/detail_home.php', [
      'sach' => $sach
    ]);
    require_once 'views/layouts/main_home.php';
  }

}