<?php
require_once 'config/database.php';

if(!isLoggedIn()) {
    redirect('../login.php');
}

// Cek role user
$isAdmin = isAdmin();

// ========== PROSES TAMBAH DATA (HANYA ADMIN) ==========
if($isAdmin && isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $idlevel = $_POST['idlevel'];
    $keterangan = $_POST['keterangan'];
    $tahun_lulus = $_POST['tahun_lulus'];
    
    $foto = null;
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $uploadDir = '../assets/uploads/';
        if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $foto);
    }
    
    $stmt = $pdo->prepare("INSERT INTO studies (nama, idlevel, keterangan, tahun_lulus, foto_sekolah) VALUES (?, ?, ?, ?, ?)");
    if($stmt->execute([$nama, $idlevel, $keterangan, $tahun_lulus, $foto])) {
        echo "<script>alert('✅ Data pendidikan berhasil ditambahkan!'); window.location.href='?page=studies';</script>";
        exit();
    }
}

// ========== PROSES EDIT DATA (HANYA ADMIN) ==========
if($isAdmin && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $idlevel = $_POST['idlevel'];
    $keterangan = $_POST['keterangan'];
    $tahun_lulus = $_POST['tahun_lulus'];
    
    $stmt = $pdo->prepare("SELECT foto_sekolah FROM studies WHERE id = ?");
    $stmt->execute([$id]);
    $foto_lama = $stmt->fetchColumn();
    $foto = $foto_lama;
    
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $uploadDir = '../assets/uploads/';
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $foto);
        if($foto_lama && file_exists($uploadDir . $foto_lama)) {
            unlink($uploadDir . $foto_lama);
        }
    }
    
    $stmt = $pdo->prepare("UPDATE studies SET nama=?, idlevel=?, keterangan=?, tahun_lulus=?, foto_sekolah=? WHERE id=?");
    if($stmt->execute([$nama, $idlevel, $keterangan, $tahun_lulus, $foto, $id])) {
        echo "<script>alert('✅ Data pendidikan berhasil diupdate!'); window.location.href='?page=studies';</script>";
        exit();
    }
}

// ========== PROSES HAPUS DATA (HANYA ADMIN) ==========
if($isAdmin && isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $stmt = $pdo->prepare("SELECT foto_sekolah FROM studies WHERE id = ?");
    $stmt->execute([$id]);
    $foto = $stmt->fetchColumn();
    if($foto && file_exists('../assets/uploads/' . $foto)) {
        unlink('../assets/uploads/' . $foto);
    }
    $stmt = $pdo->prepare("DELETE FROM studies WHERE id = ?");
    if($stmt->execute([$id])) {
        echo "<script>alert('✅ Data pendidikan berhasil dihapus!'); window.location.href='?page=studies';</script>";
        exit();
    }
}

