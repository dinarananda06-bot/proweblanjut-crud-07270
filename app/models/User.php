<?php
class User {
    private $db;

    public function __construct() {
        global $koneksi;
        $this->db = $koneksi;
    }

    // Mengambil data user berdasarkan username, termasuk password hash
    public function getByUsername($username) {
        $username = mysqli_real_escape_string($this->db, $username);
        $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_assoc($result);
    }

    // Mengupdate token "Remember Me"
    public function updateRememberToken($id, $token) {
        $token = mysqli_real_escape_string($this->db, $token);
        $id = (int)$id;
        $sql = "UPDATE users SET remember_token = '$token' WHERE id = $id";
        return mysqli_query($this->db, $sql);
    }

    // Mengecek apakah username sudah ada
    public function checkUsernameExists($username) {
        $username = mysqli_real_escape_string($this->db, $username);
        $sql = "SELECT id FROM users WHERE username = '$username'";
        $result = mysqli_query($this->db, $sql);
        return mysqli_num_rows($result) > 0;
    }

    // Mendaftarkan user baru dengan hash password
    public function create($nama, $username, $password) {
        $nama = mysqli_real_escape_string($this->db, $nama);
        $username = mysqli_real_escape_string($this->db, $username);
        
        // Hashing password menggunakan algoritma bcrypt (default)
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (nama, username, password) VALUES ('$nama', '$username', '$hashed')";
        return mysqli_query($this->db, $sql);
    }
}
?>
