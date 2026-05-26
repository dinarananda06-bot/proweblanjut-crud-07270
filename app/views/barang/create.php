<?php require_once '../app/views/layouts/header.php'; ?>
<div class="content-wrapper">
    <?php require_once '../app/views/layouts/menu.php'; ?>
    <main class="main-content">
        <div class="page-header">
            <h2>Tambah Barang Baru</h2>
            <div class="breadcrumb">
                <a href="index.php?c=barang&a=index"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right"></i>
                <a href="index.php?c=barang&a=index">Data Barang</a>
                <i class="fas fa-chevron-right"></i>
                <span>Tambah Barang</span>
            </div>
        </div>

        <?php if (isset($_SESSION['pesan'])): ?>
            <div class="alert alert-<?php echo $_SESSION['tipe'] == 'success' ? 'success' : 'error'; ?>">
                <i class="fas fa-<?php echo $_SESSION['tipe'] == 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo $_SESSION['pesan']; unset($_SESSION['pesan']); unset($_SESSION['tipe']); ?>
            </div>
        <?php endif; ?>

        <div class="content">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="index.php?c=barang&a=store" enctype="multipart/form-data">
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">

                        <div class="form-group">
                            <label>Kode Barang</label>
                            <input type="text" name="kode_barang" placeholder="Otomatis jika kosong">
                        </div>

                        <div class="form-group">
                            <label>Nama Barang *</label>
                            <input type="text" name="nama_barang" required>
                        </div>

                        <div class="form-group">
                            <label>Kategori *</label>
                            <select name="kategori" required>
                                <option value="">-- Pilih --</option>
                                <?php 
                                $kategori_list = ['Elektronik','Pakaian','Makanan','Minuman','Alat Tulis','Olahraga','Lainnya'];
                                foreach ($kategori_list as $kat): ?>
                                    <option value="<?php echo $kat; ?>"><?php echo $kat; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Stok</label>
                                <input type="number" name="stok" required>
                            </div>
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="number" name="harga" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Gambar Produk</label>
                            <input type="file" name="gambar" accept="image/*">
                            <small>Maksimal 1MB (JPG/PNG)</small>
                        </div>

                        <div class="form-actions">
                            <a href="index.php?c=barang&a=index" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<?php require_once '../app/views/layouts/footer.php'; ?>
