<?php
class Barang {
    private $db;

    public function __construct() {
        global $koneksi;
        $this->db = $koneksi;
    }

    public function getAll($search = '') {
        $query = "SELECT * FROM barang";
        if (!empty($search)) {
            $search = mysqli_real_escape_string($this->db, $search);
            $query .= " WHERE nama_barang LIKE '%$search%' 
                        OR kode_barang LIKE '%$search%' 
                        OR kategori LIKE '%$search%'";
        }
        $query .= " ORDER BY id DESC";
        $result = mysqli_query($this->db, $query);
        
        $data = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getById($id) {
        $stmt = mysqli_prepare($this->db, "SELECT * FROM barang WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function checkKodeExists($kode, $exclude_id = 0) {
        $stmt = mysqli_prepare($this->db, "SELECT id FROM barang WHERE kode_barang = ? AND id != ?");
        mysqli_stmt_bind_param($stmt, "si", $kode, $exclude_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }

    public function generateKode() {
        $prefix = "BRG";
        $q_max  = "SELECT MAX(CAST(SUBSTRING(kode_barang, 4) AS UNSIGNED)) AS max_kode FROM barang WHERE kode_barang LIKE '$prefix%'";
        $r_max  = mysqli_query($this->db, $q_max);
        $row_max = mysqli_fetch_assoc($r_max);
        $next_num = ($row_max['max_kode'] ?? 0) + 1;
        return $prefix . str_pad($next_num, 3, '0', STR_PAD_LEFT);
    }

    public function insert($data) {
        $sql = "INSERT INTO barang (kode_barang, nama_barang, kategori, stok, harga, deskripsi, gambar, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'aktif')";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, "sssidss", 
            $data['kode_barang'], $data['nama_barang'], $data['kategori'], 
            $data['stok'], $data['harga'], $data['deskripsi'], $data['gambar']
        );
        return mysqli_stmt_execute($stmt);
    }

    public function update($id, $data) {
        $sql = "UPDATE barang SET 
                    kode_barang = ?, nama_barang = ?, kategori = ?, 
                    stok = ?, harga = ?, deskripsi = ?, status = ?, 
                    gambar = ?, updated_at = NOW() 
                WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, "sssidsssi", 
            $data['kode_barang'], $data['nama_barang'], $data['kategori'], 
            $data['stok'], $data['harga'], $data['deskripsi'], 
            $data['status'], $data['gambar'], $id
        );
        return mysqli_stmt_execute($stmt);
    }

    public function delete($id) {
        $stmt = mysqli_prepare($this->db, "DELETE FROM barang WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }
}
?>
