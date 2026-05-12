<?php
// pages/level.php
$levels = $pdo->query("SELECT * FROM level ORDER BY id DESC")->fetchAll();

// --- KEAMANAN BACKEND: HANYA ADMIN YANG BISA UBAH DATA ---
// Tambahkan syarat && $_SESSION['role'] == 'admin'
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
    // Proses Edit
    if(isset($_POST['update_level'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $stmt = $pdo->prepare("UPDATE level SET nama=? WHERE id=?");
        $stmt->execute([$nama, $id]);
        echo "<script>alert('Level berhasil diupdate!'); window.location.href='?page=level';</script>";
    }
    // Proses Tambah
    if(isset($_POST['save_level'])) {
        $nama = $_POST['nama'];
        $stmt = $pdo->prepare("INSERT INTO level (nama) VALUES (?)");
        $stmt->execute([$nama]);
        echo "<script>alert('Level berhasil ditambah!'); window.location.href='?page=level';</script>";
    }
    // Proses Hapus
    if(isset($_GET['delete_level'])) {
        $id = $_GET['delete_level'];
        $stmt = $pdo->prepare("DELETE FROM level WHERE id=?");
        $stmt->execute([$id]);
        echo "<script>alert('Level berhasil dihapus!'); window.location.href='?page=level';</script>";
    }
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><i class="fas fa-layer-group"></i> Tingkat Pendidikan</h3>
        
        <!-- Tombol Tambah HANYA muncul jika login sebagai admin -->
        <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLevelModal"><i class="fas fa-plus"></i> Tambah Tingkat</button>
        <?php endif; ?>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr><th>NO</th><th>ID</th><th>Nama Tingkat</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($levels as $level): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $level['id'] ?></td>
                <td><?= htmlspecialchars($level['nama']) ?></td>
                <td>
                    <!-- Tombol Detail BISA dilihat siapa saja -->
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailLevelModal<?= $level['id'] ?>"><i class="fas fa-eye"></i> Detail</button>
                    
                    <!-- Tombol Edit & Hapus HANYA muncul jika login sebagai admin -->
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editLevelModal<?= $level['id'] ?>"><i class="fas fa-edit"></i> Edit</button>
                        <a href="?page=level&delete_level=<?= $level['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i> Hapus</a>
                    <?php endif; ?>
                </td>
            </tr>
            
            <!-- Modal Detail -->
            <div class="modal fade" id="detailLevelModal<?= $level['id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title">Detail Level</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>ID:</strong> <?= $level['id'] ?></p>
                            <p><strong>Nama Tingkat:</strong> <?= htmlspecialchars($level['nama']) ?></p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit (Hanya dirender jika admin) -->
            <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
            <div class="modal fade" id="editLevelModal<?= $level['id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST">
                            <div class="modal-header bg-warning">
                                <h5 class="modal-title">Edit Level</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $level['id'] ?>">
                                <label>Nama Tingkat</label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($level['nama']) ?>" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="update_level" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah (Hanya dirender jika admin) -->
<?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
<div class="modal fade" id="addLevelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Tambah Tingkat Pendidikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Nama Tingkat</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="save_level" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?> 