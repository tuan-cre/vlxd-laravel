<?php include("inc/top.php"); ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none"><i class="bi bi-house"></i> Trang chủ</a></li>
        <li class="breadcrumb-item active">Liên hệ</li>
    </ol>
</nav>

<div class="container">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold mb-3">Liên Hệ Với Chúng Tôi</h1>
                <p class="lead text-muted">Chúng tôi luôn sẵn sàng hỗ trợ và tư vấn cho bạn</p>
            </div>

            <div class="row g-4">
                <!-- Contact Info -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4"><i class="bi bi-info-circle text-primary me-2"></i>Thông Tin Liên Hệ</h4>
                            
                            <div class="mb-4">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-geo-alt-fill text-primary fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Địa Chỉ</h6>
                                        <p class="text-muted small mb-0">123 Đường ABC, Phường XYZ<br>Quận 1, TP. Hồ Chí Minh</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="bg-success bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-telephone-fill text-success fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Điện Thoại</h6>
                                        <p class="text-muted small mb-0">
                                            Hotline: <a href="tel:0123456789" class="text-decoration-none">0123 456 789</a><br>
                                            Văn phòng: <a href="tel:0287654321" class="text-decoration-none">028 7654 321</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-envelope-fill text-info fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Email</h6>
                                        <p class="text-muted small mb-0">
                                            <a href="mailto:contact@vlxd.com" class="text-decoration-none">contact@vlxd.com</a><br>
                                            <a href="mailto:sales@vlxd.com" class="text-decoration-none">sales@vlxd.com</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="bg-warning bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-clock-fill text-warning fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Giờ Làm Việc</h6>
                                        <p class="text-muted small mb-0">
                                            Thứ 2 - Thứ 6: 8:00 - 17:30<br>
                                            Thứ 7: 8:00 - 12:00<br>
                                            Chủ nhật: Nghỉ
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="fw-bold mb-3">Theo Dõi Chúng Tôi</h6>
                            <div class="d-flex gap-2">
                                <a href="#!" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="#!" class="btn btn-outline-info btn-sm rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-twitter"></i>
                                </a>
                                <a href="#!" class="btn btn-outline-danger btn-sm rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-youtube"></i>
                                </a>
                                <a href="#!" class="btn btn-outline-success btn-sm rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-telephone"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4"><i class="bi bi-chat-dots text-primary me-2"></i>Gửi Tin Nhắn</h4>
                            
                            <?php if(isset($_GET['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                <strong>Thành công!</strong> Tin nhắn của bạn đã được gửi. Chúng tôi sẽ phản hồi sớm nhất.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php endif; ?>

                            <form action="index.php?action=guilienhe" method="POST">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Họ và Tên <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="hoten" placeholder="Nguyễn Văn A" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Số Điện Thoại <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" name="sodienthoai" placeholder="0123 456 789" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" placeholder="email@example.com" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Chủ Đề</label>
                                        <select class="form-select" name="chude">
                                            <option value="Tư vấn sản phẩm">Tư vấn sản phẩm</option>
                                            <option value="Báo giá">Báo giá</option>
                                            <option value="Khiếu nại">Khiếu nại</option>
                                            <option value="Hợp tác kinh doanh">Hợp tác kinh doanh</option>
                                            <option value="Khác">Khác</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Nội Dung <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="noidung" rows="6" placeholder="Nhập nội dung tin nhắn..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="bi bi-send me-2"></i>Gửi Tin Nhắn
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body p-0">
                            <div class="ratio ratio-21x9">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.3192795574654!2d106.69750631533487!3d10.783011192317533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4b3330bcc9%3A0xb5c7e1bfb41dd63b!2sBen%20Thanh%20Market!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s" 
                                    style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("inc/bottom.php"); ?>
