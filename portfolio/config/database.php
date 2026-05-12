<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$dbname = 'portofolio_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Fungsi cek login
if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}

// Fungsi cek admin
if (!function_exists('isAdmin')) {
    function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
}

// Fungsi redirect
if (!function_exists('redirect')) {
    function redirect($url) {
        header("Location: $url");
        exit();
    }
}

// Fungsi untuk upload file
if (!function_exists('uploadFile')) {
    function uploadFile($file, $targetDir) {
        if(!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $fileName = time() . '_' . uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $targetFile = $targetDir . $fileName;
        
        if(move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $fileName;
        }
        return null;
    }
}
?>