<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'Konfirmasi';
    include '../header.php';
    session_start();
    if(empty($_SESSION['USER']))
    {
        echo '<script>alert("login dulu");window.location="index.php"</script>';
    }
    $kode_booking = $_GET['id'];
    $hasil = $koneksi->query("SELECT * FROM booking WHERE kode_booking = '$kode_booking'")->fetch();

    $id_booking = $hasil['id_booking'];
    $hsl = $koneksi->query("SELECT * FROM pembayaran WHERE id_booking = '$id_booking'")->fetch();
    $c = $koneksi->query("SELECT * FROM pembayaran WHERE id_booking = '$id_booking'")->rowCount();

    $id = $hasil['id_mobil'];
    $isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();
?>

<div class="container" style="margin-top: 2rem; margin-bottom: 3rem;">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="font-weight-bold mb-1" style="color: #1a1a1a; letter-spacing: -0.02em;">
                        <i class="fa fa-check-square-o" style="color: #C9A961; margin-right: 10px;"></i>
                        Konfirmasi Pembayaran
                    </h2>
                    <p class="text-muted mb-0" style="font-size: 14px;">
                        <a href="<?php echo $url;?>admin/booking/booking.php" style="color: #666; text-decoration: none;">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Daftar Booking
                        </a>
                    </p>
                </div>
                <div>
                    <span class="badge badge-dark" style="padding: 0.75rem 1.25rem; font-size: 14px;">
                        <i class="fa fa-barcode mr-2"></i>
                        <?= $kode_booking; ?>
                    </span>
                </div>
            </div>
            <div class="premium-line"></div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Payment Details & Car Info -->
        <div class="col-lg-4 mb-4">
            <!-- Payment Details Card -->
            <div class="card admin-card mb-4">
                <div class="card-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-bottom: 2px solid #C9A961;">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0" style="color: #fff; font-weight: 600;">
                            <i class="fa fa-credit-card mr-2"></i>
                            Detail Pembayaran
                        </h5>
                        <?php if($c > 0): ?>
                        <span class="badge badge-success" style="font-size: 11px;">
                            <i class="fa fa-check-circle mr-1"></i>
                            Terbayar
                        </span>
                        <?php else: ?>
                        <span class="badge badge-warning" style="font-size: 11px;">
                            <i class="fa fa-clock-o mr-1"></i>
                            Pending
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    <?php if($c > 0): ?>
                    <div class="payment-info">
                        <div class="info-item mb-3">
                            <label style="color: #666; font-size: 13px; font-weight: 500; margin-bottom: 0.25rem;">
                                <i class="fa fa-bank mr-2" style="color: #C9A961;"></i>
                                No Rekening
                            </label>
                            <div style="color: #1a1a1a; font-size: 15px; font-weight: 600;">
                                <?= $hsl['no_rekening']; ?>
                            </div>
                        </div>
                        
                        <div class="info-item mb-3">
                            <label style="color: #666; font-size: 13px; font-weight: 500; margin-bottom: 0.25rem;">
                                <i class="fa fa-user mr-2" style="color: #C9A961;"></i>
                                Atas Nama
                            </label>
                            <div style="color: #1a1a1a; font-size: 15px; font-weight: 600;">
                                <?= $hsl['nama_rekening']; ?>
                            </div>
                        </div>
                        
                        <div class="info-item mb-3">
                            <label style="color: #666; font-size: 13px; font-weight: 500; margin-bottom: 0.25rem;">
                                <i class="fa fa-money mr-2" style="color: #C9A961;"></i>
                                Nominal Transfer
                            </label>
                            <div style="color: #C9A961; font-size: 18px; font-weight: 700;">
                                Rp <?= number_format($hsl['nominal'], 0, ',', '.'); ?>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <label style="color: #666; font-size: 13px; font-weight: 500; margin-bottom: 0.25rem;">
                                <i class="fa fa-calendar mr-2" style="color: #C9A961;"></i>
                                Tanggal Transfer
                            </label>
                            <div style="color: #1a1a1a; font-size: 15px; font-weight: 600;">
                                <?= date('d F Y', strtotime($hsl['tanggal'])); ?>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fa fa-exclamation-triangle text-warning" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        <h5 class="mb-2" style="color: #1a1a1a; font-weight: 600;">Belum Ada Pembayaran</h5>
                        <p class="text-muted mb-0" style="font-size: 13px;">
                            Pelanggan belum melakukan konfirmasi pembayaran
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Car Info Card -->
            <div class="card admin-card">
                <div class="card-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-bottom: 2px solid #C9A961;">
                    <h5 class="mb-0" style="color: #fff; font-weight: 600;">
                        <i class="fa fa-wrench mr-2"></i>
                        <?= $isi['merk']; ?>
                    </h5>
                </div>
                
                <!-- Car Image -->
                <?php if(!empty($isi['gambar'])): ?>
                <div style="position: relative; overflow: hidden;">
                    <img src="../../assets/image/<?= $isi['gambar']; ?>" 
                         class="img-fluid" 
                         style="width: 100%; height: 200px; object-fit: cover;"
                         alt="<?= $isi['merk']; ?>">
                </div>
                <?php endif; ?>

                <ul class="list-group list-group-flush">
                    <!-- Status Availability -->
                    <?php if(strtolower($isi['status']) == 'tersedia'): ?>
                    <li class="list-group-item" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: #fff; border: none; padding: 1rem 1.5rem;">
                        <i class="fa fa-check-circle mr-2" style="font-size: 16px;"></i>
                        <strong>Available</strong> - Siap Disewa
                    </li>
                    <?php else: ?>
                    <li class="list-group-item" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: #fff; border: none; padding: 1rem 1.5rem;">
                        <i class="fa fa-times-circle mr-2" style="font-size: 16px;"></i>
                        <strong>Not Available</strong> - Sedang Disewa
                    </li>
                    <?php endif; ?>
                    
                    <!-- Features -->
                    <li class="list-group-item" style="background: rgba(201, 169, 97, 0.1); border: none; padding: 1rem 1.5rem;">
                        <i class="fa fa-gift mr-2" style="color: #C9A961;"></i>
                        <strong>Bonus:</strong> Free E-toll 50k
                    </li>
                    
                    <!-- Price -->
                    <li class="list-group-item" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: #fff; border: none; padding: 1rem 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-money mr-2" style="color: #C9A961;"></i>
                                <strong>Harga Sewa</strong>
                            </span>
                            <span style="color: #C9A961; font-size: 18px; font-weight: 700;">
                                Rp <?= number_format($isi['harga'], 0, ',', '.'); ?>
                                <small style="font-size: 12px; opacity: 0.8;">/hari</small>
                            </span>
                        </div>
                    </li>
                </ul>
                
                <div class="card-footer" style="background: #fafafa; border-top: 1px solid #f0f0f0; padding: 1rem 1.5rem;">
                    <a href="<?= $url; ?>admin/peminjaman/peminjaman.php?id=<?= $hasil['kode_booking']; ?>" 
                       class="btn btn-success btn-block" style="padding: 0.75rem; font-weight: 600;">
                        <i class="fa fa-exchange mr-2"></i>
                        Ubah Status Peminjaman
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column - Booking Details -->
        <div class="col-lg-8 mb-4">
            <div class="card admin-card">
                <div class="card-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-bottom: 2px solid #C9A961;">
                    <h5 class="mb-0" style="color: #fff; font-weight: 600;">
                        <i class="fa fa-file-text mr-2"></i>
                        Detail Booking
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <form method="post" action="proses.php?id=konfirmasi">
                        <!-- Customer Info Section -->
                        <div class="section-header mb-3">
                            <h6 class="font-weight-bold" style="color: #1a1a1a;">
                                <i class="fa fa-user-circle mr-2" style="color: #C9A961;"></i>
                                Informasi Penyewa
                            </h6>
                            <hr style="border-top: 2px solid #f0f0f0; margin-top: 0.5rem;">
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label style="color: #666; font-size: 13px; font-weight: 500;">
                                    <i class="fa fa-id-card mr-2" style="color: #C9A961;"></i>
                                    Nomor KTP
                                </label>
                                <div style="background: #f8f9fa; padding: 0.75rem 1rem; border-radius: 6px; border: 1px solid #e0e0e0;">
                                    <strong style="color: #1a1a1a; font-size: 15px;"><?= $hasil['ktp']; ?></strong>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label style="color: #666; font-size: 13px; font-weight: 500;">
                                    <i class="fa fa-user mr-2" style="color: #C9A961;"></i>
                                    Nama Lengkap
                                </label>
                                <div style="background: #f8f9fa; padding: 0.75rem 1rem; border-radius: 6px; border: 1px solid #e0e0e0;">
                                    <strong style="color: #1a1a1a; font-size: 15px;"><?= $hasil['nama']; ?></strong>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label style="color: #666; font-size: 13px; font-weight: 500;">
                                    <i class="fa fa-phone mr-2" style="color: #C9A961;"></i>
                                    No. Telepon
                                </label>
                                <div style="background: #f8f9fa; padding: 0.75rem 1rem; border-radius: 6px; border: 1px solid #e0e0e0;">
                                    <strong style="color: #1a1a1a; font-size: 15px;"><?= $hasil['no_tlp']; ?></strong>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label style="color: #666; font-size: 13px; font-weight: 500;">
                                    <i class="fa fa-barcode mr-2" style="color: #C9A961;"></i>
                                    Kode Booking
                                </label>
                                <div style="background: #f8f9fa; padding: 0.75rem 1rem; border-radius: 6px; border: 1px solid #e0e0e0;">
                                    <strong style="color: #C9A961; font-size: 15px;"><?= $hasil['kode_booking']; ?></strong>
                                </div>
                            </div>
                        </div>

                        <!-- Rental Info Section -->
                        <div class="section-header mb-3 mt-4">
                            <h6 class="font-weight-bold" style="color: #1a1a1a;">
                                <i class="fa fa-calendar-check-o mr-2" style="color: #C9A961;"></i>
                                Informasi Sewa
                            </h6>
                            <hr style="border-top: 2px solid #f0f0f0; margin-top: 0.5rem;">
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label style="color: #666; font-size: 13px; font-weight: 500;">
                                    <i class="fa fa-calendar mr-2" style="color: #C9A961;"></i>
                                    Tanggal Sewa
                                </label>
                                <div style="background: #f8f9fa; padding: 0.75rem 1rem; border-radius: 6px; border: 1px solid #e0e0e0;">
                                    <strong style="color: #1a1a1a; font-size: 15px;">
                                        <?= date('d F Y', strtotime($hasil['tanggal'])); ?>
                                    </strong>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label style="color: #666; font-size: 13px; font-weight: 500;">
                                    <i class="fa fa-clock-o mr-2" style="color: #C9A961;"></i>
                                    Lama Sewa
                                </label>
                                <div style="background: #f8f9fa; padding: 0.75rem 1rem; border-radius: 6px; border: 1px solid #e0e0e0;">
                                    <strong style="color: #1a1a1a; font-size: 15px;">
                                        <?= $hasil['lama_sewa']; ?> Hari
                                    </strong>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label style="color: #666; font-size: 13px; font-weight: 500;">
                                    <i class="fa fa-money mr-2" style="color: #C9A961;"></i>
                                    Total Harga
                                </label>
                                <div style="background: linear-gradient(135deg, rgba(201, 169, 97, 0.1), rgba(201, 169, 97, 0.05)); padding: 0.75rem 1rem; border-radius: 6px; border: 2px solid #C9A961;">
                                    <strong style="color: #C9A961; font-size: 18px; font-weight: 700;">
                                        Rp <?= number_format($hasil['total_harga'], 0, ',', '.'); ?>
                                    </strong>
                                </div>
                            </div>
                        </div>

                        <!-- Status Section -->
                        <div class="section-header mb-3 mt-4">
                            <h6 class="font-weight-bold" style="color: #1a1a1a;">
                                <i class="fa fa-cog mr-2" style="color: #C9A961;"></i>
                                Konfirmasi Status
                            </h6>
                            <hr style="border-top: 2px solid #f0f0f0; margin-top: 0.5rem;">
                        </div>
                        
                        <div class="form-group">
                            <label for="status" style="color: #666; font-size: 13px; font-weight: 600;">
                                <i class="fa fa-info-circle mr-2" style="color: #C9A961;"></i>
                                Status Konfirmasi Pembayaran
                            </label>
                            <select class="form-control" name="status" id="status" style="padding: 0.75rem 1rem; font-size: 15px; font-weight: 600;">
                                <option value="Sedang di proses" <?php if($hasil['konfirmasi_pembayaran'] == 'Sedang di proses'){echo 'selected';}?>>
                                    🕐 Sedang di proses
                                </option>
                                <option value="Pembayaran di terima" <?php if($hasil['konfirmasi_pembayaran'] == 'Pembayaran di terima'){echo 'selected';}?>>
                                    ✅ Pembayaran di terima
                                </option>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fa fa-lightbulb-o mr-1"></i>
                                Ubah status setelah memverifikasi pembayaran dari pelanggan
                            </small>
                        </div>

                        <input type="hidden" name="id_booking" value="<?= $hasil['id_booking']; ?>">
                        
                        <div class="premium-line"></div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="<?= $url; ?>admin/booking/booking.php" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-weight: 600;">
                                <i class="fa fa-save mr-2"></i>
                                Update Status Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Activity Log Card (Optional) -->
            <div class="card border-0 mt-4" style="background: rgba(201, 169, 97, 0.05); border-left: 4px solid #C9A961 !important;">
                <div class="card-body" style="padding: 1.5rem;">
                    <h6 class="mb-2 font-weight-bold" style="color: #1a1a1a;">
                        <i class="fa fa-info-circle mr-2" style="color: #C9A961;"></i>
                        Informasi Penting
                    </h6>
                    <ul class="mb-0" style="font-size: 13px; color: #666; padding-left: 1.5rem;">
                        <li class="mb-1">Pastikan data pembayaran sudah terverifikasi sebelum mengubah status</li>
                        <li class="mb-1">Status "Pembayaran di terima" akan mengaktifkan proses peminjaman</li>
                        <li class="mb-1">Setelah konfirmasi, lakukan update status peminjaman melalui menu peminjaman</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form Submit Enhancement
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i> Menyimpan...';
    submitBtn.disabled = true;
});

// Status Select Enhancement
document.getElementById('status').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex].text;
    console.log('Status diubah menjadi:', selectedOption);
});
</script>

<style>
/* Info Item Styling */
.info-item {
    padding-bottom: 1rem;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    padding-bottom: 0;
    border-bottom: none;
}

/* Section Header */
.section-header h6 {
    font-size: 15px;
    letter-spacing: -0.01em;
}

/* Form Control Enhancement */
.form-control:focus {
    border-color: #C9A961;
    box-shadow: 0 0 0 0.2rem rgba(201, 169, 97, 0.15);
}

select.form-control {
    cursor: pointer;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23C9A961' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
}

/* Card Hover Effects */
.admin-card {
    transition: all 0.3s ease;
}

.admin-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(201, 169, 97, 0.12);
}

/* List Group Enhancement */
.list-group-item {
    transition: all 0.3s ease;
}

/* Button Hover Effects */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-block {
        width: 100% !important;
    }
    
    .card-body {
        padding: 1.25rem !important;
    }
}
</style>

<?php include '../footer.php'; ?>