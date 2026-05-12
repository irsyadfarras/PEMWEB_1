<footer class="bg-dark text-white mt-5 pt-4 pb-3">
    <div class="container">
        <div class="alert alert-info text-center mb-3 shadow-sm" role="alert" data-aos="fade-up">
            <i class="fas fa-heart text-danger me-2 fa-pulse"></i>
            <strong>© 2026 MyPortfolio</strong> - Built with Bootstrap 5 | 
            Last Updated: <?php echo date('F j, Y, g:i a'); ?>
            <i class="fas fa-code ms-2"></i>
        </div>
        <div class="text-center text-muted small">
            <p class="mb-0">Made with <i class="fas fa-coffee text-warning"></i> and <i class="fas fa-music text-primary"></i></p>
        </div>
    </div>
</footer>

<!-- ✅ Urutan benar: jQuery dulu → Bootstrap → AOS → custom script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="assets/js/script.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });
</script>
</body>
</html>