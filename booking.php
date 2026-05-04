<?php
    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
    if(empty($_SESSION['USER']))
    {
        echo '<script>alert("Harap login !");window.location="index.php"</script>';
    }
    $id = $_GET['id'];
    $isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();
    
    $is_available = strtolower($isi['status']) == 'tersedia';
?>

<div class="container" style="margin-top: 3rem; margin-bottom: 3rem;">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background: transparent; padding: 0;">
                    <li class="breadcrumb-item">
                        <a href="index.php" style="color: #666; text-decoration: none; font-size: 14px;">
                            <i class="fa fa-home mr-1"></i>Home
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="blog.php" style="color: #666; text-decoration: none; font-size: 14px;">
                            Jasa
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: #C9A961; font-size: 14px; font-weight: 500;">
                        Booking
                    </li>
                </ol>
            </nav>
            <h2 class="font-weight-bold mb-1" style="color: #1a1a1a; letter-spacing: -0.02em;">
                <i class="fa fa-calendar-check-o" style="color: #C9A961; margin-right: 10px;"></i>
                Booking
            </h2>
            <p class="text-muted mb-0" style="font-size: 15px;">
                Lengkapi formulir di bawah ini untuk melakukan pemesanan
            </p>
            <div class="premium-line"></div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Car Info -->
        <div class="col-lg-4 mb-4">
            <div class="card" style="border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                <!-- Car Image -->
                <div style="position: relative; overflow: hidden;">
                    <img src="assets/image/<?= $isi['gambar']; ?>" 
                         class="card-img-top" 
                         style="width: 100%; height: 280px; object-fit: cover; transition: transform 0.4s ease;"
                         onmouseover="this.style.transform='scale(1.05)'"
                         onmouseout="this.style.transform='scale(1)'"
                         alt="<?= $isi['merk']; ?>">
                    
                    <!-- Status Badge on Image -->
                    <?php if($is_available): ?>
                    <div style="position: absolute; top: 15px; right: 15px; background: #28a745; color: #fff; padding: 0.5rem 1rem; border-radius: 50px; font-weight: 600; font-size: 13px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                        <i class="fa fa-check-circle mr-1"></i>
                        Available
                    </div>
                    <?php else: ?>
                    <div style="position: absolute; top: 15px; right: 15px; background: #dc3545; color: #fff; padding: 0.5rem 1rem; border-radius: 50px; font-weight: 600; font-size: 13px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                        <i class="fa fa-times-circle mr-1"></i>
                        Not Available
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Car Details -->
                <div class="card-body" style="padding: 1.5rem;">
                    <h4 class="card-title mb-3" style="color: #1a1a1a; font-weight: 700; font-size: 1.5rem;">
                        <?= $isi['merk']; ?>
                    </h4>
                    
                    <?php if(!empty($isi['deskripsi'])): ?>
                    <p class="text-muted mb-3" style="font-size: 14px; line-height: 1.6;">
                        <?= $isi['deskripsi']; ?>
                    </p>
                    <?php endif; ?>
                </div>

                <!-- Features List -->
                <ul class="list-group list-group-flush">
                    <!-- Availability Status -->
                    <?php if($is_available): ?>
                    <li class="list-group-item" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: #fff; border: none; padding: 1rem 1.5rem; font-weight: 600;">
                        <i class="fa fa-check-circle mr-2" style="font-size: 16px;"></i>
                        Mobil Tersedia - Siap Disewa
                    </li>
                    <?php else: ?>
                    <li class="list-group-item" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: #fff; border: none; padding: 1rem 1.5rem; font-weight: 600;">
                        <i class="fa fa-times-circle mr-2" style="font-size: 16px;"></i>
                        Mobil Tidak Tersedia
                    </li>
                    <?php endif; ?>
                    
                    <!-- Features -->
                    <li class="list-group-item" style="background: rgba(201, 169, 97, 0.1); border: none; padding: 1rem 1.5rem;">
                        <i class="fa fa-gift mr-2" style="color: #C9A961; font-size: 16px;"></i>
                        <strong style="color: #1a1a1a;">Bonus:</strong> 
                        <span style="color: #666;">Free Wheel Polish</span>
                    </li>
                    
                    <!-- Price -->
                    <li class="list-group-item" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: #fff; border: none; padding: 1.5rem;">
                        <div class="text-center">
                            <small style="opacity: 0.8; font-size: 13px; display: block; margin-bottom: 0.5rem;">
                                Harga
                            </small>
                            <div style="font-size: 2rem; font-weight: 700; color: #C9A961; line-height: 1;">
                                Rp <?= number_format($isi['harga'], 0, ',', '.'); ?>
                            </div>
                        </div>
                    </li>
                </ul>

                <!-- Info Footer -->
                <div class="card-footer" style="background: #fafafa; border-top: 1px solid #e0e0e0; padding: 1rem 1.5rem;">
                    <small class="text-muted" style="font-size: 12px;">
                        <i class="fa fa-info-circle mr-1"></i>
                        *Syarat dan ketentuan berlaku
                    </small>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card mt-4" style="background: rgba(201, 169, 97, 0.05); border: 1px solid rgba(201, 169, 97, 0.3); border-radius: 8px;">
                <div class="card-body" style="padding: 1.25rem;">
                    <h6 class="font-weight-bold mb-2" style="color: #1a1a1a;">
                        <i class="fa fa-question-circle mr-2" style="color: #C9A961;"></i>
                        Butuh Bantuan?
                    </h6>
                    <p class="mb-2" style="font-size: 13px; color: #666;">
                        Hubungi customer service kami untuk informasi lebih lanjut
                    </p>
                    <a href="https://wa.me/6281234567890" class="btn btn-success btn-sm btn-block" style="font-weight: 600;">
                        <i class="fa fa-whatsapp mr-2"></i>
                        Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column - Booking Form -->
        <div class="col-lg-8 mb-4">
            <div class="card" style="border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-bottom: 3px solid #C9A961; padding: 1.5rem; border-radius: 12px 12px 0 0;">
                    <h4 class="mb-1" style="color: #fff; font-weight: 700;">
                        <i class="fa fa-edit mr-2" style="color: #C9A961;"></i>
                        Formulir Booking
                    </h4>
                    <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 14px;">
                        Isi data dengan lengkap dan benar
                    </p>
                </div>
                
                <div class="card-body" style="padding: 2.5rem;">
                    <?php if(!$is_available): ?>
                    <div class="alert alert-danger" style="border-radius: 8px; border-left: 4px solid #dc3545;">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-exclamation-triangle mr-3" style="font-size: 24px;"></i>
                            <div>
                                <h6 class="mb-1 font-weight-bold">Mobil Tidak Tersedia</h6>
                                <p class="mb-0" style="font-size: 14px;">
                                    Maaf, mobil ini sedang tidak tersedia untuk disewa. Silakan pilih mobil lain atau hubungi kami untuk informasi ketersediaan.
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <form method="post" action="koneksi/proses.php?id=booking" id="bookingForm">
                        <!-- Personal Information Section -->
                        <div class="form-section mb-4">
                            <h5 class="mb-3" style="color: #1a1a1a; font-weight: 700; border-bottom: 2px solid #f0f0f0; padding-bottom: 0.75rem;">
                                <i class="fa fa-user-circle mr-2" style="color: #C9A961;"></i>
                                Data Pribadi
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ktp" class="form-label" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                        <i class="fa fa-id-card mr-2" style="color: #C9A961;"></i>
                                        Nomor KTP / NIK <span style="color: #dc3545;">*</span>
                                    </label>
                                    <input type="text" 
                                           name="ktp" 
                                           id="ktp" 
                                           required 
                                           class="form-control" 
                                           placeholder="Masukkan nomor KTP/NIK"
                                           maxlength="16"
                                           pattern="[0-9]{16}"
                                           style="padding: 0.75rem 1rem; font-size: 15px;">
                                    <small class="form-text text-muted">
                                        <i class="fa fa-info-circle mr-1"></i>
                                        16 digit nomor identitas
                                    </small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                        <i class="fa fa-user mr-2" style="color: #C9A961;"></i>
                                        Nama Lengkap <span style="color: #dc3545;">*</span>
                                    </label>
                                    <input type="text" 
                                           name="nama" 
                                           id="nama" 
                                           required 
                                           class="form-control" 
                                           placeholder="Masukkan nama lengkap"
                                           style="padding: 0.75rem 1rem; font-size: 15px;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="no_tlp" class="form-label" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                        <i class="fa fa-phone mr-2" style="color: #C9A961;"></i>
                                        Nomor Telepon <span style="color: #dc3545;">*</span>
                                    </label>
                                    <input type="tel" 
                                           name="no_tlp" 
                                           id="no_tlp" 
                                           required 
                                           class="form-control" 
                                           placeholder="08xx xxxx xxxx"
                                           pattern="[0-9]{10,13}"
                                           style="padding: 0.75rem 1rem; font-size: 15px;">
                                    <small class="form-text text-muted">
                                        <i class="fa fa-info-circle mr-1"></i>
                                        Format: 08xxxxxxxxxx
                                    </small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="alamat" class="form-label" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                        <i class="fa fa-map-marker mr-2" style="color: #C9A961;"></i>
                                        Alamat <span style="color: #dc3545;">*</span>
                                    </label>
                                    <input type="text" 
                                           name="alamat" 
                                           id="alamat" 
                                           required 
                                           class="form-control" 
                                           placeholder="Masukkan alamat lengkap"
                                           style="padding: 0.75rem 1rem; font-size: 15px;">
                                </div>
                            </div>
                        </div>

                        <!-- Rental Information Section -->
                        <div class="form-section mb-4">
                            <h5 class="mb-3" style="color: #1a1a1a; font-weight: 700; border-bottom: 2px solid #f0f0f0; padding-bottom: 0.75rem;">
                                <i class="fa fa-calendar-check-o mr-2" style="color: #C9A961;"></i>
                                Detail Jasa
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal" class="form-label" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                        <i class="fa fa-calendar mr-2" style="color: #C9A961;"></i>
                                        Tanggal Datang <span style="color: #dc3545;">*</span>
                                    </label>
                                    <input type="date" 
                                           name="tanggal" 
                                           id="tanggal" 
                                           required 
                                           class="form-control" 
                                           min="<?= date('Y-m-d'); ?>"
                                           style="padding: 0.75rem 1rem; font-size: 15px;">
                                    <small class="form-text text-muted">
                                        <i class="fa fa-info-circle mr-1"></i>
                                        Pilih tanggal datang kendaraan
                                    </small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="lama_sewa" class="form-label" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                        <i class="fa fa-clock-o mr-2" style="color: #C9A961;"></i>
                                        Lama Penitipan <span style="color: #dc3545;">*</span>
                                    </label>
                                    <input type="number" 
                                           name="lama_sewa" 
                                           id="lama_sewa" 
                                           required 
                                           class="form-control" 
                                           placeholder="Contoh: 1"
                                           min="0"
                                           max="7"
                                           style="padding: 0.75rem 1rem; font-size: 15px;"
                                           onkeyup="calculateTotal()">
                                    <small class="form-text text-muted">
                                        <i class="fa fa-info-circle mr-1"></i>
                                        Bisa dibawa langsung(0), maksimal 7 hari
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Price Summary -->
                        <div class="price-summary" style="background: linear-gradient(135deg, rgba(201, 169, 97, 0.1), rgba(201, 169, 97, 0.05)); border: 2px solid #C9A961; border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem;">
                            <h5 class="mb-3" style="color: #1a1a1a; font-weight: 700;">
                                <i class="fa fa-calculator mr-2" style="color: #C9A961;"></i>
                                Ringkasan Biaya
                            </h5>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span style="color: #666; font-size: 15px;">Harga per Hari</span>
                                <span style="color: #1a1a1a; font-weight: 600; font-size: 16px;">
                                    Rp <?= number_format($isi['harga'], 0, ',', '.'); ?>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span style="color: #666; font-size: 15px;">Lama Sewa</span>
                                <span style="color: #1a1a1a; font-weight: 600; font-size: 16px;">
                                    <span id="display_lama_sewa">0</span> Hari
                                </span>
                            </div>
                            <hr style="border-top: 2px dashed #C9A961; margin: 1rem 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #1a1a1a; font-weight: 700; font-size: 17px;">Total Pembayaran</span>
                                <span style="color: #C9A961; font-weight: 700; font-size: 24px;">
                                    Rp <span id="total_display">0</span>
                                </span>
                            </div>
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" value="<?= $_SESSION['USER']['id_login']; ?>" name="id_login">
                        <input type="hidden" value="<?= $isi['id_mobil']; ?>" name="id_mobil">
                        <input type="hidden" value="<?= $isi['harga']; ?>" name="total_harga" id="total_harga">

                        <!-- Terms & Conditions -->
                        <div class="form-check mb-4" style="padding-left: 1.75rem;">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="terms" 
                                   required
                                   style="width: 18px; height: 18px; margin-top: 0.15rem; cursor: pointer;">
                            <label class="form-check-label" for="terms" style="color: #666; font-size: 14px; cursor: pointer;">
                                Saya menyetujui <a href="#" style="color: #C9A961; font-weight: 600;">syarat dan ketentuan</a> yang berlaku
                            </label>
                        </div>

                        <div class="premium-line"></div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="blog.php" class="btn btn-outline-secondary" style="padding: 0.75rem 1.5rem; font-weight: 600;">
                                <i class="fa fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                            <?php if($is_available): ?>
                            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem; font-weight: 700; font-size: 16px;">
                                <i class="fa fa-check-circle mr-2"></i>
                                Booking Sekarang
                            </button>
                            <?php else: ?>
                            <button type="button" class="btn btn-danger" disabled style="padding: 0.75rem 2.5rem; font-weight: 700; font-size: 16px;">
                                <i class="fa fa-times-circle mr-2"></i>
                                Tidak Tersedia
                            </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Calculate Total Price
