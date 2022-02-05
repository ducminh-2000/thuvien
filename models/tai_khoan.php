<?php
require 'Model.php';
class TaiKhoan extends Model{
    public $id;
    public $username;
    public $pass;
    public $name;
    public $roleId;
    public $createdAt;
    public $updatedAt;

    public $str_search;

    function __construct(){
        parent::__construct();
        if (isset($_GET['username']) && !empty($_GET['username'])) {
            $username = addslashes($_GET['username']);
            $this->str_search .= " AND tai_khoan.username LIKE '%$username%'";
        }
    }

    public function getAll() {
        $obj_select = $this->connection
            ->prepare("SELECT * FROM tai_khoan ORDER BY updatedAt DESC, created_at DESC");
        $obj_select->execute();
        $accounts = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $accounts;
    }

    public function getAllPagination($params = []) {
        $limit = $params['limit'];
        $page = $params['page'];
        $start = ($page - 1) * $limit;
        $obj_select = $this->connection
            ->prepare("SELECT * FROM tai_khoan WHERE TRUE $this->str_search
              ORDER BY createdAt DESC
              LIMIT $start, $limit");

        $obj_select->execute();
        $accounts = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $accounts;
    }

    public function getTotal() {
        $obj_select = $this->connection
            ->prepare("SELECT COUNT(id) FROM tai_khoan WHERE TRUE $this->str_search");
        $obj_select->execute();
        return $obj_select->fetchColumn();
    }

    public function getById($id) {
        $obj_select = $this->connection
            ->prepare("SELECT tai_khoan.*, role.name AS role_name FROM tai_khoan 
            INNER JOIN role ON tai_khoan.roleId = role.id WHERE tai_khoan.id = $id");
        $obj_select->execute();
        return $obj_select->fetch(PDO::FETCH_ASSOC);
    }

    public function insert() {
        $obj_insert = $this->connection
            ->prepare("INSERT INTO tai_khoan(username, pass, name, roleId)
VALUES(:username, :pass, :name, :roleId)");
        $arr_insert = [
            ':username' => $this->username,
            ':pass' => $this->pass,
            ':name' => $this->name,
            ':roleId' => $this->roleId
        ];
        return $obj_insert->execute($arr_insert);
    }

    public function update($id) {
        $obj_update = $this->connection
            ->prepare("UPDATE tai_khoan SET name=:name,pass=:pass, roleId=:roleId, updatedAt=:updatedAt
             WHERE id = $id");
        $arr_update = [
            ':name' => $this->name,
            ':pass' => $this->pass,
            ':roleId' => $this->roleId,
            ':updatedAt' => $this->updatedAt,
        ];
        $obj_update->execute($arr_update);

        return $obj_update->execute($arr_update);
    }
    public function delete($id)
    {
        $obj_delete = $this->connection
            ->prepare("DELETE FROM tai_khoan WHERE id = $id");
        return $obj_delete->execute();
    }

    public function getAccountByUsername($username) {
        $obj_select = $this->connection
            ->prepare("SELECT COUNT(id) FROM tai_khoan WHERE username='$username'");
        $obj_select->execute();
        return $obj_select->fetchColumn();
    }

    public function getAccountByUsernameAndPassword($username, $password) {
        $obj_select = $this->connection
            ->prepare("SELECT * FROM tai_khoan WHERE username=:username AND pass=:pass LIMIT 1");
        $arr_select = [
            ':username' => $username,
            ':pass' => $password,
        ];
        $obj_select->execute($arr_select);

        $account = $obj_select->fetch(PDO::FETCH_ASSOC);

        return $account;
    }

    public function insertRegister() {
        $obj_insert = $this->connection
            ->prepare("INSERT INTO tai_khoan(username, pass, roleId)
VALUES(:username, :pass, :roleId)");
        $arr_insert = [
            ':username' => $this->username,
            ':pass' => $this->pass,
            ':roleId' => $this->roleId,
        ];
        return $obj_insert->execute($arr_insert);
    }

}
?>