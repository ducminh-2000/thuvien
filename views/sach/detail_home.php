<div class="container" style="padding-top:110px !important">
    <div class="row">
        <div class="detail-content-wrap con-md-8 col-sm-8 col-xs-12">
            <div class="sach-info-wrap">
                <div class="sach-image-info">
                    <img src="assets/uploads/<?php echo $sach['avatar'] ?>" width="260"
                         title="<?php echo $sach['name']; ?>">
                </div>
                <div class="sach-info">
                    <h3 class="sach-title">
                      <?php echo "Tên sách: " .$sach['name']; ?>
                    </h3>
                    <div class="sach-price">
                      <?php echo "Số lượng: " .$sach['quantity'] ." cuốn"; ?>
                    </div>
                    <div class="sach-author">
                      <?php echo "Tác giả: " .$sach['author']; ?>
                    </div>
                    <div class="sach-xuatban">
                      <?php echo "Năm xuất bản: " .$sach['xuatBan']; ?>
                    </div>
                    <!-- <div class="sach-cart">
                        <span data-id="<?php //echo $sach['id']; ?>" class="add-to-cart">
                            <i class="fa fa-cart-plus"></i> Thêm vào giỏ
                        </span>
                    </div> -->
                </div>
            </div>

            <!--Timeline items end -->
            <div class="detail-content-wrap">
                <div class="detail-summary">
                    <strong><?php echo "Mô tả: " .$sach['description']; ?></strong>
                </div>
            </div>
            <a href="index.php?controller=sach&action=index" class="btn btn-default">Back</a>
        </div>
    </div>
</div>