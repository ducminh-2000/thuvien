<h1>Tìm kiếm</h1>
<form action="" method="get">
    <input type="hidden" name="controller" value="danhmucsach"/>
    <input type="hidden" name="action" value="index"/>
    <div class="form-group">
        <label>Nhập tên danh mục</label>
        <input type="text" name="name" value="<?php echo isset($_GET['name']) ? $_GET['name'] : '' ?>"
               class="form-control"/>
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Tìm kiếm" class="btn btn-success"/>
        <a href="index.php?controller=danhmucsach" class="btn btn-secondary">Xóa filter</a>
    </div>
</form>

<h1>Danh sách danh mục</h1>
<a href="index.php?controller=danhmucsach&action=create" class="btn btn-primary">
    <i class="fa fa-plus"></i> Thêm mới
</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Account</th>
        <th>Created_at</th>
        <th>Updated_at</th>
        <th></th>
    </tr>
  <?php if (!empty($categories)): ?>
    <?php foreach ($categories as $category): ?>
          <tr>
              <td>
                <?php echo $category['id']; ?>
              </td>
              <td>
                <?php echo $category['name']; ?>
              </td>
              <td>
                <?php echo $category['account_name']; ?>
              </td>
              <td>
                <?php echo date('d-m-Y H:i:s', strtotime($category['createdAt'])); ?>
              </td>
              <td>
                <?php
                if (!empty($category['updatedAt'])) {
                  echo date('d-m-Y H:i:s', strtotime($category['updatedAt']));
                }
                ?>
              </td>
              <td>
                  <a href="index.php?controller=danhmucsach&action=detail&id=<?php echo $category['id'] ?>"
                     title="Chi tiết">
                      <i class="fa fa-eye"></i>
                  </a>
                  <a href="index.php?controller=danhmucsach&action=update&id=<?php echo $category['id'] ?>" title="Sửa">
                      <i class="fa fa-pencil-alt"></i>
                  </a>
                  <a href="index.php?controller=danhmucsach&action=delete&id=<?php echo $category['id'] ?>" title="Xóa"
                     onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này')">
                      <i class="fa fa-trash"></i>
                  </a>
              </td>
          </tr>
    <?php endforeach ?>
      <tr>
          <td colspan="7"><?php echo $pages; ?></td>
      </tr>

  <?php else: ?>
      <tr>
          <td colspan="7">Không có bản ghi nào</td>
      </tr>
  <?php endif; ?>
</table>
<!--  hiển thị phân trang-->

