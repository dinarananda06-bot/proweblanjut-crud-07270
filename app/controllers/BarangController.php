<?php
class BarangController {
    public function __construct() {
        cek_login();
    }

    public function index() {
        $search = isset($_GET['search']) ? clean_input($_GET['search']) : '';
        $barangModel = new Barang();
        $barangList = $barangModel->getAll($search);
        
        $page_title = 'Daftar Inventaris Barang';
        require_once '../app/views/barang/index.php';
    }

    public function create() {
        $page_title = 'Tambah Barang Baru';
        require_once '../app/views/barang/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
                die("Akses tidak sah!");
            }

            $barangModel = new Barang();
            
            $kode_barang = clean_input($_POST['kode_barang']);
            if (empty($kode_barang)) {
                $kode_barang = $barangModel->generateKode();
            } else {
                if ($barangModel->checkKodeExists($kode_barang)) {
                    $_SESSION['pesan'] = "Kode barang <strong>$kode_barang</strong> sudah digunakan!";
                    $_SESSION['tipe']  = "error";
                    $page_title = 'Tambah Barang Baru';
                    require_once '../app/views/barang/create.php';
                    return;
                }
            }

            $gambar_nama = "";
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $target_dir  = "../uploads/";
                $ekstensi    = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
                $gambar_nama = time() . "_" . uniqid() . "." . $ekstensi;
                
                $check = getimagesize($_FILES["gambar"]["tmp_name"]);
                $allowed = ['jpg', 'jpeg', 'png'];
                if ($check !== false && $_FILES["gambar"]["size"] <= 1000000 && in_array($ekstensi, $allowed)) {
                    move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_dir . $gambar_nama);
                } else {
                    $gambar_nama = "";
                }
            }

            $data = [
                'kode_barang' => $kode_barang,
                'nama_barang' => clean_input($_POST['nama_barang']),
                'kategori'    => clean_input($_POST['kategori']),
                'stok'        => (int)$_POST['stok'],
                'harga'       => (float)$_POST['harga'],
                'deskripsi'   => clean_input($_POST['deskripsi']),
                'gambar'      => $gambar_nama
            ];

            if ($barangModel->insert($data)) {
                $_SESSION['pesan'] = "Barang berhasil ditambahkan!";
                $_SESSION['tipe']  = "success";
                header("Location: index.php?c=barang&a=index");
                exit();
            } else {
                $_SESSION['pesan'] = "Gagal menambah barang!";
                $_SESSION['tipe']  = "error";
                $page_title = 'Tambah Barang Baru';
                require_once '../app/views/barang/create.php';
            }
        }
    }

    public function edit() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) {
            $_SESSION['pesan'] = "ID barang tidak valid!";
            $_SESSION['tipe']  = "error";
            header("Location: index.php?c=barang&a=index");
            exit();
        }

        $barangModel = new Barang();
        $barang = $barangModel->getById($id);

        if (!$barang) {
            $_SESSION['pesan'] = "Barang tidak ditemukan!";
            $_SESSION['tipe']  = "error";
            header("Location: index.php?c=barang&a=index");
            exit();
        }

        $page_title = "Edit Barang";
        require_once '../app/views/barang/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
                die("Akses tidak sah! Token CSRF tidak valid.");
            }

            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $barangModel = new Barang();
            $barang = $barangModel->getById($id);

            if (!$barang) {
                $_SESSION['pesan'] = "Barang tidak ditemukan!";
                $_SESSION['tipe']  = "error";
                header("Location: index.php?c=barang&a=index");
                exit();
            }

            $kode_barang = clean_input($_POST['kode_barang']);
            if ($barangModel->checkKodeExists($kode_barang, $id)) {
                $_SESSION['pesan'] = "Kode barang <strong>$kode_barang</strong> sudah digunakan oleh barang lain!";
                $_SESSION['tipe']  = "error";
                $page_title = "Edit Barang";
                require_once '../app/views/barang/edit.php';
                return;
            }

            $gambar_final = $barang['gambar'];
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $target_dir  = "../uploads/";
                $ekstensi    = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
                $nama_baru   = time() . "_" . uniqid() . "." . $ekstensi;
                $target_file = $target_dir . $nama_baru;

                $check = getimagesize($_FILES["gambar"]["tmp_name"]);
                $allowed = ['jpg', 'jpeg', 'png'];
                
                if ($check !== false && $_FILES["gambar"]["size"] <= 1000000 && in_array($ekstensi, $allowed)) {
                    if (!empty($barang['gambar']) && file_exists($target_dir . $barang['gambar'])) {
                        unlink($target_dir . $barang['gambar']);
                    }
                    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                        $gambar_final = $nama_baru;
                    }
                } else {
                    $_SESSION['pesan'] = "Gagal upload: Pastikan file gambar JPG/PNG dan maksimal 1MB.";
                    $_SESSION['tipe']  = "error";
                }
            }

            $data = [
                'kode_barang' => $kode_barang,
                'nama_barang' => clean_input($_POST['nama_barang']),
                'kategori'    => clean_input($_POST['kategori']),
                'stok'        => (int)$_POST['stok'],
                'harga'       => (float)$_POST['harga'],
                'deskripsi'   => clean_input($_POST['deskripsi']),
                'status'      => clean_input($_POST['status']),
                'gambar'      => $gambar_final
            ];

            if ($barangModel->update($id, $data)) {
                $_SESSION['pesan'] = "Data barang <strong>" . htmlspecialchars($data['nama_barang']) . "</strong> berhasil diperbarui!";
                $_SESSION['tipe']  = "success";
                header("Location: index.php?c=barang&a=index");
                exit();
            } else {
                $_SESSION['pesan'] = "Gagal memperbarui barang!";
                $_SESSION['tipe']  = "error";
                $page_title = "Edit Barang";
                require_once '../app/views/barang/edit.php';
            }
        }
    }

    public function delete() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) {
            $_SESSION['pesan'] = "ID barang tidak valid!";
            $_SESSION['tipe']  = "error";
            header("Location: index.php?c=barang&a=index");
            exit();
        }

        $barangModel = new Barang();
        $barang = $barangModel->getById($id);

        if (!$barang) {
            $_SESSION['pesan'] = "Barang tidak ditemukan!";
            $_SESSION['tipe']  = "error";
        } else {
            $nama = $barang['nama_barang'];
            $file_gambar = $barang['gambar'];

            if ($barangModel->delete($id)) {
                if (!empty($file_gambar)) {
                    $path = "../uploads/" . $file_gambar;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $_SESSION['pesan'] = "Barang <strong>" . htmlspecialchars($nama) . "</strong> berhasil dihapus!";
                $_SESSION['tipe']  = "success";
            } else {
                $_SESSION['pesan'] = "Gagal menghapus barang!";
                $_SESSION['tipe']  = "error";
            }
        }
        header("Location: index.php?c=barang&a=index");
        exit();
    }

    public function detail() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) {
            $_SESSION['pesan'] = "ID barang tidak valid!";
            $_SESSION['tipe']  = "error";
            header("Location: index.php?c=barang&a=index");
            exit();
        }

        $barangModel = new Barang();
        $barang = $barangModel->getById($id);

        if (!$barang) {
            $_SESSION['pesan'] = "Barang tidak ditemukan!";
            $_SESSION['tipe']  = "error";
            header("Location: index.php?c=barang&a=index");
            exit();
        }

        $page_title = "Detail Barang";
        require_once '../app/views/barang/detail.php';
    }
}
?>
