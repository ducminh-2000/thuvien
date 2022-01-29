<div class="container" style="padding-top:110px !important">
    
    <div class="row">
        <div class="text-center" style="width:100%">
            <!-- <h1><p>Lọc</p></h1> -->
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
                    <!-- <div class="form-group" style="display:flex">
                            <b>Năm xuất bản:</b> <br/>
                            <?php
                            //cần đổ lại dữ liệu ra form search
                            // $xuatBan1_checked = '';
                            // $xuatBan2_checked = '';
                            // $xuatBan3_checked = '';
                            // $xuatBan4_checked = '';
                            // if (isset($_GET['xuatBan'])) {
                            //     foreach ($_GET['xuatBan'] as $xuatBan) {
                            //     if ($xuatBan == 1) {
                            //         $xuatBan1_checked = 'checked';
                            //     }
                            //     if ($xuatBan == 2) {
                            //         $xuatBan2_checked = 'checked';
                            //     }
                            //     if ($xuatBan == 3) {
                            //         $xuatBan3_checked = 'checked';
                            //     }
                            //     if ($xuatBan == 4) {
                            //         $xuatBan4_checked = 'checked';
                            //     }
                            //     }
                            // }
                            ?>
                            <span class="filterItem"><input type="checkbox" name="xuatBan[]" value="1" <?php echo $xuatBan1_checked; ?> /> Trước năm 2000 <br/></span>
                            <span class="filterItem"><input type="checkbox" name="xuatBan[]" value="2" <?php echo $xuatBan2_checked; ?> /> Từ 2000 - 2010
                            <br/></span>
                            <span class="filterItem"><input type="checkbox" name="xuatBan[]" value="3" <?php echo $xuatBan3_checked; ?> /> Từ 2010 - 2020
                            <br/></span>
                            <span class="filterItem"><input type="checkbox" name="xuatBan[]" value="4" <?php echo $xuatBan4_checked; ?> /> Sau 2020
                            <br/></span>
                        </div> -->
                </div>
                <input type="hidden" name="controller" value="sach"/>
                <input type="hidden" name="action" value="index"/>
                <input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary"/>
                <a href="index.php?controller=sach" class="btn btn-default">Xóa filter</a>
            </form>
            <!-- <form action="" method="POST">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group" >
                            <label for="name">Nhập tên sách:</label>
                            <input type="text" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>"
                                class="form-control" id="name"/>
                        </div>
                        <?php if (!empty($danhmucsachs)): ?>
                            <div class="form-group" style="display:flex">
                                <b>Danh mục</b> <br/>
                                <?php foreach ($danhmucsachs AS $danhmucsach):
                                //đổ lại dữ liệu đã check category
                                $danhmucsach_checked = '';
                                if (isset($_POST['danhMuc'])) {
                                    if (in_array($danhmucsach['id'], $_POST['danhMuc'])) {
                                    $danhmucsach_checked = 'checked';
                                    }
                                }
                                ?>
                                    <span class="filterItem"><input type="checkbox" name="danhMuc[]"
                                        value="<?php echo $danhmucsach['id']; ?>" <?php echo $danhmucsach_checked; ?> /></span>
                                <?php echo $danhmucsach['name']; ?>
                                    <br/>
                                <?php endforeach; ?>

                            </div>
                        <?php endif; ?>

                        <div class="form-group" style="display:flex">
                            <b>Năm xuất bản:</b> <br/>
                            <?php
                            //cần đổ lại dữ liệu ra form search
                            $xuatBan1_checked = '';
                            $xuatBan2_checked = '';
                            $xuatBan3_checked = '';
                            $xuatBan4_checked = '';
                            if (isset($_POST['xuatBan'])) {
                                foreach ($_POST['xuatBan'] as $xuatBan) {
                                if ($xuatBan == 1) {
                                    $xuatBan1_checked = 'checked';
                                }
                                if ($xuatBan == 2) {
                                    $xuatBan2_checked = 'checked';
                                }
                                if ($xuatBan == 3) {
                                    $xuatBan3_checked = 'checked';
                                }
                                if ($xuatBan == 4) {
                                    $xuatBan4_checked = 'checked';
                                }
                                }
                            }
                            ?>
                            <span class="filterItem"><input type="checkbox" name="xuatBan[]" value="1" <?php echo $xuatBan1_checked; ?> /> Trước năm 2000 <br/></span>
                            <span class="filterItem"><input type="checkbox" name="xuatBan[]" value="2" <?php echo $xuatBan2_checked; ?> /> Từ 2000 - 2010
                            <br/></span>
                            <span class="filterItem"><input type="checkbox" name="xuatBan[]" value="3" <?php echo $xuatBan3_checked; ?> /> Từ 2010 - 2020
                            <br/></span>
                            <span class="filterItem"><input type="checkbox" name="xuatBan[]" value="4" <?php echo $xuatBan4_checked; ?> /> Sau 2020
                            <br/></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="button-group" style="margin:45px">
                                <button type="submit" name="filter" class="btn btn-primary active" style="padding:10px;margin-bottom:10px;width:90px">Tìm kiếm</button>
                                <button type="reset" class="btn btn-default" style="padding:10px;width:90px">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    .form-group span.filterItem{
                        padding-left: 20px
                    }
                </style>
            </form> -->
        </div>
    </div>
    <div class="row" style="margin:50px 0px">
        <div class="special-menu text-center">
            <h2 style="margin:50px 0px">Danh sách sản phẩm</h2>
          <?php if (!empty($sachs)): ?>
              <div class="link-secondary-wrap row">
                <?php foreach ($sachs AS $sach):
                  $sach_link = "index.php?controller=sach&action=detailByGuest&id=" .$sach['id'];
                  ?>
                    <div class="service-link col-md-3 col-sm-6 col-xs-12">
                        <a href="<?php echo $sach_link; ?>">
                            <img heigh="80" class="img-fluid img-responsive" title="<?php echo $sach['name'] ?>"
                                 src="assets/uploads/<?php echo $sach['avatar'] ?>"
                                 alt="<?php echo $sach['name'] ?>"/>
                            <p class="shop-title">
                                <?php echo "Tên sách: " .$sach['name'] ?>
                            </p>
                        </a>
                        <p class="shop-xuatBan">
                            <?php echo "Năm xuất bản: " .number_format($sach['xuatBan']) ?>
                        </p>
                    </div>
                <?php endforeach; ?>
              </div>
              <?php else: ?>
            <tr>
                <td colspan="9">No data found</td>
            </tr>
             <?php endif; ?>
        </div>
    </div>

</div>
<?php echo $pages; ?>