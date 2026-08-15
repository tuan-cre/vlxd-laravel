<?php
include("inc/top.php");
?>
<?php if(demhangtronggio()==0){ ?>
<div class="container my-5">
    <div class="alert alert-info text-center">
        <i class="bi bi-cart-x fs-1"></i>
        <h3 class="mt-3">Giỏ hàng trống!</h3>
        <p>Vui lòng chọn sản phẩm để thêm vào giỏ hàng.</p>
        <a href="index.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Tiếp tục mua hàng</a>
    </div>
</div>
<?php 
} 
else{ 
?>
<div class="container my-4">
<h3 class="text-primary mb-4"><i class="bi bi-cart-check"></i> Giỏ hàng của bạn</h3>
<form action="index.php">
<div class="table-responsive">
<table class="table table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Đơn vị</th>
            <th>Đơn giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
<?php foreach($giohang as $id => $sp):   ?>
    <tr>
        <td><img width="60" class="img-thumbnail" src="../images/products/<?php echo $sp["thumbnail"]; ?>" alt="<?php echo $sp["name"]; ?>"></td>
        <td>
            <strong><?php echo $sp["name"]; ?></strong>
            <?php if($sp["soluong"] > $sp["stock"]){ ?>
            <br><small class="text-danger"><i class="bi bi-exclamation-triangle"></i> Chỉ còn <?php echo $sp["stock"]; ?> sản phẩm</small>
            <?php } ?>
        </td>
        <td><?php echo $sp["unit"]; ?></td>
        <td class="text-primary fw-bold"><?php echo number_format($sp["price"]); ?>đ</td>
        <td>
            <input type="number" class="form-control" style="width: 80px;" name="mh[<?php echo $id; ?>]" 
                   value="<?php echo $sp["soluong"]; ?>" min="0" max="<?php echo $sp["stock"]; ?>">
        </td>
        <td class="text-danger fw-bold"><?php echo number_format($sp["thanhtien"]); ?>đ</td>
    </tr>
<?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr class="table-light">
            <td colspan="5" class="text-end fw-bold fs-5">Tổng tiền:</td>
            <td class="text-danger fw-bold fs-5"><?php echo number_format(tinhtiengiohang()); ?>đ</td>
        </tr>
    
    </tfoot>
</table>
</div>
<!-- Coupon section moved outside of the cart update form to avoid nested form issues -->
    <div class="alert alert-warning">
        <i class="bi bi-info-circle"></i> <strong>Lưu ý:</strong> Số lượng mua không được vượt quá số lượng tồn kho. Nhập số lượng = 0 để xóa sản phẩm khỏi giỏ hàng.
    </div>

<div class="row mt-4">
    <div class="col-md-6">
        <a href="index.php" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Tiếp tục mua hàng
        </a>
        <a href="index.php?action=xoagiohang" class="btn btn-outline-danger">
            <i class="bi bi-trash"></i> Xóa tất cả
        </a>
    </div>
    <div class="col-md-6 text-end">    
        <input type="hidden" name="action" value="capnhatgio">
        <input type="submit" class="btn btn-warning" value="Cập nhật giỏ hàng">
        <a href="index.php?action=thanhtoan" class="btn btn-success">
            <i class="bi bi-credit-card"></i> Thanh toán
        </a>
    </div>
</div>
</form>
</div>
<div class="container mt-2 mb-4">
    <div class="text-center text-muted small">
        Nếu bạn có mã giảm giá, vui lòng áp dụng ở trang <a href="index.php?action=thanhtoan">Thanh toán</a> để đảm bảo áp dụng chính xác.
    </div>
</div>
<!-- Coupon input intentionally removed from Cart page; coupons are applied on checkout only to keep cart UI clean. -->
<?php } // end if ?>
<?php
include("inc/bottom.php");
?>