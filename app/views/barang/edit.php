<?php require_once '../app/views/layouts/header.php'; ?>
<div class="content-wrapper">
    <?php require_once '../app/views/layouts/menu.php'; ?>
    <main class="main-content">
        <div class="page-header">
            <h2>Edit Barang</h2>
            <div class="breadcrumb">
                <a href="index.php?c=barang&a=index"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right"></i>
                <a href="index.php?c=barang&a=index">Data Barang</a>
                <i class="fas fa-chevron-right"></i>
                <span>Edit Barang</span>
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
                <div class="card-header">
                    <h3><i class="fas fa-edit"></i> Form Edit Barang</h3>
                    <a href="index.php?c=barang&a=index" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="index.php?c=barang&a=update&id=<?php echo $barang['id']; ?>" class="form-vertical" enctype="multipart/form-data">
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">

                        <div class="form-row">
                            <div class="form-group">
                                <label for="kode_barang"><i class="fas fa-barcode"></i> Kode Barang <span style="color:red">*</span></label>
                                <input type="text" id="kode_barang" name="kode_barang" required
                                       value="<?php echo htmlspecialchars($barang['kode_barang']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="nama_barang"><i class="fas fa-box"></i> Nama Barang <span style="color:red">*</span></label>
                                <input type="text" id="nama_barang" name="nama_barang" required
                                       value="<?php echo htmlspecialchars($barang['nama_barang']); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="kategori"><i class="fas fa-tags"></i> Kategori <span style="color:red">*</span></label>
                                <select id="kategori" name="kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php
                                    $kategori_list = ['Elektronik','Pakaian','Makanan','Minuman','Alat Tulis','Olahraga','Lainnya'];
                                    foreach ($kategori_list as $kat):
                                        $sel = ($barang['kategori'] == $kat) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $kat; ?>" <?php echo $sel; ?>><?php echo $kat; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="stok"><i class="fas fa-cubes"></i> Stok <span style="color:red">*</span></label>
                                <input type="number" id="stok" name="stok" min="0" required
                                       value="<?php echo htmlspecialchars($barang['stok']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="harga"><i class="fas fa-money-bill-wave"></i> Harga (Rp) <span style="color:red">*</span></label>
                                <input type="number" id="harga" name="harga" min="0" required
                                       value="<?php echo htmlspecialchars($barang['harga']); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="status"><i class="fas fa-toggle-on"></i> Status <span style="color:red">*</span></label>
                                <select id="status" name="status" required>
                                    <option value="aktif"    <?php echo $barang['status'] == 'aktif'    ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="nonaktif" <?php echo $barang['status'] == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="gambar"><i class="fas fa-image"></i> Gambar Produk</label><br>
                                <?php if (!empty($barang['gambar'])): ?>
                                    <img src="../uploads/<?php echo $barang['gambar']; ?>" width="100" class="img-thumbnail" style="margin-bottom:10px;">
                                <?php endif; ?>
                                <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*">
                                <small class="form-hint">Biarkan kosong jika tidak ingin mengganti gambar (Max 1MB).</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi"><i class="fas fa-align-left"></i> Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4"><?php echo htmlspecialchars($barang['deskripsi']); ?></textarea>
                        </div>

                        <div class="form-actions">
                            <a href="index.php?c=barang&a=index" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<?php require_once '../app/views/layouts/footer.php'; ?>
