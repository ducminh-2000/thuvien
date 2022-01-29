<?php
require 'Model.php';
class TaiKhoan extends Model{
    public $id;
    public $accountId;
    public $sachId;
    public $quantity;
    public $kind;
    public $expire;
    public $createdAt;
    public $updatedAt;

    public $str_search;

    public function __construct()
    {
        parent::__construct();
        // if (isset($_GET['title']) && !empty($_GET['title'])) {
        //     $this->str_search .= " AND role.name LIKE '%{$_GET['title']}%'";
        // }
    }

    public function getAll() {
        $obj_select = $this->connection
            ->prepare("SELECT * FROM sach_duoc_muon ORDER BY updatedAt DESC, createdAt DESC");
        $obj_select->execute();
        $accounts = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $accounts;
    }

    public function getAllPagination($params = []) {
        $limit = $params['limit'];
        $page = $params['page'];
        $start = ($page - 1) * $limit;
        $obj_select = $this->connection
            ->prepare("SELECT * FROM sach_duoc_muon WHERE TRUE $this->str_search
              ORDER BY createdAt DESC
              LIMIT $start, $limit");

        $obj_select->execute();
        $accounts = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $accounts;
    }

    public function getTotal() {
        $obj_select = $this->connection
            ->prepare("SELECT COUNT(id) FROM sach_duoc_muon WHERE TRUE $this->str_search");
        $obj_select->execute();
        return $obj_select->fetchColumn();
    }

    public function getById($id) {
        $obj_select = $this->connection
            ->prepare("SELECT * FROM sach_duoc_muon WHERE id = $id");
        $obj_select->execute();
        return $obj_select->fetch(PDO::FETCH_ASSOC);
    }

    public function insert() {
        $obj_insert = $this->connection
            ->prepare("INSERT INTO sach_duoc_muon(accountId,sachId,quantity,expire,kind) VALUES(:accountId, :sachId, :quantity, :expire, :kind)");
        $arr_insert = [
            ':accountId' => $this->accountId,
            ':sachId' => $this->sachId,
            ':quantity' => $this->quantity,
            ':expire' => $this->expire,
            ':kind' => $this->kind,
        ];
        return $obj_update->execute($arr_insert);
    }

    public function update($id) {
        $obj_update = $this->connection
            ->prepare("UPDATE sach_duoc_muon SET accountId=:accountId,sachId=:sachId, quantity=:quantity, expire=:expire, kind=:kind, updatedAt=:updatedAt WHERE id = $id");
        $arr_update = [
            ':accountId' => $this->accountId,
            ':sachId' => $this->sachId,
            ':quantity' => $this->quantity,
            ':expire' => $this->expire,
            ':kind' => $this->kind,
            ':updatedAt' => $this->updatedAt,
        ];
        $obj_update->execute($arr_update);

        return $obj_update->execute($arr_update);
    }
    public function delete($id)
    {
        $obj_delete = $this->connection
            ->prepare("DELETE FROM sach_duoc_muon WHERE id = $id");
        return $obj_delete->execute();
    }
}
?>