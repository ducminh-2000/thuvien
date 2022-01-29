<?php
require_once 'helpers/Helper.php';
?>
<!--form search-->
<form action="" method="GET">
    <div class="form-group">
        <label for="title">Nhập tên sách</label>
        <input type="text" name="title" value="<?php echo isset($_GET['title']) ? $_GET['title'] : '' ?>" id="title"
               class="form-control"/>
    </div>
    <div class="form-group">
        <label for="title">Chọn danh mục</label>
        <select name="category_id" class="form-control">
            <?php foreach ($danhmucsachs as $danhmucsach):
                //giữ trạng thái selected của category sau khi chọn dựa vào
//                tham số category_id trên trình duyệt
                $selected = '';
                if (isset($_GET['category_id']) && $danhmucsach['id'] == $_GET['category_id']) {
                    $selected = 'selected';
                }
                ?>
                <option value="<?php echo $danhmucsach['id'] ?>" <?php echo $selected; ?>>
                    <?php echo $danhmucsach['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <input type="hidden" name="controller" value="sach"/>
    <input type="hidden" name="action" value="index"/>
    <input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary"/>
    <a href="index.php?controller=sach" class="btn btn-default">Xóa filter</a>
</form>


<h2>Danh sách Sách</h2>
    <a href="index.php?controller=sach&action=create" class="btn btn-success">
        <i class="fa fa-plus"></i> Thêm mới
    </a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Tên danh mục</th>
        <th>Tên sách</th>
        <th>Ảnh đại diện</th>
        <th>Số lượng</th>
        <th>Năm xuất bản</th>
        <th>Tác giả</th>
        <th>Created_at</th>
        <th>Updated_at</th>
        <th></th>
    </tr>
    <?php if (!empty($sachs)): ?>
        <?php foreach ($sachs as $sach): ?>
            <tr>
                <td><?php echo $sach['id'] ?></td>
                <td><?php echo $sach['category_name'] ?></td>
                <td><?php echo $sach['name'] ?></td>
                <td>
                    <?php if (!empty($sach['avatar'])): ?>
                        <img height="80" src="assets/uploads/<?php echo $sach['avatar'] ?>"/>
                    <?php endif; ?>
                </td>
                <td><?php echo number_format($sach['quantity']) ?></td>
                <td><?php echo $sach['xuatBan'] ?></td>
                <td><?php echo $sach['author'] ?></td>
                <td><?php echo date('d-m-Y H:i:s', strtotime($sach['createdAt'])) ?></td>
                <td><?php echo !empty($sach['updated_at']) ? date('d-m-Y H:i:s', strtotime($sach['updated_at'])) : '--' ?></td>
                <td>
                    <?php
                    $url_detail = "index.php?controller=sach&action=detail&id=" . $sach['id'];
                    $url_update = "index.php?controller=sach&action=update&id=" . $sach['id'];
                    $url_delete = "index.php?controller=sach&action=delete&id=" . $sach['id'];
                    ?>
                    <a title="Chi tiết" href="<?php echo $url_detail ?>"><i class="fa fa-eye"></i></a> &nbsp;&nbsp;
                    <a title="Update" href="<?php echo $url_update ?>"><i class="fa fa-pencil-alt"></i></a> &nbsp;&nbsp;
                    <a title="Xóa" href="<?php echo $url_delete ?>" onclick="return confirm('Are you sure delete?')"><i
                                class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>

    <?php else: ?>
        <tr>
            <td colspan="9">No data found</td>
        </tr>
    <?php endif; ?>
</table>
<?php echo $pages; ?>