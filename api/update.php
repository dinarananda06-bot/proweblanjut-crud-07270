<?php
header("Content-Type: application/json; charset=UTF-8");

// Menyertakan koneksi database
require_once '../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];

// Memastikan method request adalah POST atau PUT
if ($method !== 'POST' && $method !== 'PUT') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
    exit;
}

// Mengambil data input berdasarkan method
$input_data = [];
if ($method === 'POST') {
    $input_data = $_POST;
} else {
    // Parse php://input jika method PUT menggunakan form-urlencoded
    parse_str(file_get_contents('php://input'), $input_data);
}

$id = isset($input_data['id']) ? trim($input_data['id']) : '';
$nama_barang = isset($input_data['nama_barang']) ? trim($input_data['nama_barang']) : '';
$kategori = isset($input_data['kategori']) ? trim($input_data['kategori']) : '';
$stok = isset($input_data['stok']) ? trim($input_data['stok']) : '';
$harga = isset($input_data['harga']) ? trim($input_data['harga']) : '';
$deskripsi = isset($input_data['deskripsi']) ? trim($input_data['deskripsi']) : '';
$status = isset($input_data['status']) ? trim($input_data['status']) : '';

// Validasi id
if (empty($id) || !is_numeric($id)) {
    echo json_encode(["status" => "error", "message" => "id harus ada dan valid"]);
    exit;
}

// Validasi nama_barang
if (empty($nama_barang)) {
    echo json_encode(["status" => "error", "message" => "nama_barang tidak boleh kosong"]);
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

// Update data menggunakan prepared statement mysqli
$query = "UPDATE barang SET nama_barang = ?, kategori = ?, stok = ?, harga = ?, deskripsi = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);

if ($stmt) {
    // Tipe: nama(s), kategori(s), stok(i), harga(d), deskripsi(s), status(s), id(i) => ssidssi
    mysqli_stmt_bind_param($stmt, "ssidssi", $nama_barang, $kategori, $stok, $harga, $deskripsi, $status, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Update berhasil
        echo json_encode(["status" => "success", "message" => "Barang berhasil diperbarui"]);
    } else {
        // Update gagal
        echo json_encode(["status" => "error", "message" => "Gagal memperbarui barang"]);
    }
    
    mysqli_stmt_close($stmt);
} else {
    // Gagal prepare query
    echo json_encode(["status" => "error", "message" => "Gagal menyiapkan statement database"]);
}
