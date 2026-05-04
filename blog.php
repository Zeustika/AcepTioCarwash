<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

if (isset($_GET['cari']) && $_GET['cari'] != '') {
    $cari = strip_tags($_GET['cari']);
    $query = $koneksi->query('SELECT * FROM mobil WHERE merk LIKE "%' . $cari . '%" ORDER BY id_mobil DESC')->fetchAll();
} else {
    $query = $koneksi->query('SELECT * FROM mobil ORDER BY id_mobil DESC')->fetchAll();
}
?>

<div class="container py-5">
    <!-- Section Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <?php if (!empty($_GET['cari'])) { ?>
                <h3 class="fw-bold mb-2">Hasil Pencarian: <span class="text-primary">"<?= $cari; ?>"</span></h3>
            <?php } else { ?>
                <h3 class="fw-bold mb-2">Daftar Layanan Cuci Mobil</h3>
            <?php } ?>
            <p class="text-muted mb-0">Pilih layanan cuci mobil terbaik untuk membuat kendaraan Anda selalu bersih, wangi, dan mengkilap</p>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <i class="fa fa-phone text-primary fs-3 me-3"></i>
                    <div>
                        <h6 class="mb-1 fw-semibold">Butuh bantuan?</h6>
                        <p class="small mb-0">Hubungi kami di <strong><?= $info_web->telp; ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Layanan -->
    <div class="row g-4">
        <?php 
        if (count($query) > 0) {
            foreach ($query as $isi) { ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden rounded-3">
                        <div class="position-relative">
                            <img src="assets/image/<?= $isi['gambar']; ?>" 
                                 class="card-img-top" style="height:220px;object-fit:cover;">
                            <span class="position-absolute top-0 start-0 m-2 badge bg-<?= $isi['status']=='Tersedia' ? 'success' : 'secondary'; ?>">
                                <?= $isi['status']=='Tersedia' ? 'Tersedia' : 'Penuh'; ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="fw-semibold mb-2 text-dark"><?= $isi['merk']; ?></h5>
                            <p class="text-muted small mb-3">Layanan perawatan dan cuci mobil berkualitas tinggi</p>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <small class="text-muted d-block">Harga per layanan</small>
                                    <h6 class="fw-bold text-primary mb-0">Rp <?= number_format($isi['harga']); ?></h6>
                                </div>
                                <div class="text-warning">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                </div>
                            </div>

                            <ul class="list-unstyled small text-muted mb-4">
                                <li><i class="fa fa-check-circle text-success me-1"></i> Cuci Eksterior & Interior</li>
                                <li><i class="fa fa-check-circle text-success me-1"></i> Vakum & Pewangi Gratis</li>
                                <li><i class="fa fa-check-circle text-success me-1"></i> Poles Body & Ban</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="d-flex gap-2">
                                <a href="detail.php?id=<?= $isi['id_mobil']; ?>" class="btn btn-outline-primary flex-fill">
                                    <i class="fa fa-info-circle me-1"></i> Detail
                                </a>
                                <?php if ($isi['status'] == 'Tersedia') { ?>
                                    <a href="booking.php?id=<?= $isi['id_mobil']; ?>" class="btn btn-primary flex-fill">
                                        <i class="fa fa-calendar-check-o me-1"></i> Pesan
                                    </a>
                                <?php } else { ?>
                                    <button class="btn btn-secondary flex-fill" disabled>
                                        <i class="fa fa-ban me-1"></i> Tidak Tersedia
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }
        } else { ?>
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="fa fa-wrench fa-3x mb-3 text-primary"></i>
                    <h5>Tidak ada layanan ditemukan</h5>
                    <p class="mb-0 text-muted">Silakan coba dengan kata kunci lain atau lihat semua layanan yang tersedia.</p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Keunggulan -->
<section class="py-5 bg-light border-top mt-5">
    <div class="container">
        <div class="text-center mb-5">
            <h4 class="fw-bold">Mengapa Pilih <span class="text-primary">Tio Carwash</span>?</h4>
            <p class="text-muted">Kami menghadirkan pengalaman mencuci mobil yang cepat, bersih, dan profesional</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center p-4 bg-white shadow-sm rounded-3 h-100">
                    <i class="fa fa-shield fa-3x text-primary mb-3"></i>
                    <h6 class="fw-semibold">Jaminan Keamanan</h6>
                    <p class="small text-muted mb-0">Peralatan modern dan tim profesional menjamin keamanan mobil Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4 bg-white shadow-sm rounded-3 h-100">
                    <i class="fa fa-money fa-3x text-primary mb-3"></i>
                    <h6 class="fw-semibold">Harga Transparan</h6>
                    <p class="small text-muted mb-0">Nikmati layanan premium dengan harga yang jujur dan kompetitif.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4 bg-white shadow-sm rounded-3 h-100">
                    <i class="fa fa-headphones fa-3x text-primary mb-3"></i>
                    <h6 class="fw-semibold">Layanan 24/7</h6>
                    <p class="small text-muted mb-0">Tim kami siap membantu dan menerima booking kapan pun Anda butuh.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
