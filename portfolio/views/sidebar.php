<div class="list-group shadow-sm rounded-3 mb-4" data-aos="fade-right">
    <div class="list-group-item bg-gradient-primary text-white border-0 rounded-top">
        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Quick Navigation</h5>
    </div>
    <a href="index.php?page=home" class="list-group-item list-group-item-action">
        <i class="fas fa-home me-2 text-primary"></i>Dashboard
    </a>
    <a href="index.php?page=about" class="list-group-item list-group-item-action">
        <i class="fas fa-user me-2 text-info"></i>About Me
    </a>
    <a href="index.php?page=contact" class="list-group-item list-group-item-action">
        <i class="fas fa-envelope me-2 text-success"></i>Contact
    </a>
    <?php if(isLoggedIn()): ?>
    <a href="index.php?page=level" class="list-group-item list-group-item-action">
        <i class="fas fa-layer-group me-2 text-warning"></i>Levels
    </a>
    <a href="index.php?page=studies" class="list-group-item list-group-item-action">
        <i class="fas fa-graduation-cap me-2 text-danger"></i> Studies
    </a>
    <?php endif; ?>
</div>

<div class="list-group shadow-sm rounded-3" data-aos="fade-right" data-aos-delay="100">
    <div class="list-group-item bg-gradient-success text-white border-0 rounded-top">
        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Statistics</h5>
    </div>
    <div class="list-group-item">
        <i class="fas fa-calendar-alt me-2 text-primary"></i>
        Member Since: <strong>2026</strong>
    </div>
    <div class="list-group-item">
        <i class="fas fa-project-diagram me-2 text-success"></i>
        Projects: <strong>50+</strong>
    </div>
    <div class="list-group-item">
        <i class="fas fa-users me-2 text-info"></i>
        Clients: <strong>30+</strong>
    </div>
    <div class="list-group-item">
        <i class="fas fa-trophy me-2 text-warning"></i>
        Awards: <strong>5</strong>
    </div>
</div>

<div class="list-group shadow-sm rounded-3 mt-4" data-aos="fade-right" data-aos-delay="200">
    <div class="list-group-item bg-gradient-danger text-white border-0 rounded-top">
        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Skills</h5>
    </div>
    <div class="list-group-item">
        <span class="badge bg-primary m-1">PHP</span>
        <span class="badge bg-danger m-1">JavaScript</span>
        <span class="badge bg-success m-1">MySQL</span>
        <span class="badge bg-info m-1">Bootstrap</span>
        <span class="badge bg-warning m-1">Laravel</span>
    </div>
</div>