function calculateTotal() {
    const hargaPerHari = <?= $isi['harga']; ?>;
    const lamaSewa = document.getElementById('lama_sewa').value || 0;
    const total = hargaPerHari * lamaSewa;
    
    document.getElementById('display_lama_sewa').textContent = lamaSewa;
    document.getElementById('total_display').textContent = total.toLocaleString('id-ID');
    document.getElementById('total_harga').value = total;
}

// Form Validation & Submit
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const lamaSewa = document.getElementById('lama_sewa').value;
    
    if(lamaSewa < 1 || lamaSewa > 30) {
        e.preventDefault();
        alert('Lama sewa harus antara 1-30 hari');
        return false;
    }
    
    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i> Memproses Booking...';
    submitBtn.disabled = true;
});

// KTP Validation (only numbers)
document.getElementById('ktp').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

// Phone Validation (only numbers)
document.getElementById('no_tlp').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

// Set minimum date to today
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal').setAttribute('min', today);
});
</script>

<style>
/* Form Enhancement */
.form-control:focus {
    border-color: #C9A961;
    box-shadow: 0 0 0 0.2rem rgba(201, 169, 97, 0.15);
}

.form-control {
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.form-control:hover {
    border-color: #C9A961;
}

/* Form Check */
.form-check-input:checked {
    background-color: #C9A961;
    border-color: #C9A961;
}

/* Button Hover Effects */
.btn {
    transition: all 0.3s ease;
    border-radius: 8px;
}

.btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Price Summary Animation */
.price-summary {
    animation: slideUp 0.5s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Alert Enhancement */
.alert {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Responsive */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem !important;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn {
        width: 100%;
    }
    
    .price-summary {
        padding: 1rem !important;
    }
}
</style>

<?php include 'footer.php';?>