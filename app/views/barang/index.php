<?php require_once '../app/views/layouts/header.php'; ?>
<div class="content-wrapper">
    <?php require_once '../app/views/layouts/menu.php'; ?>

    <main class="main-content">
        <div class="page-header">
            <h2><?php echo $page_title; ?></h2>
            <div class="breadcrumb">
                <a href="index.php?c=barang&a=index"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right"></i>
                <span><?php echo $page_title; ?></span>
            </div>
        </div>

        <?php if (isset($_SESSION['pesan'])): ?>
            <div class="alert alert-<?php echo ($_SESSION['tipe'] == 'success') ? 'success' : 'error'; ?>" style="padding: 15px; margin-bottom: 20px; border-radius: 4px; border: 1px solid transparent; <?php echo ($_SESSION['tipe'] == 'success') ? 'color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6;' : 'color: #a94442; background-color: #f2dede; border-color: #ebccd1;'; ?>">
                <i class="fas fa-<?php echo ($_SESSION['tipe'] == 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php 
                    echo $_SESSION['pesan']; 
                    unset($_SESSION['pesan']); 
                    unset($_SESSION['tipe']); 
                ?>
            </div>
        <?php endif; ?>

        <div class="content">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-box"></i> Daftar Barang</h3>
                    <a href="index.php?c=barang&a=create" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Barang
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-toolbar">
                        <span style="font-size:13px; color:#666;">
                            Menampilkan <strong><?php echo count($barangList); ?></strong> data barang
                        </span>
                        <form method="GET" action="index.php" class="search-box">
                            <input type="hidden" name="c" value="barang">
                            <input type="hidden" name="a" value="index">
                            <input type="text" name="search" placeholder="Cari nama / kode / kategori..."
                                   value="<?php echo htmlspecialchars($search ?? ''); ?>">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-search"></i>
                            </button>
                            <?php if (!empty($search)): ?>
                            <a href="index.php?c=barang&a=index" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times"></i>
                            </a>
                            <?php endif; ?>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th width="40">No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th width="160">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($barangList) > 0):
                                    $no = 1;
                                    foreach ($barangList as $row):
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><code><?php echo htmlspecialchars($row['kode_barang']); ?></code></td>
                                    <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                                    <td><span class="badge badge-info"><?php echo htmlspecialchars($row['kategori']); ?></span></td>
                                    <td>
                                        <?php if ($row['stok'] <= 10): ?>
                                            <span style="color:#c62828; font-weight:600;"><?php echo $row['stok']; ?></span>
                                            <small style="color:#c62828;">(menipis)</small>
                                        <?php else: ?>
                                            <?php echo $row['stok']; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if ($row['status'] == 'aktif'): ?>
                                            <span class="badge badge-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="index.php?c=barang&a=detail&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="index.php?c=barang&a=edit&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?c=barang&a=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="8" style="text-align:center; color:#888; padding:24px;">
                                        <i class="fas fa-inbox" style="font-size:28px; display:block; margin-bottom:8px;"></i>
                                        <?php echo !empty($search) ? "Tidak ada hasil untuk pencarian \"$search\"." : "Belum ada data barang."; ?>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?php require_once '../app/views/layouts/footer.php'; ?>
