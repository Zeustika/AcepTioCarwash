<?php
    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
?>

<div class="container" style="margin-top: 3rem; margin-bottom: 4rem;">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="font-weight-bold mb-2" style="color: #1a1a1a; letter-spacing: -0.02em; font-size: 2.5rem;">
                <i class="fa fa-phone" style="color: #C9A961; margin-right: 15px;"></i>
                Hubungi Kami
            </h1>
            <p class="text-muted mb-0" style="font-size: 16px; max-width: 600px; margin: 0 auto;">
                Kami siap membantu Anda kapan saja. Jangan ragu untuk menghubungi kami melalui informasi kontak di bawah ini.
            </p>
            <div class="premium-line" style="max-width: 200px; margin: 1.5rem auto;"></div>
        </div>
    </div>

    <div class="row">
        <!-- Contact Info Card -->
        <div class="col-lg-5 mb-4">
            <div class="card" style="border: 1px solid #e0e0e0; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); height: 100%;">
                <div class="card-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-bottom: 3px solid #C9A961; padding: 2rem; border-radius: 16px 16px 0 0;">
                    <h4 class="mb-2" style="color: #fff; font-weight: 700;">
                        <i class="fa fa-building-o mr-2" style="color: #C9A961;"></i>
                        <?= $info_web->nama_rental; ?>
                    </h4>
                    <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 14px;">
                        Layanan Rental Mobil Terpercaya
                    </p>
                </div>
                
                <div class="card-body" style="padding: 2rem;">
                    <!-- Phone -->
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="icon-wrapper" style="width: 50px; height: 50px; background: linear-gradient(135deg, #C9A961, #B8985A); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; flex-shrink: 0;">
                                <i class="fa fa-phone" style="color: #fff; font-size: 20px;"></i>
                            </div>
                            <div style="flex: 1;">
                                <label style="color: #666; font-size: 13px; font-weight: 600; margin-bottom: 0.25rem; display: block;">
                                    Telepon
                                </label>
                                <a href="tel:<?= $info_web->telp; ?>" style="color: #1a1a1a; font-size: 16px; font-weight: 600; text-decoration: none;">
                                    <?= $info_web->telp; ?>
                                </a>
                                <small class="d-block text-muted" style="font-size: 12px; margin-top: 0.25rem;">
                                    Senin - Sabtu, 08:00 - 20:00
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="icon-wrapper" style="width: 50px; height: 50px; background: linear-gradient(135deg, #007bff, #0056b3); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; flex-shrink: 0;">
                                <i class="fa fa-envelope" style="color: #fff; font-size: 20px;"></i>
                            </div>
                            <div style="flex: 1;">
                                <label style="color: #666; font-size: 13px; font-weight: 600; margin-bottom: 0.25rem; display: block;">
                                    Email
                                </label>
                                <a href="mailto:<?= $info_web->email; ?>" style="color: #1a1a1a; font-size: 16px; font-weight: 600; text-decoration: none; word-break: break-all;">
                                    <?= $info_web->email; ?>
                                </a>
                                <small class="d-block text-muted" style="font-size: 12px; margin-top: 0.25rem;">
                                    Kirim email kapan saja
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="icon-wrapper" style="width: 50px; height: 50px; background: linear-gradient(135deg, #28a745, #20c997); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; flex-shrink: 0;">
                                <i class="fa fa-map-marker" style="color: #fff; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1;">
                                <label style="color: #666; font-size: 13px; font-weight: 600; margin-bottom: 0.25rem; display: block;">
                                    Alamat
                                </label>
                                <p style="color: #1a1a1a; font-size: 15px; font-weight: 500; margin-bottom: 0.5rem; line-height: 1.6;">
                                    <?= $info_web->alamat; ?>
                                </p>
                                <a href="https://maps.google.com/?q=<?= urlencode($info_web->alamat); ?>" 
                                   target="_blank"
                                   class="btn btn-sm btn-outline-success" 
                                   style="font-size: 12px; padding: 0.4rem 0.8rem; border-width: 2px; font-weight: 600;">
                                    <i class="fa fa-map-o mr-1"></i>
                                    Lihat di Maps
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Account -->
                    <div class="contact-item">
                        <div class="d-flex align-items-start">
                            <div class="icon-wrapper" style="width: 50px; height: 50px; background: linear-gradient(135deg, #dc3545, #c82333); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; flex-shrink: 0;">
                                <i class="fa fa-credit-card" style="color: #fff; font-size: 20px;"></i>
                            </div>
                            <div style="flex: 1;">
                                <label style="color: #666; font-size: 13px; font-weight: 600; margin-bottom: 0.25rem; display: block;">
                                    Rekening Bank
                                </label>
                                <p style="color: #1a1a1a; font-size: 15px; font-weight: 600; margin-bottom: 0; line-height: 1.6; white-space: pre-line;">
                                    <?= $info_web->no_rek; ?>
                                </p>
                                <small class="d-block text-muted" style="font-size: 12px; margin-top: 0.5rem;">
                                    <i class="fa fa-info-circle mr-1"></i>
                                    Untuk pembayaran booking
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media Footer -->
                <div class="card-footer" style="background: #fafafa; border-top: 1px solid #e0e0e0; padding: 1.5rem; border-radius: 0 0 16px 16px;">
                    <h6 class="mb-3 font-weight-bold" style="color: #1a1a1a; font-size: 14px;">
                        <i class="fa fa-share-alt mr-2" style="color: #C9A961;"></i>
                        Ikuti Kami
                    </h6>
                    <div class="d-flex gap-2" style="gap: 0.75rem;">
                        <a href="#" class="btn btn-sm" style="width: 40px; height: 40px; border-radius: 50%; background: #25D366; color: #fff; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
                            <i class="fa fa-whatsapp" style="font-size: 18px;"></i>
                        </a>
                        <a href="#" class="btn btn-sm" style="width: 40px; height: 40px; border-radius: 50%; background: #1877F2; color: #fff; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
                            <i class="fa fa-facebook" style="font-size: 18px;"></i>
                        </a>
                        <a href="#" class="btn btn-sm" style="width: 40px; height: 40px; border-radius: 50%; background: #E4405F; color: #fff; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
                            <i class="fa fa-instagram" style="font-size: 18px;"></i>
                        </a>
                        <a href="#" class="btn btn-sm" style="width: 40px; height: 40px; border-radius: 50%; background: #1DA1F2; color: #fff; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
                            <i class="fa fa-twitter" style="font-size: 18px;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form & Map -->
        <div class="col-lg-7 mb-4">
            <!-- Contact Form -->
            <div class="card mb-4" style="border: 1px solid #e0e0e0; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #C9A961, #B8985A); border-bottom: none; padding: 1.5rem; border-radius: 16px 16px 0 0;">
                    <h5 class="mb-1" style="color: #fff; font-weight: 700;">
                        <i class="fa fa-envelope-o mr-2"></i>
                        Kirim Pesan
                    </h5>
                    <p class="mb-0" style="color: rgba(255,255,255,0.9); font-size: 13px;">
                        Ada pertanyaan? Silakan hubungi kami
                    </p>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <form action="#" method="post" id="contactForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" style="font-weight: 600; color: #1a1a1a; font-size: 14px; margin-bottom: 0.5rem;">
                                    <i class="fa fa-user mr-2" style="color: #C9A961;"></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       placeholder="Masukkan nama Anda" 
                                       required
                                       style="padding: 0.75rem 1rem; border: 2px solid #e0e0e0; border-radius: 8px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" style="font-weight: 600; color: #1a1a1a; font-size: 14px; margin-bottom: 0.5rem;">
                                    <i class="fa fa-envelope mr-2" style="color: #C9A961;"></i>
                                    Email
                                </label>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       placeholder="email@example.com" 
                                       required
                                       style="padding: 0.75rem 1rem; border: 2px solid #e0e0e0; border-radius: 8px;">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" style="font-weight: 600; color: #1a1a1a; font-size: 14px; margin-bottom: 0.5rem;">
                                <i class="fa fa-phone mr-2" style="color: #C9A961;"></i>
                                Nomor Telepon
                            </label>
                            <input type="tel" 
                                   class="form-control" 
                                   id="phone" 
                                   placeholder="08xx xxxx xxxx" 
                                   required
                                   style="padding: 0.75rem 1rem; border: 2px solid #e0e0e0; border-radius: 8px;">
                        </div>
                        <div class="mb-3">
                            <label for="subject" style="font-weight: 600; color: #1a1a1a; font-size: 14px; margin-bottom: 0.5rem;">
                                <i class="fa fa-tag mr-2" style="color: #C9A961;"></i>
                                Subjek
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="subject" 
                                   placeholder="Tentang apa pesan Anda?" 
                                   required
                                   style="padding: 0.75rem 1rem; border: 2px solid #e0e0e0; border-radius: 8px;">
                        </div>
                        <div class="mb-4">
                            <label for="message" style="font-weight: 600; color: #1a1a1a; font-size: 14px; margin-bottom: 0.5rem;">
                                <i class="fa fa-comment mr-2" style="color: #C9A961;"></i>
                                Pesan
                            </label>
                            <textarea class="form-control" 
                                      id="message" 
                                      rows="5" 
                                      placeholder="Tulis pesan Anda di sini..." 
                                      required
                                      style="padding: 0.75rem 1rem; border: 2px solid #e0e0e0; border-radius: 8px;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" style="padding: 0.875rem; font-weight: 700; font-size: 15px; border-radius: 8px;">
                            <i class="fa fa-paper-plane mr-2"></i>
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Map Card -->
            <div class="card" style="border: 1px solid #e0e0e0; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); overflow: hidden;">
                <div class="card-header" style="background: #1a1a1a; border-bottom: 2px solid #C9A961; padding: 1rem 1.5rem;">
                    <h5 class="mb-0" style="color: #fff; font-weight: 700; font-size: 16px;">
                        <i class="fa fa-map-marker mr-2" style="color: #C9A961;"></i>
                        Lokasi Kami
                    </h5>
                </div>
                <div style="width: 100%; height: 350px; background: #f0f0f0; position: relative;">
                    <!-- Placeholder Map - Replace with actual Google Maps embed -->
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4909.484789750214!2d108.24033068503725!3d-7.4168084539353245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e65f7f30d2fad85%3A0x4734eceb27403af2!2sCAR%20WASH%20ACEP%20TIO!5e1!3m2!1sid!2sid!4v1763423374859!5m2!1sid!2sid"
                        width="100%" 
                        height="350" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Contact Buttons -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, rgba(201, 169, 97, 0.1), rgba(201, 169, 97, 0.05)); border-radius: 16px;">
                <div class="card-body text-center" style="padding: 2.5rem;">
                    <h4 class="mb-3 font-weight-bold" style="color: #1a1a1a;">
                        Butuh Bantuan Segera?
                    </h4>
                    <p class="mb-4 text-muted" style="font-size: 15px; max-width: 600px; margin: 0 auto 2rem;">
                        Tim customer service kami siap membantu Anda 24/7. Pilih cara komunikasi yang paling nyaman untuk Anda.
                    </p>
                    <div class="d-flex justify-content-center gap-3" style="gap: 1rem; flex-wrap: wrap;">
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $info_web->telp); ?>" 
                           class="btn btn-success btn-lg" 
                           style="padding: 0.875rem 2rem; font-weight: 700; border-radius: 50px;">
                            <i class="fa fa-whatsapp mr-2" style="font-size: 20px;"></i>
                            WhatsApp
                        </a>
                        <a href="tel:<?= $info_web->telp; ?>" 
                           class="btn btn-primary btn-lg" 
                           style="padding: 0.875rem 2rem; font-weight: 700; border-radius: 50px;">
                            <i class="fa fa-phone mr-2"></i>
                            Telepon Sekarang
                        </a>
                        <a href="mailto:<?= $info_web->email; ?>" 
                           class="btn btn-outline-primary btn-lg" 
                           style="padding: 0.875rem 2rem; font-weight: 700; border-radius: 50px; border-width: 2px;">
                            <i class="fa fa-envelope mr-2"></i>
                            Email Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form Submit Handler
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i> Mengirim...';
    submitBtn.disabled = true;
    
    // Simulate form submission (replace with actual AJAX call)
    setTimeout(function() {
        alert('Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
        document.getElementById('contactForm').reset();
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 2000);
});

