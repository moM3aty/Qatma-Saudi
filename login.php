<?php
require 'config.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: admin.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: admin.php');
        exit;
    } else {
        $error = 'اسم المستخدم أو كلمة المرور غير صحيحة';
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | لوحة تحكم قطمة السعودية</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #001d3d 0%, #003366 50%, #001d3d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated background blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.5;
            animation: float 8s infinite alternate ease-in-out;
        }
        .blob-1 { width: 400px; height: 400px; background: #ff6600; top: -100px; right: -100px; }
        .blob-2 { width: 350px; height: 350px; background: #004488; bottom: -80px; left: -80px; animation-delay: 2s; }
        .blob-3 { width: 250px; height: 250px; background: #ff9900; top: 40%; left: 30%; opacity: 0.3; animation-delay: 4s; }

        @keyframes float {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(40px, -40px) scale(1.15); }
        }

        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            max-width: 1000px;
            min-height: 580px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(25px);
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            position: relative;
            z-index: 10;
            margin: 20px;
        }

        /* Brand side */
        .brand-side {
            background: linear-gradient(160deg, rgba(255, 102, 0, 0.15), rgba(0, 51, 102, 0.3));
            padding: 60px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .brand-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }
        .brand-logo-box {
            width: 110px;
            height: 110px;
            background: linear-gradient(135deg, #ff6600, #ff9900);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 20px 40px rgba(255, 102, 0, 0.4);
            animation: pulse 3s infinite ease-in-out;
            position: relative;
            z-index: 2;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 20px 40px rgba(255, 102, 0, 0.4); }
            50% { transform: scale(1.05); box-shadow: 0 25px 55px rgba(255, 102, 0, 0.6); }
        }
        .brand-side h1 {
            font-size: 2.2rem;
            font-weight: 900;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }
        .brand-side h1 span { color: #ff6600; }
        .brand-side p {
            font-size: 1rem;
            opacity: 0.8;
            line-height: 1.7;
            max-width: 320px;
            position: relative;
            z-index: 2;
        }
        .brand-badges {
            display: flex;
            gap: 10px;
            margin-top: 35px;
            position: relative;
            z-index: 2;
            flex-wrap: wrap;
            justify-content: center;
        }
        .brand-badge {
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            backdrop-filter: blur(10px);
        }
        .brand-badge i { color: #ff6600; margin-left: 5px; }

        /* Form side */
        .form-side {
            padding: 60px 55px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }
        .form-side h2 {
            font-size: 1.8rem;
            font-weight: 900;
            margin-bottom: 8px;
        }
        .form-side .subtitle {
            font-size: 0.95rem;
            opacity: 0.65;
            margin-bottom: 35px;
        }

        .error-box {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid rgba(220, 53, 69, 0.4);
            color: #ff8a95;
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.4s;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }

        .input-group {
            position: relative;
            margin-bottom: 22px;
        }
        .input-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, 0.85);
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper i.field-icon {
            position: absolute;
            top: 50%;
            right: 18px;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 1rem;
            pointer-events: none;
            transition: 0.3s;
        }
        .input-wrapper input {
            width: 100%;
            padding: 15px 48px 15px 18px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            color: white;
            font-size: 1rem;
            font-family: 'Cairo', sans-serif;
            font-weight: 600;
            transition: 0.3s;
            outline: none;
        }
        .input-wrapper input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ff6600;
            box-shadow: 0 0 0 4px rgba(255, 102, 0, 0.15);
        }
        .input-wrapper input:focus ~ i.field-icon {
            color: #ff6600;
        }
        .input-wrapper input::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #ff6600, #ff9900);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 1.05rem;
            font-weight: 800;
            font-family: 'Cairo', sans-serif;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 15px 30px rgba(255, 102, 0, 0.3);
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(255, 102, 0, 0.5);
        }
        .login-btn:active { transform: translateY(-1px); }

        .back-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
        }
        .back-link a {
            color: #ff6600;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
        }
        .back-link a:hover { text-shadow: 0 0 10px rgba(255, 102, 0, 0.6); }

        @media (max-width: 850px) {
            .login-wrapper { grid-template-columns: 1fr; min-height: auto; max-width: 450px; }
            .brand-side { padding: 40px 30px; }
            .brand-side h1 { font-size: 1.6rem; }
            .brand-logo-box { width: 80px; height: 80px; font-size: 1.8rem; margin-bottom: 20px; }
            .form-side { padding: 40px 30px; }
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="login-wrapper">
        <!-- Brand Side -->
        <div class="brand-side">
            <div class="brand-logo-box">
                <i class="fas fa-cookie-bite"></i>
            </div>
            <h1>قطمة <span>السعودية</span></h1>
            <p>لوحة تحكم متكاملة لإدارة منتجاتك بكل سهولة واحترافية</p>
            <div class="brand-badges">
                <div class="brand-badge"><i class="fas fa-bolt"></i> سريع</div>
                <div class="brand-badge"><i class="fas fa-shield-alt"></i> آمن</div>
                <div class="brand-badge"><i class="fas fa-mobile-alt"></i> متجاوب</div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="form-side">
            <h2>أهلاً بعودتك 👋</h2>
            <p class="subtitle">سجّل دخولك للوصول إلى لوحة التحكم</p>

            <?php if ($error): ?>
                <div class="error-box">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-group">
                    <label>اسم المستخدم</label>
                    <div class="input-wrapper">
                        <input type="text" name="username" placeholder="أدخل اسم المستخدم" required autocomplete="username">
                        <i class="fas fa-user field-icon"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label>كلمة المرور</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" placeholder="أدخل كلمة المرور" required autocomplete="current-password">
                        <i class="fas fa-lock field-icon"></i>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    تسجيل الدخول
                </button>
            </form>

            <div class="back-link">
                <a href="index.php"><i class="fas fa-arrow-right"></i> العودة للموقع</a>
            </div>
        </div>
    </div>
</body>
</html>