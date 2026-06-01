<?php
header("Content-Type: application/json; charset=UTF-8");

// Menyertakan koneksi database
require_once '../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];

// Mendukung DELETE atau POST dengan input _method=DELETE
$is_delete_method = ($method === 'DELETE');
$is_post_override = ($method === 'POST' && isset($_POST['_method']) && strtoupper($_POST['_method']) === 'DELETE');

if (!$is_delete_method && !$is_post_override) {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
    exit;
}

// Mengambil ID dari POST, GET (query string), atau parse input (body raw form-urlencoded)
$id = '';
if ($is_post_override && isset($_POST['id'])) {
    $id = $_POST['id'];
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    parse_str(file_get_contents('php://input'), $input_data);
    if (isset($input_data['id'])) {
        $id = $input_data['id'];
    }
}

$id = trim($id);

// Validasi id
if (empty($id) || !is_numeric($id)) {
    echo json_encode(["status" => "error", "message" => "id harus valid dan barang harus ada"]);
    exit;
}

// Cek apakah barang dengan id tersebut ada di database
$query_check = "SELECT id FROM barang WHERE id = ?";
$stmt_check = mysqli_prepare($koneksi, $query_check);
mysqli_stmt_bind_param($stmt_check, "i", $id);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($result_check) === 0) {
    // Barang tidak ditemukan
    echo json_encode(["status" => "error", "message" => "Barang tidak ditemukan"]);
    mysqli_stmt_close($stmt_check);
    exit;
}
mysqli_stmt_close($stmt_check);

// Menghapus data menggunakan prepared statement mysqli
$query = "DELETE FROM barang WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Delete berhasil
        echo json_encode(["status" => "success", "message" => "Barang berhasil dihapus"]);
    } else {
        // Delete gagal
        echo json_encode(["status" => "error", "message" => "Gagal menghapus barang"]);
    }
    
    mysqli_stmt_close($stmt);
} else {
    // Gagal prepare query
    echo json_encode(["status" => "error", "message" => "Gagal menyiapkan statement database"]);
}