// Phone number formatting
document.getElementById('phone').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

// Form input focus animation
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function() {
        this.style.borderColor = '#C9A961';
        this.style.boxShadow = '0 0 0 0.2rem rgba(201, 169, 97, 0.15)';
    });
    
    input.addEventListener('blur', function() {
        this.style.borderColor = '#e0e0e0';
        this.style.boxShadow = 'none';
    });
});
</script>

<style>
/* Contact Item Hover Effect */
.contact-item {
    transition: all 0.3s ease;
    padding: 0.5rem;
    border-radius: 12px;
}


.contact-item:hover {
    background: rgba(201, 169, 97, 0.05);
    transform: translateX(5px);
}

/* Icon Wrapper Hover */
.icon-wrapper {
    transition: all 0.3s ease;
}

.btn-outline-primary{
    background-color: #d3d3d3 !important;
}

.contact-item:hover .icon-wrapper {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Social Media Button Hover */
.card-footer a:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

/* Form Control Enhancement */
.form-control {
    transition: all 0.3s ease;
}

.form-control:hover {
    border-color: #C9A961;
}

/* Button Hover Effects */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Card Hover */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-3px);
}

/* Animation */
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

.contact-item {
    animation: fadeInUp 0.6s ease;
}

.contact-item:nth-child(1) { animation-delay: 0.1s; }
.contact-item:nth-child(2) { animation-delay: 0.2s; }
.contact-item:nth-child(3) { animation-delay: 0.3s; }
.contact-item:nth-child(4) { animation-delay: 0.4s; }

/* Responsive */
@media (max-width: 768px) {
    .d-flex.gap-3 {
        flex-direction: column;
    }
    
    .btn-lg {
        width: 100%;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
    
    .contact-item:hover {
        transform: none;
    }
}
</style>

<?php include 'footer.php'; ?>