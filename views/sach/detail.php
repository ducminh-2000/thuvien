<?php
require_once 'helpers/Helper.php';
?>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td><?php echo $sach['id']?></td>
    </tr>
    <tr>
        <th>Tên danh mục</th>
        <td><?php echo $sach['category_name']?></td>
    </tr>
    <tr>
        <th>Tên sách</th>
        <td><?php echo $sach['name']?></td>
    </tr>
    <tr>
        <th>Avatar</th>
        <td>
            <?php if (!empty($sach['avatar'])): ?>
                <img height="80" src="assets/uploads/<?php echo $sach['avatar'] ?>"/>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th>Số lượng</th>
        <td><?php echo number_format($sach['quantity']) ?></td>
    </tr>
    <tr>
        <th>Năm xuất bản</th>
        <td><?php echo number_format($sach['xuatBan']) ?></td>
    </tr>
    <tr>
        <th>Mô tả</th>
        <td><?php echo $sach['description'] ?></td>
    </tr>
    <tr>
        <th>Created at</th>
        <td><?php echo date('d-m-Y H:i:s', strtotime($sach['createdAt'])) ?></td>
    </tr>
    <tr>
        <th>Updated at</th>
        <td><?php echo !empty($sach['updated_at']) ? date('d-m-Y H:i:s', strtotime($sach['updated_at'])) : '--' ?></td>
    </tr>
</table>
<a href="index.php?controller=sach&action=index" class="btn btn-default">Back</a>