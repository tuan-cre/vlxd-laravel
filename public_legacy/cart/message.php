<?php include("inc/top.php"); ?>

<br><br>
<div class="container">  
  <div class="row"> 
    <h4 class="text-info">Cảm ơn quý khách!</h4>   
	<p>Đơn hàng mã số <?php echo $donhang_id; ?> trị giá <strong><?php echo number_format($tongtien) ?>đ</strong> sẽ được giao đến quý khách trong thời gian sớm nhất.<p>
	<p><a href="index.php?action=donhang">Danh sách đơn hàng</a></p>
  <?php if(isset($_SESSION['order_mail_error'])): ?>
    <div class="alert alert-warning mt-3">
      <i class="bi bi-envelope-exclamation"></i> <?php echo $_SESSION['order_mail_error']; unset($_SESSION['order_mail_error']); ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info mt-3">Một bản xác nhận đã được gửi tới email của bạn (nếu cung cấp).</div>
  <?php endif; ?>
  </div>  
</div>

<?php include("inc/bottom.php"); ?>