<?php
// ======================================================
// INSTALLER OTOMATIS - PORTOFOLIO DATABASE
// ======================================================

echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Installer Portofolio</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .installer-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            max-width: 800px;
            width: 100%;
            overflow: hidden;
        }
        .installer-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .installer-header h1 {
            margin: 0;
            font-size: 28px;
        }
        .installer-header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        .installer-body {
            padding: 30px;
        }
        .step {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
        }
        .step.success {
            border-left-color: #28a745;
            background: #d4edda;
        }
        .step.error {
            border-left-color: #dc3545;
            background: #f8d7da;
        }
        .step-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .step-detail {
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin-top: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            transition: transform 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .credentials {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            font-family: monospace;
        }
        .success-icon {
            color: #28a745;
            font-size: 48px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class='installer-container'>
        <div class='installer-header'>
            <h1>🚀 Installer Portofolio Database</h1>
            <p>Setup database untuk aplikasi portofolio</p>
        </div>
        <div class='installer-body'>";

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'portofolio_db';

$steps = [];
$allSuccess = true;

// Step 1: Koneksi ke MySQL
echo "<div class='step'>";
echo "<div class='step-title'>Step 1: Koneksi ke MySQL Server</div>";

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<div class='step-detail'>✅ Berhasil terhubung ke MySQL server</div>";
    $steps[] = ['status' => 'success', 'message' => 'Koneksi MySQL berhasil'];
} catch(PDOException $e) {
    echo "<div class='step-detail'>❌ Gagal terhubung: " . $e->getMessage() . "</div>";
    $steps[] = ['status' => 'error', 'message' => 'Koneksi MySQL gagal'];
    $allSuccess = false;
}
echo "</div>";

if($allSuccess) {
    // Step 2: Hapus database lama jika ada
    echo "<div class='step'>";
    echo "<div class='step-title'>Step 2: Persiapan Database</div>";
    try {
        $pdo->exec("DROP DATABASE IF EXISTS `$database`");
        echo "<div class='step-detail'>✅ Database lama berhasil dihapus (jika ada)</div>";
        $steps[] = ['status' => 'success', 'message' => 'Database lama dihapus'];
    } catch(PDOException $e) {
        echo "<div class='step-detail'>⚠️ " . $e->getMessage() . "</div>";
        $steps[] = ['status' => 'warning', 'message' => 'Database lama tidak ditemukan'];
    }
    echo "</div>";
    
    // Step 3: Buat database baru
    echo "<div class='step'>";
    echo "<div class='step-title'>Step 3: Membuat Database Baru</div>";
    try {
        $pdo->exec("CREATE DATABASE `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "<div class='step-detail'>✅ Database '$database' berhasil dibuat</div>";
        $steps[] = ['status' => 'success', 'message' => 'Database berhasil dibuat'];
    } catch(PDOException $e) {
        echo "<div class='step-detail'>❌ Gagal membuat database: " . $e->getMessage() . "</div>";
        $steps[] = ['status' => 'error', 'message' => 'Gagal membuat database'];
        $allSuccess = false;
    }
    echo "</div>";
    
    if($allSuccess) {
        // Step 4: Gunakan database
        echo "<div class='step'>";
        echo "<div class='step-title'>Step 4: Menggunakan Database</div>";
        try {
            $pdo->exec("USE `$database`");
            echo "<div class='step-detail'>✅ Sekarang menggunakan database '$database'</div>";
            $steps[] = ['status' => 'success', 'message' => 'Database aktif'];
        } catch(PDOException $e) {
            echo "<div class='step-detail'>❌ " . $e->getMessage() . "</div>";
            $allSuccess = false;
        }
        echo "</div>";
        
        // Step 5: Buat tabel users
        echo "<div class='step'>";
        echo "<div class='step-title'>Step 5: Membuat Tabel Users</div>";
        try {
            $sql = "CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                name VARCHAR(100) NOT NULL,
                role ENUM('admin', 'user') DEFAULT 'user',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $pdo->exec($sql);
            echo "<div class='step-detail'>✅ Tabel 'users' berhasil dibuat</div>";
            $steps[] = ['status' => 'success', 'message' => 'Tabel users dibuat'];
        } catch(PDOException $e) {
            echo "<div class='step-detail'>⚠️ " . $e->getMessage() . "</div>";
            $steps[] = ['status' => 'warning', 'message' => 'Tabel users mungkin sudah ada'];
        }
        echo "</div>";
        
        // Step 6: Buat tabel level
        echo "<div class='step'>";
        echo "<div class='step-title'>Step 6: Membuat Tabel Level Pendidikan</div>";
        try {
            $sql = "CREATE TABLE level (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nama VARCHAR(50) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $pdo->exec($sql);
            echo "<div class='step-detail'>✅ Tabel 'level' berhasil dibuat</div>";
            $steps[] = ['status' => 'success', 'message' => 'Tabel level dibuat'];
        } catch(PDOException $e) {
            echo "<div class='step-detail'>⚠️ " . $e->getMessage() . "</div>";
        }
        echo "</div>";
        
        // Step 7: Buat tabel studies
        echo "<div class='step'>";
        echo "<div class='step-title'>Step 7: Membuat Tabel Studies (Riwayat Pendidikan)</div>";
        try {
            $sql = "CREATE TABLE studies (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nama VARCHAR(100) NOT NULL,
                idlevel INT NOT NULL,
                keterangan TEXT,
                tahun_lulus YEAR,
                foto_sekolah VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (idlevel) REFERENCES level(id) ON DELETE CASCADE
            )";
            $pdo->exec($sql);
            echo "<div class='step-detail'>✅ Tabel 'studies' berhasil dibuat</div>";
            $steps[] = ['status' => 'success', 'message' => 'Tabel studies dibuat'];
        } catch(PDOException $e) {
            echo "<div class='step-detail'>⚠️ " . $e->getMessage() . "</div>";
        }
        echo "</div>";
        
        // Step 8: Insert data users
        echo "<div class='step'>";
        echo "<div class='step-title'>Step 8: Menambahkan Data Users</div>";
        try {
            $adminPass = password_hash('admin123', PASSWORD_DEFAULT);
            $userPass = password_hash('user123', PASSWORD_DEFAULT);
            
            $pdo->exec("DELETE FROM users");
            $sql = "INSERT INTO users (username, password, name, role) VALUES 
                ('admin', '$adminPass', 'Administrator', 'admin'),
                ('user', '$userPass', 'User Biasa', 'user')";
            $pdo->exec($sql);
            echo "<div class='step-detail'>✅ 2 user berhasil ditambahkan (admin, user)</div>";
            $steps[] = ['status' => 'success', 'message' => 'Data users ditambahkan'];
        } catch(PDOException $e) {
            echo "<div class='step-detail'>⚠️ " . $e->getMessage() . "</div>";
        }
        echo "</div>";
        
        // Step 9: Insert data level
        echo "<div class='step'>";
        echo "<div class='step-title'>Step 9: Menambahkan Data Level Pendidikan</div>";
        try {
            $pdo->exec("DELETE FROM level");
            $levels = [
                '🎓 TK (Taman Kanak-Kanak)',
                '📚 SD (Sekolah Dasar)',
                '🏫 SMP (Sekolah Menengah Pertama)',
                '🎯 SMA/SMK (Sekolah Menengah Atas)',
                '🎓 D3 (Diploma)',
                '🎓 S1 (Sarjana)',
                '🎓 S2 (Magister)',
                '🎓 S3 (Doktor)'
            ];
            
            foreach($levels as $level) {
                $stmt = $pdo->prepare("INSERT INTO level (nama) VALUES (?)");
                $stmt->execute([$level]);
            }
            echo "<div class='step-detail'>✅ 8 level pendidikan berhasil ditambahkan</div>";
            $steps[] = ['status' => 'success', 'message' => 'Data level ditambahkan'];
        } catch(PDOException $e) {
            echo "<div class='step-detail'>⚠️ " . $e->getMessage() . "</div>";
        }
        echo "</div>";
        
        // Step 10: Insert sample studies
        echo "<div class='step'>";
        echo "<div class='step-title'>Step 10: Menambahkan Sample Data Pendidikan</div>";
        try {
            $pdo->exec("DELETE FROM studies");
            $samples = [
                [1, 'TK Islam Terpadu Al-Falah', 1, 'TK favorit dengan program bilingual dan kegiatan seni', 2010],
                [2, 'SD Negeri Cendekia', 2, 'Sekolah dasar unggulan dengan akreditasi A', 2016],
                [3, 'SMP Negeri 1 Model', 3, 'Sekolah menengah pertama dengan program akselerasi', 2019],
                [4, 'SMK Teknologi Informasi', 4, 'Jurusan Rekayasa Perangkat Lunak', 2022],
                [5, 'Universitas Teknologi Digital', 6, 'Program Studi Teknik Informatika, cumlaude', 2026]
            ];
            
            $sql = "INSERT INTO studies (id, nama, idlevel, keterangan, tahun_lulus) VALUES (?, ?, ?, ?, ?)";
            foreach($samples as $sample) {
                $stmt = $pdo->prepare($sql);
                $stmt->execute($sample);
            }
            echo "<div class='step-detail'>✅ 5 sample data pendidikan berhasil ditambahkan</div>";
            $steps[] = ['status' => 'success', 'message' => 'Sample data ditambahkan'];
        } catch(PDOException $e) {
            echo "<div class='step-detail'>⚠️ " . $e->getMessage() . "</div>";
        }
        echo "</div>";
    }
}

// Tampilkan hasil akhir
echo "<div style='text-align: center; margin-top: 20px;'>";

if($allSuccess) {
    echo "<div class='success-icon'>✅</div>";
    echo "<h3 style='color: #28a745;'>INSTALLASI BERHASIL!</h3>";
    echo "<p>Database dan semua tabel telah berhasil dibuat.</p>";
    
    echo "<div class='credentials'>";
    echo "<strong>📋 Informasi Login:</strong><br>";
    echo "🔑 Username: <strong>admin</strong><br>";
    echo "🔑 Password: <strong>admin123</strong><br>";
    echo "🔑 Atau:<br>";
    echo "🔑 Username: <strong>user</strong><br>";
    echo "🔑 Password: <strong>user123</strong><br>";
    echo "</div>";
    
    echo "<a href='index.php' class='btn'>🚀 Buka Website</a>";
} else {
    echo "<div class='success-icon'>❌</div>";
    echo "<h3 style='color: #dc3545;'>INSTALLASI GAGAL!</h3>";
    echo "<p>Silakan cek konfigurasi MySQL Anda.</p>";
    echo "<p>Pastikan XAMPP sudah running (Apache & MySQL).</p>";
    echo "<button onclick='location.reload()' class='btn'>🔄 Coba Lagi</button>";
}

echo "</div>";

?>
        </div>
    </div>
</body>
</html>