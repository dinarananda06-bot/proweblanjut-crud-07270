<?php
header("Content-Type: application/json; charset=UTF-8");

// Menyertakan koneksi database
require_once '../config/database.php';

// Memastikan method request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
    exit;
}

// Mengambil data dari body (x-www-form-urlencoded)
$nama_barang = isset($_POST['nama_barang']) ? trim($_POST['nama_barang']) : '';
$kategori = isset($_POST['kategori']) ? trim($_POST['kategori']) : '';
$stok = isset($_POST['stok']) ? trim($_POST['stok']) : '';
$harga = isset($_POST['harga']) ? trim($_POST['harga']) : '';
$deskripsi = isset($_POST['deskripsi']) ? trim($_POST['deskripsi']) : '';

// Validasi input
if (empty($nama_barang)) {
    echo json_encode(["status" => "error", "message" => "nama_barang tidak boleh kosong"]);
    exit;
}

if ($stok === '' || !is_numeric($stok) || $stok < 0) {
    echo json_encode(["status" => "error", "message" => "stok harus angka >= 0"]);
    exit;
}

if ($harga === '' || !is_numeric($harga) || $harga < 0) {
    echo json_encode(["status" => "error", "message" => "harga harus angka >= 0"]);
    exit;
}

// Auto-generate kode_barang (BRG+3digit)
$query_max = "SELECT MAX(CAST(SUBSTRING(kode_barang, 4) AS UNSIGNED)) AS max_kode FROM barang WHERE kode_barang LIKE 'BRG%'";
$result_max = mysqli_query($koneksi, $query_max);
$row_max = mysqli_fetch_assoc($result_max);

$max_kode = $row_max['max_kode'] ? (int) $row_max['max_kode'] : 0;
$next_kode = $max_kode + 1;
// Format dengan padding nol: BRG001, BRG002, dll.
$kode_barang = 'BRG' . str_pad($next_kode, 3, '0', STR_PAD_LEFT);

// Insert menggunakan prepared statement mysqli
$query = "INSERT INTO barang (kode_barang, nama_barang, kategori, stok, harga, deskripsi) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $query);

if ($stmt) {
    // Tipe data parameter: s (string), i (integer), d (double)
    mysqli_stmt_bind_param($stmt, "sssids", $kode_barang, $nama_barang, $kategori, $stok, $harga, $deskripsi);
    
    if (mysqli_stmt_execute($stmt)) {
        // Insert berhasil
        echo json_encode([
            "status" => "success", 
            "message" => "Barang berhasil ditambahkan",
            "kode_barang" => $kode_barang
        ]);
    } else {
        // Insert gagal eksekusi
        echo json_encode(["status" => "error", "message" => "Gagal menambahkan data barang"]);
    }
    
    mysqli_stmt_close($stmt);
} else {
    // Gagal prepare query
    echo json_encode(["status" => "error", "message" => "Gagal menyiapkan statement database"]);
}
