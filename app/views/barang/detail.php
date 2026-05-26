<?php require_once '../app/views/layouts/header.php'; ?>
<div class="content-wrapper">
    <?php require_once '../app/views/layouts/menu.php'; ?>
    <main class="main-content">
        <div class="page-header">
            <h2>Detail Barang</h2>
            <div class="breadcrumb">
                <a href="index.php?c=barang&a=index"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right"></i>
                <a href="index.php?c=barang&a=index">Data Barang</a>
                <i class="fas fa-chevron-right"></i>
                <span>Detail Barang</span>
            </div>
        </div>
        <div class="content">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-info-circle"></i> Informasi Barang</h3>
                    <div style="display:flex; gap:8px;">
                        <a href="index.php?c=barang&a=edit&id=<?php echo $barang['id']; ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="index.php?c=barang&a=index" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div style="display: flex; flex-wrap: wrap; gap: 30px; margin-bottom: 30px;">
                        <div style="flex: 0 0 250px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #666;">Foto Produk</label>
                            <?php 
                            $path_foto = "../uploads/" . $barang['gambar'];
                            if (!empty($barang['gambar']) && file_exists($path_foto)): 
                            ?>
                                <img src="<?php echo $path_foto; ?>" alt="Foto Produk" 
                                     style="width: 100%; max-width: 250px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: 1px solid #ddd;">
                            <?php else: ?>
                                <div style="width: 250px; height: 250px; background: #f5f5f5; border: 2px dashed #ccc; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-direction: column; color: #aaa;">
                                    <i class="fas fa-image fa-3x" style="margin-bottom: 10px;"></i>
                                    <span>Tidak ada foto</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div style="flex: 1; min-width: 300px;">
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <label>Kode Barang</label>
                                    <p><code style="font-size:15px;"><?php echo htmlspecialchars($barang['kode_barang']); ?></code></p>
                                </div>
                                <div class="detail-item">
                                    <label>Nama Barang</label>
                                    <p><?php echo htmlspecialchars($barang['nama_barang']); ?></p>
                                </div>
                                <div class="detail-item">
                                    <label>Kategori</label>
                                    <p><span class="badge badge-info"><?php echo htmlspecialchars($barang['kategori']); ?></span></p>
                                </div>
                                <div class="detail-item">
                                    <label>Status</label>
                                    <p>
                                        <?php if ($barang['status'] == 'aktif'): ?>
                                            <span class="badge badge-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="detail-item">
                                    <label>Stok</label>
                                    <p>
                                        <?php if ($barang['stok'] <= 10): ?>
                                            <span style="color:#c62828; font-weight:700;"><?php echo $barang['stok']; ?> unit</span>
                                            <span class="badge badge-danger" style="margin-left:6px;">Stok Menipis</span>
                                        <?php else: ?>
                                            <?php echo $barang['stok']; ?> unit
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="detail-item">
                                    <label>Harga</label>
                                    <p style="font-size:16px; font-weight:700; color:#1a237e;">
                                        Rp <?php echo number_format($barang['harga'], 0, ',', '.'); ?>
                                    </p>
                                </div>
                                <div class="detail-item">
                                    <label>Tanggal Dibuat</label>
                                    <p><?php echo date('d F Y, H:i', strtotime($barang['created_at'])); ?></p>
                                </div>
                                <div class="detail-item">
                                    <label>Terakhir Diperbarui</label>
                                    <p><?php echo $barang['updated_at'] ? date('d F Y, H:i', strtotime($barang['updated_at'])) : '-'; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="detail-item" style="margin-top:20px; padding-top:16px; border-top:1px solid #eee;">
                        <label>Deskripsi</label>
                        <p style="line-height:1.7; color:#555; margin-top:6px;">
                            <?php echo !empty($barang['deskripsi']) ? nl2br(htmlspecialchars($barang['deskripsi'])) : '<em style="color:#aaa;">Tidak ada deskripsi.</em>'; ?>
                        </p>
                    </div>
                    <div style="margin-top:24px; padding-top:16px; border-top:1px solid #eee; display:flex; gap:10px;">
                        <a href="index.php?c=barang&a=edit&id=<?php echo $barang['id']; ?>" class="btn btn-success">
                            <i class="fas fa-edit"></i> Edit Barang
                        </a>
                        <a href="index.php?c=barang&a=delete&id=<?php echo $barang['id']; ?>" class="btn btn-danger"
                           onclick="return confirm('Yakin ingin menghapus barang ini? Data tidak dapat dikembalikan.')">
                            <i class="fas fa-trash"></i> Hapus Barang
                        </a>
                        <a href="index.php?c=barang&a=index" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?php require_once '../app/views/layouts/footer.php'; ?>
