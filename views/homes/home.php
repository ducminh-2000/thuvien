<!-- Start slides -->
<div id="slides" class="cover-slides">
    <ul class="slides-container">
    <?php if (!empty($sachs)):
    $count = 0;
    ?>
        <?php foreach ($sachs as $sach) : ?>
            <?php if($count <= 3) :?>
                <li class="text-center">
                    <?php if (!empty($sach['avatar'])): ?>
                        <?php $count++;?>
                        <img  src="assets/uploads/<?php echo $sach['avatar'] ?>" alt=""/>
                    <?php endif; ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="m-b-20"><strong>Chào mừng tới với <br> Thư viện số </strong></h1>
                                <p class="m-b-40">
                                Hàng ngàn tài liệu, luận văn, bài giảng, giáo trình thuộc danh mục hay và cập nhật - Tại thư viện số .
 <br>
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endif;?>
        <?php endforeach; ?>
    <?php endif; ?>
    </ul>
    <div class="slides-navigation">
        <a href="#" class="next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
        <a href="#" class="prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
    </div>
</div>
<!-- End slides -->

<!-- Start Menu -->
<div class="menu-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-title text-center">
                    <h2>Một số sách tiêu biểu</h2>
                    <p></p>
                </div>
            </div>
        </div>

        <div class="row special-list">
            <?php if (!empty($sachs)): $count = 0?>
                <?php foreach ($sachs as $sach): ?>
                    <?php if($count < 6):?>
                        <?php $count++?>
                        <div class="col-lg-4 col-md-6 special-grid <?php echo$sach['danh_muc_sach_name'];?>">
                            <div class="gallery-single fix">
                                <?php if (!empty($sach['avatar'])): ?>
                                    <img  class="img-fluid" height="100" src="assets/uploads/<?php echo $sach['avatar'] ?>" alt="Image"/>
                                <?php endif; ?>
                                <div class="why-text">

                                    <p><?php echo "Tên sách: " .$sach['name']?></p>
                                    <h5><?php echo "Thể loại: " .$sach['danh_muc_sach_name']?></h5>
                                    <h5><?php echo "Số lượng: " .$sach['quantity']. "cuốn"?></h5>
                                    <h5><?php echo "Năm xuất bản: " .$sach['xuatBan']?></h5>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="special-menu text-center">
                    <div class="button-group filter-button-group">
                        <button class="active" data-filter="*"><a href="index.php?controller=sach&action=index">Xem thêm</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Menu -->
