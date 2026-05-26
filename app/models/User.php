<?php
class User {
    private $db;

    public function __construct() {
        global $koneksi;
        $this->db = $koneksi;
    }

    public function getByUsername($username) {
        $username = mysqli_real_escape_string($this->db, $username);
        $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function updateRememberToken($id, $token) {
        $token = mysqli_real_escape_string($this->db, $token);
        $id = (int)$id;
        $sql = "UPDATE users SET remember_token = '$token' WHERE id = $id";
        return mysqli_query($this->db, $sql);
    }

    public function checkUsernameExists($username) {
        $username = mysqli_real_escape_string($this->db, $username);
        $sql = "SELECT id FROM users WHERE username = '$username'";
        $result = mysqli_query($this->db, $sql);
        return mysqli_num_rows($result) > 0;
    }

    public function create($nama, $username, $password) {
        $nama = mysqli_real_escape_string($this->db, $nama);
        $username = mysqli_real_escape_string($this->db, $username);
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (nama, username, password) VALUES ('$nama', '$username', '$hashed')";
        return mysqli_query($this->db, $sql);
    }
}
?>
