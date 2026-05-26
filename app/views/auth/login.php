<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login &mdash; Inventaris Barang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #1a237e 0%, #283593 60%, #3949ab 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-wrapper { width: 100%; max-width: 420px; padding: 20px; }
        .login-brand { text-align: center; margin-bottom: 28px; color: #fff; }
        .login-brand .brand-icon { width: 70px; height: 70px; background: rgba(255,255,255,0.15); border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 14px; color: #fff; }
        .login-brand h2 { font-size: 22px; font-weight: 700; }
        .login-brand p  { font-size: 13px; color: rgba(255,255,255,0.7); margin-top: 4px; }
        .login-card { background: #fff; border-radius: 16px; padding: 32px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .login-card h3 { font-size: 18px; font-weight: 700; color: #1a237e; margin-bottom: 6px; }
        .login-card p.sub { font-size: 13px; color: #888; margin-bottom: 24px; }
        .alert-error { background: #ffebee; color: #c62828; border-left: 4px solid #c62828; padding: 10px 14px; border-radius: 6px; font-size: 13px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px; }
        .input-icon { position: relative; }
        .input-icon i.icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 14px; }
        .input-icon input { width: 100%; padding: 10px 12px 10px 36px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: inherit; transition: border 0.2s; }
        .input-icon input:focus { border-color: #1a237e; outline: none; box-shadow: 0 0 0 3px rgba(26,35,126,0.1); }
        .remember-row { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; margin-top: -6px; }
        .remember-row input[type="checkbox"] { width: 16px; height: 16px; accent-color: #1a237e; cursor: pointer; }
        .remember-row label { font-size: 13px; color: #555; cursor: pointer; user-select: none; }
        .remember-row label span { color: #888; font-size: 11.5px; }
        .btn-login { width: 100%; padding: 11px; background: #1a237e; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-login:hover { background: #283593; }
        .register-link { text-align: center; margin-top: 20px; font-size: 13px; color: #666; }
        .register-link a { color: #1a237e; font-weight: 600; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-brand">
        <div class="brand-icon"><i class="fas fa-boxes"></i></div>
        <h2>Inventaris Barang</h2>
        <p>Aplikasi Manajemen Inventaris</p>
    </div>

    <div class="login-card">
        <h3>Masuk ke Akun</h3>
        <p class="sub">Silakan masukkan username dan password Anda</p>

        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?c=auth&a=doLogin">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-icon">
                    <i class="fas fa-user icon"></i>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" autocomplete="username" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock icon"></i>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
                </div>
            </div>

            <!-- REMEMBER ME -->
            <div class="remember-row">
                <input type="checkbox" id="remember_me" name="remember_me" <?php echo isset($_POST['remember_me']) ? 'checked' : ''; ?>>
                <label for="remember_me">
                    Ingat saya <span>(tetap login selama 30 hari)</span>
                </label>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
        </form>

        <div class="register-link">
            Belum punya akun? <a href="index.php?c=auth&a=register">Daftar di sini</a>
        </div>
    </div>
</div>

</body>
</html>
