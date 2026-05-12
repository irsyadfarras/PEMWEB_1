<?php
require_once 'config/database.php';

if(isLoggedIn()) {
    redirect('index.php');
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if(empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi!';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            redirect('index.php');
        } else {
            $error = 'Username atau password salah!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portofolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #012039ff 0%, #08c0f9ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            animation: fadeInUp 0.6s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .login-header {
            background: linear-gradient(135deg, #08b6f0ff 0%, #032842ff 100%);
            padding: 30px;
            text-align: center;
        }
        .login-body {
            padding: 40px;
            background: white;
        }
        .btn-login {
            background: linear-gradient(135deg, #09a4e6ff 0%, #032a4cff 100%);
            border: none;
            padding: 12px;
            font-weight: bold;
            transition: transform 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(19, 52, 54, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <div class="login-header">
                        <i class="fas fa-user-circle fa-4x text-white"></i>
                        <h3 class="text-white mt-3">Welcome Back!</h3>
                        <p class="text-white-50">Silakan login untuk melanjutkan</p>
                    </div>
                    <div class="login-body">
                        <?php if($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user me-2"></i>Username
                                </label>
                                <input type="text" name="username" class="form-control form-control-lg" 
                                       placeholder="Masukkan username" required autofocus>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <input type="password" name="password" class="form-control form-control-lg" 
                                       placeholder="Masukkan password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-login w-100 btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </form>
                        <hr class="my-4">
                        <div class="text-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Demo: admin / admin123
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>