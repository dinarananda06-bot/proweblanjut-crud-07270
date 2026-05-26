<?php $page_title = "Dashboard"; ?>
<?php require dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="content-wrapper">
    <?php require dirname(__DIR__) . '/layouts/menu.php'; ?>

    <main class="main-content">

        <div class="page-header">
            <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
            <div class="breadcrumb">
                <a href="<?= BASE_URL; ?>"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>Dashboard</span>
            </div>
        </div>

        <?php if (isset($_SESSION['pesan'])): ?>
            <div class="alert alert-<?= $_SESSION['tipe'] == 'success' ? 'success' : 'error'; ?>">
                <i class="fas fa-<?= $_SESSION['tipe'] == 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo $_SESSION['pesan']; unset($_SESSION['pesan']); unset($_SESSION['tipe']); ?>
            </div>
        <?php endif; ?>

        <!-- Statistik -->
        <div class="stats-grid">
            <div class="stat-card blue">
                <div class="stat-icon"><i class="fas fa-boxes"></i></div>
                <div class="stat-info"><h4><?= $total_barang; ?></h4><p>Total Barang</p></div>
            </div>
            <div class="stat-card green">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info"><h4><?= $barang_aktif; ?></h4><p>Barang Aktif</p></div>
            </div>
            <div class="stat-card orange">
                <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="stat-info"><h4><?= $stok_menipis; ?></h4><p>Stok Menipis (&le;10)</p></div>
            </div>
            <div class="stat-card red">
                <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
                <div class="stat-info"><h4><?= $barang_nonaktif; ?></h4><p>Barang Nonaktif</p></div>
            </div>
        </div>

        <!-- Tabel Barang Terbaru -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-clock"></i> Barang Terbaru</h3>
                <a href="<?= BASE_URL; ?>?action=barang" class="btn btn-primary btn-sm">
                    <i class="fas fa-list"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($barang_terbaru)): ?>
                            <tr>
                                <td><code><?= htmlspecialchars($row['kode_barang']); ?></code></td>
                                <td><?= htmlspecialchars($row['nama_barang']); ?></td>
                                <td><span class="badge badge-info"><?= htmlspecialchars($row['kategori']); ?></span></td>
                                <td>
                                    <?php if ($row['stok'] <= 10): ?>
                                        <span style="color:#c62828;font-weight:600;"><?= $row['stok']; ?></span>
                                        <small style="color:#c62828;">(menipis)</small>
                                    <?php else: ?><?= $row['stok']; ?><?php endif; ?>
                                </td>
                                <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <span class="badge <?= $row['status']=='aktif' ? 'badge-success' : 'badge-danger'; ?>">
                                        <?= ucfirst($row['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
</div>

<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
