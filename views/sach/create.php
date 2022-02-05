<h2>Thêm mới sách</h2>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="danhmucsach_id">Chọn danh mục sách</label>
        <select name="danhmucsach_id" class="form-control" id="danhmucsach_id">
            <?php foreach ($danhmucsachs as $danhmucsach):
                $selected = '';
                if (isset($_POST['danhmucsach_id']) && $danhmucsach['id'] == $_POST['danhmucsach_id']) {
                    $selected = 'selected';
                }
                ?>
                <option value="<?php echo $danhmucsach['id'] ?>" <?php echo $selected; ?>>
                    <?php echo $danhmucsach['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="name">Nhập tên sách</label>
        <input type="text" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>"
               class="form-control" id="name"/>
    </div>
    <div class="form-group">
        <label for="avatar">Ảnh đại diện</label>
        <input type="file" name="avatar" value="" class="form-control" id="avatar"/>
        <img src="#" id="img-preview" style="display: none" width="100" height="100"/>
    </div>
    <div class="form-group">
        <label for="quantity">Số lượng</label>
        <input type="number" name="quantity" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : '' ?>"
               class="form-control" id="quantity"/>
    </div>
    <div class="form-group">
        <label for="xuatBan">Năm xuất bản</label>
        <input type="number" name="xuatBan" value="<?php echo isset($_POST['xuatBan']) ? $_POST['xuatBan'] : '' ?>"
               class="form-control" id="xuatBan"/>
    </div>
    <div class="form-group">
        <label for="author">Tác giả</label>
        <input type="text" name="author" value="<?php echo isset($_POST['author']) ? $_POST['author'] : '' ?>"
               class="form-control" id="author"/>
    </div>
    <div class="form-group">
        <label for="description">Mô tả</label>
        <textarea name="description" id="description"
                  class="form-control"><?php echo isset($_POST['description']) ? $_POST['description'] : '' ?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" name="submit" value="Save" class="btn btn-primary"/>
        <a href="index.php?controller=sach&action=index" class="btn btn-default">Back</a>
    </div>
</form>