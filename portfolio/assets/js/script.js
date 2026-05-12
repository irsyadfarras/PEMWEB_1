$(document).ready(function() {

    // ================================================================
    // Auto-hide alerts
    // ================================================================
    setTimeout(function() {
        $('.alert').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 5000);

    // ================================================================
    // Add active class to nav items
    // ================================================================
    var currentUrl = window.location.href;
    $('.navbar-nav .nav-link').each(function() {
        if(currentUrl.indexOf($(this).attr('href')) !== -1) {
            $(this).addClass('active');
        }
    });

    // ================================================================
    // Smooth scroll - HANYA untuk anchor link biasa, 
    // JANGAN intercept link yang punya data-bs-toggle (modal, dropdown, dll)
    // ================================================================
    $('a[href*="#"]:not([href="#"]):not([data-bs-toggle]):not([data-bs-dismiss])').on('click', function(e) {
        if(this.hash !== '') {
            e.preventDefault();
            const hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 70
            }, 800);
        }
    });

    // ================================================================
    // Tooltip initialization
    // ================================================================
    $('[data-bs-toggle="tooltip"]').tooltip();

    // ================================================================
    // Back to top button
    // ================================================================
    $('body').append('<button id="backToTop" class="btn btn-primary rounded-circle" style="position: fixed; bottom: 80px; right: 30px; display: none; z-index: 999;"><i class="fas fa-arrow-up"></i></button>');

    $(window).scroll(function() {
        if($(this).scrollTop() > 100) {
            $('#backToTop').fadeIn();
        } else {
            $('#backToTop').fadeOut();
        }
    });

    $('#backToTop').on('click', function() {
        $('html, body').animate({scrollTop: 0}, 500);
    });

    // ================================================================
    // Form validation - FIX UTAMA:
    // Hanya validasi form yang DI LUAR modal Bootstrap,
    // atau yang punya class khusus .needs-validation.
    // Jangan intercept form di dalam .modal karena Bootstrap
    // sudah handle sendiri, dan select kosong di awal
    // menyebabkan false-positive yang memblokir submit.
    // ================================================================
    $('form.needs-validation').on('submit', function(e) {
        let isValid = true;
        $(this).find('[required]').each(function() {
            if($(this).val() === '') {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        if(!isValid) {
            e.preventDefault();
            alert('Harap isi semua field yang diperlukan!');
        }
    });

    // Reset is-invalid saat user mulai mengisi field
    $(document).on('input change', '.is-invalid', function() {
        if($(this).val() !== '') {
            $(this).removeClass('is-invalid');
        }
    });

    // ================================================================
    // Image preview for file upload
    // ================================================================
    $(document).on('change', 'input[type="file"]', function(e) {
        const file = e.target.files[0];
        if(file && (file.type === 'image/jpeg' || file.type === 'image/png')) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                $(e.target).closest('.modal-body, .card-body').find('.image-preview').remove();
                $(e.target).after('<div class="image-preview mt-2"><img src="' + ev.target.result + '" style="max-width: 200px; border-radius: 10px;"></div>');
            };
            reader.readAsDataURL(file);
        }
    });

    // ================================================================
    // Reset modal content saat modal ditutup
    // (supaya image preview tidak nyangkut di modal berikutnya)
    // ================================================================
    $(document).on('hidden.bs.modal', '.modal', function() {
        $(this).find('.image-preview').remove();
        $(this).find('.is-invalid').removeClass('is-invalid');
    });

});