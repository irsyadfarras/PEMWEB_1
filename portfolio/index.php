<?php
require_once 'config/database.php';

// Get page parameter
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Pages that don't require login
$public_pages = ['home', 'about', 'contact', 'login'];

// Halaman yang hanya untuk ADMIN
$admin_only_pages = ['users'];

// Check authentication for protected pages
if (!in_array($page, $public_pages) && !isLoggedIn()) {
    redirect('index.php?page=login');
}

// Check admin access
if (in_array($page, $admin_only_pages) && !isAdmin()) {
    echo "<script>alert('Akses ditolak! Halaman ini hanya untuk Administrator.'); window.location.href='index.php?page=home';</script>";
    exit();
}

include 'views/header.php';
include 'views/menu.php';
?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-3">
            <?php include 'views/sidebar.php'; ?>
        </div>
        <div class="col-md-9">
            <?php
            // Handle parameter detail, edit, hapus
            if(isset($_GET['detail'])) {
                // Tampilkan modal detail via JavaScript
                echo "<script>
                    // Simpan ID ke session storage
                    sessionStorage.setItem('detail_id', '".$_GET['detail']."');
                    // Redirect ke studies tanpa parameter
                    window.location.href = '?page=studies';
                </script>";
                exit();
            }
            
            if(isset($_GET['edit']) && isAdmin()) {
                // Tampilkan modal edit via JavaScript
                echo "<script>
                    sessionStorage.setItem('edit_id', '".$_GET['edit']."');
                    window.location.href = '?page=studies';
                </script>";
                exit();
            }
            
            switch($page) {
                case 'home':
                    include 'views/home.php';
                    break;
                case 'about':
                    include 'views/about.php';
                    break;
                case 'contact':
                    include 'views/contact.php';
                    break;
                case 'level':
                    include 'views/level.php';
                    break;
                case 'studies':
                    include 'views/studies.php';
                    break;
                case 'users':
                    include 'views/users.php';
                    break;
                default:
                    include 'views/home.php';
            }
            ?>
        </div>
    </div>
</div>

<?php include 'views/footer.php'; ?>