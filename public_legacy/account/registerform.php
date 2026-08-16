<?php
if (isLoggedIn()) {
    header("location:index.php");
    exit();
}

$errors = isset($_SESSION['register_errors']) ? $_SESSION['register_errors'] : [];
$oldData = isset($_SESSION['register_data']) ? $_SESSION['register_data'] : [];
unset($_SESSION['register_errors']);
unset($_SESSION['register_data']);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - VLXD Di Hiền</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/theme.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: url('/images/auth/login-regis.jpg') no-repeat center/cover;

            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
            margin: 0;
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        /* Reuse login form styles for register form by targeting both selectors */
        .login-card,
        .register-card {
            max-width: 450px;
            width: 100%;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .login-header,
        .register-header {
            padding: 0.5rem 0.5rem;
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-header h3,
        .register-header h3 {
            margin: 0 0 0.5rem 0;
            font-weight: 700;
            color: #000;
        }

        .login-header p,
        .register-header p {
            color: rgba(0, 0, 0, 1);
        }

        .login-body,
        .register-body {
            padding: 2rem;
            color: #000;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating>.form-control {
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.25);
            color: #000;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 0.75rem;
        }

        .form-floating>.form-control:focus {
            background: rgba(255, 255, 255, 0.35);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.15);
        }

        .form-floating>label {
            color: rgba(0, 0, 0, 1);
        }

        .btn-login,
        .btn-register {
            background: rgba(255, 255, 255, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 14px;
            font-weight: 600;
            border-radius: 10px;
            color: #000;
            width: 100%;
            transition: all 0.3s;
            margin-top: 0.5rem;
        }

        .btn-login:hover,
        .btn-register:hover {
            color: #000;
            font-weight: bolder;
            background: rgba(255, 255, 255, 0.45);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: rgba(0, 0, 0, 1);
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(0, 0, 0, 0.25);
        }

        .divider span {
            padding: 0 1rem;
            background: transparent;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .alert {
            border-radius: 10px;
            opacity: 0.85;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="register-card">
            <div class="register-header">
                <i class="bi bi-person-plus-fill" style="font-size: 3rem;"></i>
                <h3>Đăng ký tài khoản</h3>
                <p class="mb-0">Tạo tài khoản để trải nghiệm đầy đủ</p>
            </div>

            <div class="register-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i> <strong>Có lỗi xảy ra:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?action=xldangky">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="txthoten" name="txthoten" placeholder="Họ và tên"
                            value="<?php echo isset($oldData['txthoten']) ? htmlspecialchars($oldData['txthoten']) : ''; ?>">
                        <label for="txthoten"><i class="bi bi-person"></i> Họ và tên <small class="text-muted">(không bắt buộc)</small></label>
                    </div>

                    <div class="form-floating">
                        <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Email"
                            required
                            value="<?php echo isset($oldData['txtemail']) ? htmlspecialchars($oldData['txtemail']) : ''; ?>">
                        <label for="txtemail"><i class="bi bi-envelope"></i> Email</label>
                    </div>

                    <div class="form-floating">
                        <input type="tel" class="form-control" id="txtsodienthoai" name="txtsodienthoai"
                            placeholder="Số điện thoại" pattern="[0-9]{10,11}"
                            value="<?php echo isset($oldData['txtsodienthoai']) ? htmlspecialchars($oldData['txtsodienthoai']) : ''; ?>">
                        <label for="txtsodienthoai"><i class="bi bi-telephone"></i> Số điện thoại <small class="text-muted">(không bắt buộc)</small></label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control" id="txtdiachi" name="txtdiachi" placeholder="Địa chỉ"
                            style="height: 80px"><?php echo isset($oldData['txtdiachi']) ? htmlspecialchars($oldData['txtdiachi']) : ''; ?></textarea>
                        <label for="txtdiachi"><i class="bi bi-geo-alt"></i> Địa chỉ (không bắt buộc)</label>
                    </div>

                    <div class="form-floating">
                        <input type="password" class="form-control" id="txtmatkhau" name="txtmatkhau"
                            placeholder="Mật khẩu" required minlength="6">
                        <label for="txtmatkhau"><i class="bi bi-lock"></i> Mật khẩu (tối thiểu 6 ký tự)</label>
                    </div>

                    <div class="form-floating">
                        <input type="password" class="form-control" id="txtmatkhau2" name="txtmatkhau2"
                            placeholder="Xác nhận mật khẩu" required minlength="6">
                        <label for="txtmatkhau2"><i class="bi bi-lock-fill"></i> Xác nhận mật khẩu</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-register w-100 mb-3">
                        <i class="bi bi-check-circle"></i> Đăng ký ngay
                    </button>

                    <div class="divider">
                        <span>HOẶC</span>
                    </div>

                    <div class="text-center">
                        <p class="mb-2">Đã có tài khoản?
                            <a href="index.php?action=dangnhap" class="text-decoration-none fw-bold">Đăng nhập ngay</a>
                        </p>
                        <a href="index.php" class="text-muted text-decoration-none">
                            <i class="bi bi-arrow-left"></i> Quay về trang chủ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>