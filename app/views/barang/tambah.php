<?php $page_title = "Tambah Barang"; ?>
<?php require dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="content-wrapper">
    <?php require dirname(__DIR__) . '/layouts/menu.php'; ?>

    <main class="main-content">

        <div class="page-header">
            <h2><i class="fas fa-plus-circle"></i> Tambah Barang</h2>
            <div class="breadcrumb">
                <a href="<?= BASE_URL; ?>"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right"></i>
                <a href="<?= BASE_URL; ?>?action=barang">Data Barang</a>
                <i class="fas fa-chevron-right"></i>
                <span>Tambah</span>
            </div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?= $error; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-plus-circle"></i> Form Tambah Barang</h3>
                <a href="<?= BASE_URL; ?>?action=barang" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL; ?>?action=tambah" class="form-vertical">

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-barcode"></i> Kode Barang</label>
                            <input type="text" name="kode_barang"
                                   placeholder="Kosongkan untuk generate otomatis"
                                   value="<?= isset($_POST['kode_barang']) ? htmlspecialchars($_POST['kode_barang']) : ''; ?>">
                            <small class="form-hint">Contoh: BRG006 — biarkan kosong untuk otomatis</small>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-box"></i> Nama Barang <span style="color:red">*</span></label>
                            <input type="text" name="nama_barang" required
                                   value="<?= isset($_POST['nama_barang']) ? htmlspecialchars($_POST['nama_barang']) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-tags"></i> Kategori <span style="color:red">*</span></label>
                            <select name="kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach (['Elektronik','Pakaian','Makanan','Minuman','Alat Tulis','Olahraga','Lainnya'] as $k): ?>
                                <option value="<?= $k; ?>" <?= (isset($_POST['kategori']) && $_POST['kategori']==$k) ? 'selected' : ''; ?>><?= $k; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-cubes"></i> Stok <span style="color:red">*</span></label>
                            <input type="number" name="stok" min="0" required
                                   value="<?= isset($_POST['stok']) ? htmlspecialchars($_POST['stok']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-money-bill-wave"></i> Harga (Rp) <span style="color:red">*</span></label>
                            <input type="number" name="harga" min="0" required
                                   value="<?= isset($_POST['harga']) ? htmlspecialchars($_POST['harga']) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-align-left"></i> Deskripsi</label>
                        <textarea name="deskripsi" rows="4" placeholder="Deskripsi barang (opsional)..."><?= isset($_POST['deskripsi']) ? htmlspecialchars($_POST['deskripsi']) : ''; ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Barang
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </main>
</div>

<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
