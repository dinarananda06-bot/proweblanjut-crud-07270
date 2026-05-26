<?php
// Tampilkan error (opsional untuk debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load Config & Database
require_once '../config/database.php';

// Load Models
require_once '../app/models/User.php';
require_once '../app/models/Barang.php';

// Menentukan controller dan action dari URL (?c=...&a=...)
// Default controller: Auth jika belum login, Barang jika sudah login
$defaultController = isset($_SESSION['user_id']) ? 'barang' : 'auth';
$defaultAction = isset($_SESSION['user_id']) ? 'index' : 'login';

$c = isset($_GET['c']) ? strtolower($_GET['c']) : $defaultController;
$a = isset($_GET['a']) ? $_GET['a'] : $defaultAction;

$controllerName = ucfirst($c) . 'Controller';
$controllerFile = '../app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();

    if (method_exists($controller, $a)) {
        $controller->$a();
    } else {
        echo "<h3>Action '{$a}' tidak ditemukan di {$controllerName}!</h3>";
    }
} else {
    echo "<h3>Controller '{$controllerName}' tidak ditemukan!</h3>";
}
?>
