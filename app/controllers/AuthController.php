<?php
class AuthController {
    public function login() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?c=barang&a=index");
            exit();
        }
        $error = '';
        require_once '../app/views/auth/login.php';
    }

    public function doLogin() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?c=barang&a=index");
            exit();
        }
        
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username_input = clean_input($_POST['username']);
            $password_input = $_POST['password'];
            $remember_me    = isset($_POST['remember_me']);

            if (empty($username_input) || empty($password_input)) {
                $error = "Username dan password wajib diisi!";
            } else {
                $userModel = new User();
                $user = $userModel->getByUsername($username_input);

                if ($user && password_verify($password_input, $user['password'])) {
                    $_SESSION['user_id']  = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['nama']     = $user['nama'];

                    if ($remember_me) {
                        $token = bin2hex(random_bytes(32));
                        $userModel->updateRememberToken($user['id'], $token);
                        setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/');
                    }

                    $_SESSION['pesan'] = "Selamat datang, <strong>" . htmlspecialchars($user['nama']) . "</strong>!";
                    $_SESSION['tipe']  = "success";
                    header("Location: index.php?c=barang&a=index");
                    exit();
                } else {
                    $error = "Username atau password salah!";
                }
            }
        }
        // Jika gagal, tampilkan kembali view login
        require_once '../app/views/auth/login.php';
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?c=barang&a=index");
            exit();
        }
        $error = '';
        $success = '';
        require_once '../app/views/auth/register.php';
    }

    public function doRegister() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?c=barang&a=index");
            exit();
        }

        $error = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama            = clean_input($_POST['nama']);
            $username_input  = clean_input($_POST['username']);
            $password_input  = $_POST['password'];
            $konfirmasi      = $_POST['konfirmasi'];

            if (empty($nama) || empty($username_input) || empty($password_input) || empty($konfirmasi)) {
                $error = "Semua field wajib diisi!";
            } elseif (strlen($password_input) < 6) {
                $error = "Password minimal 6 karakter!";
            } elseif ($password_input !== $konfirmasi) {
                $error = "Konfirmasi password tidak cocok!";
            } else {
                $userModel = new User();
                if ($userModel->checkUsernameExists($username_input)) {
                    $error = "Username <strong>$username_input</strong> sudah digunakan, pilih username lain!";
                } else {
                    if ($userModel->create($nama, $username_input, $password_input)) {
                        $success = "Akun berhasil dibuat! Silakan login.";
                    } else {
                        $error = "Gagal membuat akun.";
                    }
                }
            }
        }
        require_once '../app/views/auth/register.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        header("Location: index.php?c=auth&a=login");
        exit();
    }
}
?>
