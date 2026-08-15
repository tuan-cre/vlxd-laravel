<?php include("inc/top.php"); ?>

<div class="container">    
  <div class="row"> 
    <h3>Vui lòng nhập đầy đủ thông tin</h3>
	<div class="col-sm-6">
	<h4 class="text-info">Thông tin khách hàng</h4>
	<?php 
	if(isLoggedIn()){
		// Lấy danh sách địa chỉ
		require_once("../model/customer.php");
		$cust = new CUSTOMER();
		$addresses = $cust->layDanhSachDiaChi(getCustomerId());
	$user = getCurrentUser();
	$customer = getCustomerInfo();
	?>
	<form method="post" action="index.php">
		<input type="hidden" name="action" value="luudonhang">
		<!-- Hidden fields để gửi dữ liệu vì disabled fields không submit -->
		<input type="hidden" name="txtemail" value="<?php echo $user["email"]; ?>">
	<input type="hidden" name="txthoten" value="<?php echo $user["fullname"] ?? ($customer['fullname'] ?? ''); ?>">
	<input type="hidden" name="txtsodienthoai" value="<?php echo $customer['phone_number'] ?? ''; ?>">
		
		<div class="my-3">
			<label>Email</label>
			<input type="email" class="form-control" value="<?php echo $user["email"]; ?>" disabled>
		</div>
		<div class="my-3">
			<label>Họ tên</label>
			<input type="text" class="form-control" value="<?php echo $user["fullname"] ?? ($customer['fullname'] ?? ''); ?>" disabled>
		</div>
		<div class="my-3">
			<label>Số điện thoại</label>
			<input type="text" class="form-control" value="<?php echo $customer['phone_number'] ?? ''; ?>" disabled>
		</div>
		
		<?php if(!empty($addresses)): ?>
		<div class="my-3">
			<label class="form-label">
				<i class="bi bi-geo-alt-fill text-primary me-2"></i>Chọn địa chỉ giao hàng
				<a href="index.php?action=diachi" class="btn btn-sm btn-outline-primary float-end">
					<i class="bi bi-plus-circle"></i> Quản lý địa chỉ
				</a>
			</label>
			<select class="form-select" id="address-select" onchange="fillAddress()">
				<option value="">-- Chọn địa chỉ có sẵn hoặc nhập mới --</option>
				<?php foreach($addresses as $addr): ?>
					<option value='<?php echo json_encode($addr, JSON_HEX_APOS | JSON_HEX_QUOT); ?>' 
							<?php echo $addr['is_default'] == 1 ? 'selected' : ''; ?>>
						<?php echo $addr['receiver_name']; ?> - <?php echo $addr['phone_number']; ?>
						<?php if($addr['is_default'] == 1) echo ' (Mặc định)'; ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<?php endif; ?>
		
		<div class="my-3">
			<label>Địa chỉ giao hàng chi tiết</label>
			<textarea class="form-control" name="txtdiachi" id="address-detail" rows="3" required placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố"></textarea>
			<small class="text-muted">Bạn có thể chọn địa chỉ có sẵn ở trên hoặc nhập địa chỉ mới</small>
		</div>
		
		<script>
		function fillAddress() {
			const select = document.getElementById('address-select');
			const textarea = document.getElementById('address-detail');
			
			if(select.value) {
				const addr = JSON.parse(select.value);
				const fullAddress = `${addr.receiver_name} - ${addr.phone_number}\n${addr.address_detail}, ${addr.ward}, ${addr.district}, ${addr.province}`;
				textarea.value = fullAddress;
			} else {
				textarea.value = '';
			}
		}
		
		// Auto-fill địa chỉ mặc định khi load trang
		window.addEventListener('DOMContentLoaded', function() {
			const select = document.getElementById('address-select');
			if(select && select.value) {
				fillAddress();
			}
		});
		</script>
		<div class="my-3">
			<label>Ghi chú đơn hàng (tùy chọn)</label>
			<textarea class="form-control" name="txtnote" rows="2" placeholder="Ví dụ: Giao giờ hành chính..."></textarea>
		</div>
		<div class="my-3">
			<input type="submit" value="Hoàn tất đơn hàng" class="btn btn-primary">
		</div>
	</form>
	<?php
	}
	else{	
	?>
	<form method="post"  action="index.php">
		<input type="hidden" name="action" value="luudonhang">
		<div class="my-3">
			<label>Email</label>
			<input type="email" class="form-control" name="txtemail" required>
		</div>
		<div class="my-3">
			<label>Họ tên</label>
			<input type="text" class="form-control" name="txthoten" required>
		</div>
		<div class="my-3">
			<label>Số điện thoại</label>
			<input type="number" class="form-control" name="txtsodienthoai" required>
		</div>
		<div class="my-3">
			<label>Địa chỉ giao hàng</label>
			<textarea class="form-control" name="txtdiachi" rows="2" required></textarea>
		</div>
		<div class="my-3">
			<label>Ghi chú đơn hàng (tùy chọn)</label>
			<textarea class="form-control" name="txtnote" rows="2" placeholder="Ví dụ: Giao giờ hành chính..."></textarea>
		</div>
		<div class="my-3">
			<input type="submit" value="Hoàn tất đơn hàng" class="btn btn-primary">
		</div>
	</form>
	<?php	
	}
	?>
	</div>
	<div class="col-sm-6">
	<h4 class="text-info">Thông tin đơn hàng</h4>
		<?php if(isset($_SESSION['coupon_message'])): ?>
		<div class="alert alert-info"><?php echo $_SESSION['coupon_message']; unset($_SESSION['coupon_message']); ?></div>
		<?php endif; ?>
		<div class="mb-3">
			<form method="post" action="index.php" class="d-flex">
				<input type="hidden" name="return_to" value="checkout">
				<input type="hidden" name="action" value="apdungcoupon">
				<input name="coupon_code" class="form-control me-2" placeholder="Nhập mã giảm giá (coupon)">
				<button class="btn btn-outline-success" type="submit">Áp dụng</button>
			</form>
		</div>
		<?php if(isset($_SESSION['applied_coupon'])): ?>
		<div class="alert alert-success mb-2">
			<strong>Áp dụng mã:</strong> <?php echo htmlspecialchars($_SESSION['applied_coupon']['code']); ?> — Tiết kiệm <?php echo number_format($_SESSION['applied_coupon']['discount']); ?>đ
			<a href="index.php?action=xoacoupon&return_to=checkout" class="btn btn-sm btn-outline-danger ms-3">Xóa mã</a>
		</div>
		<?php endif; ?>
		<table class="table table-bordered">
		<tr class="table-info">
		<th>Sản phẩm</th> 
		<th>Đơn giá</th>
		<th>Số lượng</th>
		<th>Thành tiền</th>
		</tr>
		<?php foreach($giohang as $id => $mh): ?>
		<tr>
		<td><img width="50" src="../images/products/<?php echo $mh["thumbnail"]; ?>"><?php echo $mh["name"]; ?></td>
		<td><?php echo number_format($mh["price"]) . "đ"; ?></td>
		<td><?php echo $mh["soluong"]; ?></td>
		<td><?php echo number_format($mh["thanhtien"]) . "đ"; ?></td>
		</tr>
		<?php endforeach; ?>
		<tr class="table-info">
		<td colspan="3" class="text-end"><b>Tổng tiền</b></td>
		<td><b><?php echo number_format(tinhtiengiohang()); ?>đ</b></td>
		</tr>
		<?php if(isset($_SESSION['applied_coupon'])): ?>
		<tr class="table-info">
		<td colspan="3" class="text-end"><b>Giảm giá (<?php echo htmlspecialchars($_SESSION['applied_coupon']['code']); ?>)</b></td>
		<td class="text-danger"><b>-<?php echo number_format($_SESSION['applied_coupon']['discount']); ?>đ</b></td>
		</tr>
		<tr class="table-info">
		<td colspan="3" class="text-end"><b>Tổng sau giảm</b></td>
		<td><b><?php echo number_format(max(0, tinhtiengiohang() - $_SESSION['applied_coupon']['discount'])); ?>đ</b></td>
		</tr>
		<?php endif; ?>
		</table>
	</div>
    


  </div>
 
</div>

<?php include("inc/bottom.php"); ?>