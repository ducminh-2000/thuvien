<div class="container" style="padding: 110px 0px;">
    <h2>Chi tiết user</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?php echo $user['id'] ?></td>
        </tr>
        <tr>
            <th>username</th>
            <td><?php echo $user['username'] ?></td>
        </tr>
        <tr>
            <th>name</th>
            <td><?php echo $user['name'] ?></td>
        </tr>
        <tr>
            <th>role</th>
            <td><?php echo $user['role_name'] ?></td>
        </tr>
        <tr>
            <th>created_at</th>
            <td><?php echo date('d-m-Y H:i:s', strtotime($user['createdAt'])) ?></td>
        </tr>
        <tr>
            <th>updated_at</th>
            <td><?php echo date('d-m-Y H:i:s', strtotime($user['updatedAt'])) ?></td>
        </tr>
    </table>
    <a href="index.php?controller=home&action=index" class="btn btn-default">Back</a>
    <a href="index.php?controller=user&action=logout" class="btn btn-default">Đăng xuất</a>
    <a href="index.php?controller=user&action=update&id=<?php echo $user['id']?>" class="btn btn-default">Sửa</a>
</div>