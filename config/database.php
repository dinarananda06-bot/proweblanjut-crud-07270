<?php
// Memulai session di paling atas agar CSRF dan Login berfungsi
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Koneksi ke database
$host     = "localhost";
$username = "root";
$password = "";
$database = "db_inventaris";

$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8");

// --- Token CSRF ---
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

// Fungsi untuk membersihkan input (Pencegahan XSS Dasar)
if (!function_exists('clean_input')) {
    function clean_input($data) {
        global $koneksi;
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return mysqli_real_escape_string($koneksi, $data);
    }
}

// ============================================================
//  CEK REMEMBER ME (Login Otomatis)
// ============================================================
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $token  = mysqli_real_escape_string($koneksi, $_COOKIE['remember_token']);
    $sql    = "SELECT * FROM users WHERE remember_token = '$token' LIMIT 1";
    $result = mysqli_query($koneksi, $sql);
    $user   = mysqli_fetch_assoc($result);

    if ($user) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama']     = $user['nama'];
    } else {
        setcookie('remember_token', '', time() - 3600, '/');
    }
}

// Fungsi cek apakah sudah login
if (!function_exists('cek_login')) {
    function cek_login() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?c=auth&a=login");
            exit();
        }
    }
}
?>
