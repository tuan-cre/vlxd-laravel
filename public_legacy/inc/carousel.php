<!-- Modern Carousel -->
<div id="modernCarousel" class="carousel slide rounded-3 overflow-hidden shadow-sm" data-bs-ride="carousel">
    <!-- Indicators/dots -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#modernCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#modernCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#modernCarousel" data-bs-slide-to="2"></button>
    </div>

    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="../images/carousel/h1.jpg" alt="Vật liệu xây dựng chất lượng" class="d-block w-100" style="height: 450px; object-fit: cover; filter: brightness(0.75);">
            <div class="carousel-caption d-block" style="top: 50%; transform: translateY(-50%); text-shadow: 2px 2px 8px rgba(0,0,0,0.8);">
                <h2 class="display-5 fw-bold mb-2">Vật Liệu Xây Dựng Chất Lượng</h2>
                <p class="fs-6 mb-3">Xi măng - Sắt thép - Gạch ốp lát</p>
                <a href="#products" class="btn btn-light btn-lg px-4 rounded-pill">
                    <i class="bi bi-arrow-down-circle me-2"></i>Khám phá ngay
                </a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="../images/carousel/h2.jpg" alt="Giá tốt - Uy tín" class="d-block w-100" style="height: 450px; object-fit: cover; filter: brightness(0.75);">
            <div class="carousel-caption d-block" style="top: 50%; transform: translateY(-50%); text-shadow: 2px 2px 8px rgba(0,0,0,0.8);">
                <h2 class="display-5 fw-bold mb-2">Giá Tốt Nhất Thị Trường</h2>
                <p class="fs-6 mb-3">Cam kết giá rẻ - Chất lượng đảm bảo</p>
                <a href="#products" class="btn btn-warning btn-lg px-4 rounded-pill">
                    <i class="bi bi-telephone me-2"></i>Liên hệ: 1900-xxxx
                </a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="../images/carousel/h3.jpg" alt="Giao hàng toàn quốc" class="d-block w-100" style="height: 450px; object-fit: cover; filter: brightness(0.75);">
            <div class="carousel-caption d-block" style="top: 50%; transform: translateY(-50%); text-shadow: 2px 2px 8px rgba(0,0,0,0.8);">
                <h2 class="display-5 fw-bold mb-2">Giao Hàng Toàn Quốc</h2>
                <p class="fs-6 mb-3">Miễn phí vận chuyển đơn hàng từ 5 triệu</p>
                <a href="#products" class="btn btn-success btn-lg px-4 rounded-pill">
                    <i class="bi bi-truck me-2"></i>Xem chi tiết
                </a>
            </div>
        </div>
    </div>

    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#modernCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" style="filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.8));"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#modernCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" style="filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.8));"></span>
    </button>
</div>
        
        <style>
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .carousel-caption h2, .carousel-caption p, .carousel-caption .btn {
                animation: fadeInUp 0.8s ease-out;
            }
            
            .carousel-caption p {
                animation-delay: 0.2s;
            }
            
            .carousel-caption .btn {
                animation-delay: 0.4s;
            }
            
            .carousel-control-prev-icon,
            .carousel-control-next-icon {
                width: 3rem;
                height: 3rem;
                background-size: 100%;
            }
            
            #modernCarousel .carousel-item {
                transition: transform 0.8s ease-in-out;
            }
        </style>