// ========== AMBIL SEMUA DATA STUDIES ==========
$studies = $pdo->query("
    SELECT s.*, l.nama as level_name 
    FROM studies s 
    JOIN level l ON s.idlevel = l.id 
    ORDER BY s.tahun_lulus DESC
")->fetchAll();

// ========== AMBIL DATA LEVEL UNTUK DROPDOWN ==========
$levels = $pdo->query("SELECT * FROM level ORDER BY id")->fetchAll();
?>

<style>
    .bg-gradient-success {
        background: linear-gradient(135deg, #139acfff 0%, #053c46ff 100%);
    }
    .bg-gradient-danger {
        background: linear-gradient(135deg, #02cbfdff 0%, #06525bff 100%);
    }
    .study-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
    }
    .study-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    .card-img-top {
        height: 180px;
        object-fit: cover;
    }
    .btn-group-custom {
        display: flex;
        gap: 5px;
    }
    .btn-group-custom .btn {
        flex: 1;
        border-radius: 8px;
    }
    .admin-badge {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }
    .role-badge {
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 12px;
    }
</style>

<!-- Role Badge Floating -->
<div class="admin-badge">
    <div class="role-badge">
        <i class="fas <?php echo $isAdmin ? 'fa-crown text-warning' : 'fa-user text-info'; ?> me-2"></i>
        Login sebagai: <strong><?php echo $isAdmin ? 'ADMINISTRATOR' : 'USER BIASA'; ?></strong>
        <?php if(!$isAdmin): ?>
        <span class="ms-2 badge bg-secondary">Mode: Hanya Lihat</span>
        <?php endif; ?>
    </div>
</div>

<!-- Card Utama -->
<div class="card shadow-lg border-0 rounded-4">
    <div class="card-header <?php echo $isAdmin ? 'bg-gradient-success' : 'bg-gradient-danger'; ?> text-white rounded-top-4 p-3 d-flex justify-content-between align-items-center">
        <h3 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Manajemen Riwayat Pendidikan</h3>
        
        <?php if($isAdmin): ?>
        <button type="button" class="btn btn-light rounded-pill px-4"
                data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-2"></i>Tambah Pendidikan
        </button>
        <?php else: ?>
        <div class="text-white">
            <i class="fas fa-eye me-2"></i>Mode Baca Saja
        </div>
        <?php endif; ?>
    </div>

    <div class="card-body p-4">
        <?php if(count($studies) > 0): ?>
            <div class="row">
                <?php foreach($studies as $study): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="study-card card border-0 shadow-sm">
                        <!-- Foto -->
                        <?php if($study['foto_sekolah'] && file_exists('../assets/uploads/' . $study['foto_sekolah'])): ?>
                            <img src="../assets/uploads/<?php echo $study['foto_sekolah']; ?>" class="card-img-top" alt="Foto Sekolah">
                        <?php else: ?>
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center">
                                <i class="fas fa-school fa-4x text-white"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($study['nama']); ?></h5>
                            <div class="mb-2">
                                <span class="badge bg-primary">
                                    <i class="fas fa-tag me-1"></i><?php echo $study['level_name']; ?>
                                </span>
                                <span class="badge bg-info">
                                    <i class="fas fa-calendar me-1"></i><?php echo $study['tahun_lulus']; ?>
                                </span>
                            </div>
                            <p class="card-text text-muted small">
                                <?php echo nl2br(htmlspecialchars(substr($study['keterangan'], 0, 100))); ?>
                                <?php echo strlen($study['keterangan']) > 100 ? '...' : ''; ?>
                            </p>
                        </div>
                        
                        <div class="card-footer bg-white border-0 pb-3">
                            <div class="btn-group-custom">
                                <!-- ✅ DETAIL: data-bs-toggle langsung, tidak perlu redirect -->
                                <button type="button" class="btn btn-info btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDetail<?php echo $study['id']; ?>">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </button>
                                
                                <!-- ✅ EDIT: data-bs-toggle langsung, tidak perlu redirect -->
                                <?php if($isAdmin): ?>
                                <button type="button" class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit<?php echo $study['id']; ?>">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </button>
                                <?php endif; ?>
                                
                                <!-- Hapus tetap pakai link -->
                                <?php if($isAdmin): ?>
                                <a href="?page=studies&hapus=<?php echo $study['id']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin ingin menghapus data pendidikan ini?')">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ✅ MODAL DETAIL per-item (inline di dalam loop) -->
                <div class="modal fade" id="modalDetail<?php echo $study['id']; ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content rounded-4">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Detail Riwayat Pendidikan</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <?php if($study['foto_sekolah'] && file_exists('../assets/uploads/' . $study['foto_sekolah'])): ?>
                                    <div class="col-md-5 text-center mb-3">
                                        <img src="../assets/uploads/<?php echo $study['foto_sekolah']; ?>"
                                             class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                    <div class="col-md-7">
                                    <?php else: ?>
                                    <div class="col-md-12">
                                    <?php endif; ?>
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="150">Nama Sekolah</th>
                                                <td>: <strong><?php echo htmlspecialchars($study['nama']); ?></strong></td>
                                            </tr>
                                            <tr>
                                                <th>Jenjang</th>
                                                <td>: <span class="badge bg-primary"><?php echo $study['level_name']; ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>Tahun Lulus</th>
                                                <td>: <?php echo $study['tahun_lulus']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Keterangan</th>
                                                <td>: <?php echo nl2br(htmlspecialchars($study['keterangan'] ?: '-')); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <?php if($isAdmin): ?>
                                <button type="button" class="btn btn-warning"
                                        data-bs-dismiss="modal"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit<?php echo $study['id']; ?>">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ✅ MODAL EDIT per-item (inline di dalam loop, hanya admin) -->
                <?php if($isAdmin): ?>
                <div class="modal fade" id="modalEdit<?php echo $study['id']; ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content rounded-4">
                            <div class="modal-header bg-warning">
                                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Riwayat Pendidikan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?php echo $study['id']; ?>">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label fw-bold">Nama Sekolah/Instansi <span class="text-danger">*</span></label>
                                            <input type="text" name="nama" class="form-control"
                                                   value="<?php echo htmlspecialchars($study['nama']); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Jenjang Pendidikan <span class="text-danger">*</span></label>
                                            <select name="idlevel" class="form-control" required>
                                                <option value="">-- Pilih Jenjang --</option>
                                                <?php foreach($levels as $level): ?>
                                                <option value="<?php echo $level['id']; ?>"
                                                    <?php echo $study['idlevel'] == $level['id'] ? 'selected' : ''; ?>>
                                                    <?php echo $level['nama']; ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Tahun Lulus <span class="text-danger">*</span></label>
                                            <input type="number" name="tahun_lulus" class="form-control"
                                                   value="<?php echo $study['tahun_lulus']; ?>" min="1990" max="2030" required>
                                        </div>

                                        <?php if($study['foto_sekolah'] && file_exists('../assets/uploads/' . $study['foto_sekolah'])): ?>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label fw-bold">Foto Saat Ini</label>
                                            <div>
                                                <img src="../assets/uploads/<?php echo $study['foto_sekolah']; ?>"
                                                     style="max-width: 150px; border-radius: 10px;">
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label fw-bold">Ganti Foto (Opsional)</label>
                                            <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">Keterangan</label>
                                            <textarea name="keterangan" class="form-control" rows="4"><?php echo htmlspecialchars($study['keterangan']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="edit" class="btn btn-warning">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php endforeach; ?>
            </div>

            <!-- Total Data -->
            <div class="alert alert-secondary mt-3">
                <i class="fas fa-database me-2"></i>
                Total Data: <strong><?php echo count($studies); ?></strong> Riwayat Pendidikan
                <?php if(!$isAdmin): ?>
                <span class="float-end">
                    <i class="fas fa-lock me-1"></i> Anda dalam mode baca saja
                </span>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-inbox fa-4x mb-3 d-block"></i>
                <h5>Belum ada data pendidikan</h5>
                <p>Silakan tambahkan riwayat pendidikan Anda dengan klik tombol "Tambah Pendidikan"</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ========== MODAL TAMBAH (HANYA ADMIN) ========== -->
<?php if($isAdmin): ?>
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah Riwayat Pendidikan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Nama Sekolah/Instansi <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required placeholder="Contoh: Universitas Indonesia">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenjang Pendidikan <span class="text-danger">*</span></label>
                            <select name="idlevel" class="form-control" required>
                                <option value="">-- Pilih Jenjang --</option>
                                <?php foreach($levels as $level): ?>
                                <option value="<?php echo $level['id']; ?>"><?php echo $level['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tahun Lulus <span class="text-danger">*</span></label>
                            <input type="number" name="tahun_lulus" class="form-control" min="1990" max="2030" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Foto Sekolah</label>
                            <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg">
                            <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="4" placeholder="Ceritakan pengalaman Anda selama menempuh pendidikan di sini..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>