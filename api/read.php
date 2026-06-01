<?php
header("Content-Type: application/json; charset=UTF-8");

// Menyertakan koneksi database
require_once '../config/database.php';

// Memastikan method request adalah GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
    exit;
}

// Mengambil semua data dari tabel barang dan mengurutkannya berdasarkan id DESC
$query = "SELECT id, kode_barang, nama_barang, kategori, stok, harga, status, gambar FROM barang ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Konversi tipe data
        $row['id'] = (int) $row['id'];
        $row['stok'] = (int) $row['stok'];
        $row['harga'] = (float) $row['harga'];
        $data[] = $row;
    }
    
    // Berhasil mengambil data
    echo json_encode(["status" => "success", "data" => $data]);
} else {
    // Gagal mengambil data
    echo json_encode(["status" => "error", "message" => "Gagal mengambil data"]);
}
