<?php
require_once 'models/Model.php';

class Sach extends Model
{

    public $id;
    public $danhMucid;
    public $name;
    public $avatar;
    public $quantity;
    public $author;
    public $description;
    public $xuatBan;
    public $created_at;
    public $updated_at;
    /*
     * Chuỗi search, sinh tự động dựa vào tham số GET trên Url
     */
    public $str_search = '';

    public function __construct()
    {
        parent::__construct();
        if (isset($_GET['title']) && !empty($_GET['title'])) {
            $this->str_search .= " AND sach.name LIKE '%{$_GET['title']}%'";
        }
        if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
            $this->str_search .= " AND sach.danhMucId = {$_GET['category_id']}";
        }
    }

    /**
     * Lấy thông tin của sản phẩm đang có trên hệ thống
     * @return array
     */
    public function getAll()
    {
        $obj_select = $this->connection
            ->prepare("SELECT sach.*, danh_muc_sach.name AS category_name FROM sach
                        INNER JOIN danh_muc_sach ON danh_muc_sach.id = sach.danhMucId
                        WHERE TRUE $this->str_search
                        ORDER BY sach.createdAt DESC
                        ");

        $arr_select = [];
        $obj_select->execute($arr_select);
        $products = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    /**
     * Lấy thông tin của sản phẩm đang có trên hệ thống
     * @param array Mảng các tham số phân trang
     * @return array
     */
    public function getAllPagination($arr_params)
    {
        $limit = $arr_params['limit'];
        $page = $arr_params['page'];
        $start = ($page - 1) * $limit;
        $obj_select = $this->connection
            ->prepare("SELECT sach.*, danh_muc_sach.name AS category_name FROM sach 
                        INNER JOIN danh_muc_sach ON danh_muc_sach.id = sach.danhMucId
                        WHERE TRUE $this->str_search
                        ORDER BY sach.updatedAt DESC,sach.createdAt DESC
                        LIMIT $start, $limit
                        ");

        $arr_select = [];
        $obj_select->execute($arr_select);
        $products = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    /**
     * Tính tổng số bản ghi đang có trong bảng products
     * @return mixed
     */
    public function countTotal()
    {
        $obj_select = $this->connection->prepare("SELECT COUNT(id) FROM sach WHERE TRUE $this->str_search");
        $obj_select->execute();

        return $obj_select->fetchColumn();
    }

    /**
     * Insert dữ liệu vào bảng products
     * @return bool
     */
    public function insert()
    {
        $obj_insert = $this->connection
            ->prepare("INSERT INTO sach(danhMucId, name, avatar, quantity, description, author, xuatBan) 
                                VALUES (:danhMucId, :name, :avatar, :quantity, :description, :author, :xuatBan)");
        $arr_insert = [
            ':danhMucId' => $this->danhMucId,
            ':name' => $this->name,
            ':avatar' => $this->avatar,
            ':quantity' => $this->quantity,
            ':description' => $this->description,
            ':author' => $this->author,
            ':xuatBan' => $this->xuatBan
        ];
        return $obj_insert->execute($arr_insert);
    }

    /**
     * Lấy thông tin sản phẩm theo id
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $obj_select = $this->connection
            ->prepare("SELECT sach.*, danh_muc_sach.name AS category_name FROM sach 
          INNER JOIN danh_muc_sach ON sach.danhMucId = danh_muc_sach.id WHERE sach.id = $id");

        $obj_select->execute();
        return $obj_select->fetch(PDO::FETCH_ASSOC);
    }


    public function update($id)
    {
        $obj_update = $this->connection
            ->prepare("UPDATE sach SET danhMucId=:danhMucId, name=:name, avatar=:avatar, quantity=:quantity,
            description=:description, author=:author, xuatBan=:xuatBan, updatedAt=:updatedAt WHERE id = $id
");
        $arr_update = [
            ':danhMucId' => $this->danhMucId,
            ':name' => $this->name,
            ':avatar' => $this->avatar,
            ':quantity' => $this->quantity,
            ':description' => $this->description,
            ':author' => $this->author,
            ':xuatBan' => $this->xuatBan,
            ':updatedAt' => $this->updated_at,
        ];
        return $obj_update->execute($arr_update);
    }

    public function delete($id)
    {
        $obj_delete = $this->connection
            ->prepare("DELETE FROM sach WHERE id = $id");
        return $obj_delete->execute();
    }

    public function getSachInHomePage($params = []) {
        $str_filter = '';
        if (isset($params['danhmucsach'])) {
          $str_danhmuc = $params['danhmucsach'];
          $str_filter .= " AND danh_muc_sach.id IN $str_danhmuc";
        }
        if (isset($params['xuatBan'])) {
          $str_xuatBan = $params['xuatBan'];
          $str_filter .= " AND $str_xuatBan";
        }
        if(isset($params['name'])){
            $str_name = $params['name'];
            $str_filter.= " AND sach.name LIKE %$str_name%";
        }
        //do cả 2 bảng products và categories đều có trường name, nên cần phải thay đổi lại tên cột cho 1 trong 2 bảng
        $sql_select = "SELECT sach.*, danh_muc_sach.name 
              AS danh_muc_sach_name FROM sach
              INNER JOIN danh_muc_sach ON sach.danhMucId = danh_muc_sach.id
              WHERE TRUE $str_filter";
    
        $obj_select = $this->connection->prepare($sql_select);
        $obj_select->execute();
        $sachs = $obj_select->fetchAll(PDO::FETCH_ASSOC);
        return $sachs;
      }
    
}