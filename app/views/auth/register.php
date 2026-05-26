<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register &mdash; Inventaris Barang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #1a237e 0%, #283593 60%, #3949ab 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .register-wrapper { width: 100%; max-width: 440px; padding: 20px; }
        .register-brand { text-align: center; margin-bottom: 28px; color: #fff; }
        .register-brand .brand-icon { width: 70px; height: 70px; background: rgba(255,255,255,0.15); border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 14px; }
        .register-brand h2 { font-size: 22px; font-weight: 700; }
        .register-brand p  { font-size: 13px; color: rgba(255,255,255,0.7); margin-top: 4px; }
        .register-card { background: #fff; border-radius: 16px; padding: 32px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .register-card h3 { font-size: 18px; font-weight: 700; color: #1a237e; margin-bottom: 6px; }
        .register-card p.sub { font-size: 13px; color: #888; margin-bottom: 24px; }
        .alert-error { background: #ffebee; color: #c62828; border-left: 4px solid #c62828; padding: 10px 14px; border-radius: 6px; font-size: 13px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #e8f5e9; color: #2e7d32; border-left: 4px solid #2e7d32; padding: 10px 14px; border-radius: 6px; font-size: 13px; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px; }
        .input-icon { position: relative; }
        .input-icon i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 14px; }
        .input-icon input { width: 100%; padding: 10px 12px 10px 36px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: inherit; transition: border 0.2s; }
        .input-icon input:focus { border-color: #1a237e; outline: none; box-shadow: 0 0 0 3px rgba(26,35,126,0.1); }
        .form-hint { font-size: 11.5px; color: #aaa; margin-top: 4px; }
        .btn-register { width: 100%; padding: 11px; background: #2e7d32; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 6px; }
        .btn-register:hover { background: #388e3c; }
        .login-link { text-align: center; margin-top: 20px; font-size: 13px; color: #666; }
        .login-link a { color: #1a237e; font-weight: 600; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="register-wrapper">
    <div class="register-brand">
        <div class="brand-icon"><i class="fas fa-boxes"></i></div>
        <h2>Inventaris Barang</h2>
        <p>Buat akun baru untuk mengakses sistem</p>
    </div>

    <div class="register-card">
        <h3>Daftar Akun</h3>
        <p class="sub">Isi form berikut untuk membuat akun baru</p>

        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                &nbsp;<a href="index.php?c=auth&a=login" style="color:#1a237e; font-weight:600;">Klik di sini untuk login</a>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?c=auth&a=doRegister">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <div class="input-icon">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="nama" placeholder="Masukkan nama lengkap" value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Username</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Buat username unik" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Buat password" required>
                </div>
                <p class="form-hint">Minimal 6 karakter</p>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="konfirmasi" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="index.php?c=auth&a=login">Masuk di sini</a>
        </div>
    </div>
</div>

</body>
</html>
