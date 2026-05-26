<?php
require 'c:\xampp\htdocs\inventaris_mvc\config\database.php';
$sql = "INSERT INTO barang (kode_barang, nama_barang, kategori, stok, harga, deskripsi, gambar, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'aktif')";
$stmt = mysqli_prepare($koneksi, $sql);
if (!$stmt) {
    echo "ERROR: " . mysqli_error($koneksi);
} else {
    echo "SUCCESS";
}
?>
