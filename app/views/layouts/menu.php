<?php
$current_controller = isset($_GET['c']) ? $_GET['c'] : 'barang';
$current_action = isset($_GET['a']) ? $_GET['a'] : 'index';
?>
<nav class="sidebar">
    <div class="sidebar-brand">
        <h3><i class="fas fa-boxes"></i> Inventaris</h3>
        <p>Manajemen Barang</p>
    </div>

    <!-- Info User yang Login -->
    <div class="sidebar-user">
        <div class="user-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="user-info">
            <span class="user-name"><?php echo htmlspecialchars($_SESSION['nama'] ?? 'User'); ?></span>
            <span class="user-role">@<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></span>
        </div>
    </div>

    <ul class="sidebar-menu">
        <li>
            <a href="index.php?c=barang&a=index" class="<?php echo ($current_controller == 'barang' && $current_action == 'index') ? 'active' : ''; ?>">
                <i class="fas fa-box"></i> Data Barang
            </a>
        </li>
        <li>
            <a href="index.php?c=barang&a=create" class="<?php echo ($current_controller == 'barang' && $current_action == 'create') ? 'active' : ''; ?>">
                <i class="fas fa-plus"></i> Tambah Barang
            </a>
        </li>
    </ul>

    <!-- Tombol Logout -->
    <div class="sidebar-logout">
        <a href="index.php?c=auth&a=logout" onclick="return confirm('Yakin ingin keluar?')" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
    </div>
</nav>
