<?php
if (isLoggedIn()) {
    header("location:index.php");
    exit();
}

$error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - VLXD Di Hiền</title>
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

        .login-card {
            max-width: 450px;
            width: 100%;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;

            /* MORE TRANSPARENT */
            background: rgba(255, 255, 255, 0.2);
            /* really transparent */

            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .login-header {
            padding: 0.5rem 0.5rem;
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
            /* lighter header */
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-header h3 {
            margin: 0 0 0.5rem 0;
            font-weight: 700;
            color: #000;
        }

        .login-header p {
            margin: 0;
            color: rgba(0, 0, 0, 1);
        }

        .login-body {
            padding: 2rem;
            color: #000;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating>.form-control {
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.25);
            /* lighter inputs */
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

        .btn-login {
            background: rgba(255, 255, 255, 0.25);
            /* lighter button */
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 14px;
            font-weight: 600;
            border-radius: 10px;
            color: #000;
            width: 100%;
            transition: all 0.3s;
            margin-top: 0.5rem;
        }

        .btn-login:hover {
            color: #000;
            font-weight: bolder;
            background: rgba(255, 255, 255, 0.45);
            /* hover slightly stronger */
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
        <div class="login-card">
            <div class="login-header">
                <i class="bi bi-box-arrow-in-right" style="font-size: 3rem;"></i>
                <h3>Đăng nhập</h3>
                <p class="mb-0">Chào mừng bạn quay trở lại!</p>
            </div>

            <div class="login-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?action=xldangnhap">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Email"
                            required autofocus>
                        <label for="txtemail"><i class="bi bi-envelope"></i> Email</label>
                    </div>

                    <div class="form-floating">
                        <input type="password" class="form-control" id="txtmatkhau" name="txtmatkhau"
                            placeholder="Mật khẩu" required>
                        <label for="txtmatkhau"><i class="bi bi-lock"></i> Mật khẩu</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Ghi nhớ
                            </label>
                        </div>
                        <a href="#" class="text-decoration-none small">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
                        <i class="bi bi-check-circle"></i> Đăng nhập
                    </button>

                    <div class="divider">
                        <span>HOẶC</span>
                    </div>

                    <div class="text-center">
                        <p class="mb-2">Chưa có tài khoản?
                            <a href="index.php?action=dangky" class="text-decoration-none fw-bold">Đăng ký ngay</a>
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