<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio | <?php echo ucfirst($_GET['page'] ?? 'Home'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Hero Carousel Section (12 Grid) -->
    <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="carousel-bg" style="background: linear-gradient(135deg, #153f3cff 0%, #10e8ef 100%); height: 500px;"></div>
                <div class="carousel-caption d-flex flex-column justify-content-center h-100">
                    <h1 class="display-3 fw-bold animate__animated animate__fadeInDown">Welcome to My Portfolio</h1>
                    <p class="lead fs-3 animate__animated animate__fadeInUp">Creative Developer & UI/UX Enthusiast</p>
                    <div class="mt-3 animate__animated animate__fadeInUp">
                        <a href="index.php?page=contact" class="btn btn-light btn-lg me-2">
                            <i class="fas fa-envelope me-2"></i>Contact Me
                        </a>
                        <a href="index.php?page=about" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-user me-2"></i>About Me
                        </a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-bg" style="background: linear-gradient(135deg, #0ef6cfff 0%, #023b44ff 100%); height: 500px;"></div>
                <div class="carousel-caption d-flex flex-column justify-content-center h-100">
                    <h1 class="display-3 fw-bold">Full Stack Developer</h1>
                    <p class="lead fs-3">Building amazing web experiences</p>
                    <div class="mt-3">
                        <i class="fab fa-php fa-2x mx-2"></i>
                        <i class="fab fa-laravel fa-2x mx-2"></i>
                        <i class="fab fa-js fa-2x mx-2"></i>
                        <i class="fab fa-react fa-2x mx-2"></i>
                        <i class="fab fa-node fa-2x mx-2"></i>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-bg" style="background: linear-gradient(135deg, #0ca7ef 0%, #02393cff 100%); height: 500px;"></div>
                <div class="carousel-caption d-flex flex-column justify-content-center h-100">
                    <h1 class="display-3 fw-bold">Let's Work Together</h1>
                    <p class="lead fs-3">Creating digital masterpieces that inspire</p>
                    <div class="mt-3">
                        <span class="badge bg-light text-dark fs-6 mx-1 p-2">50+ Projects</span>
                        <span class="badge bg-light text-dark fs-6 mx-1 p-2">30+ Clients</span>
                        <span class="badge bg-light text-dark fs-6 mx-1 p-2">5+ Years Exp</span>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>