<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'Daftar Booking';
    include '../header.php';
    if(empty($_SESSION['USER']))
    {
        session_start();
    }
    if(!empty($_GET['id'])){
        $id = strip_tags($_GET['id']);
        $sql = "SELECT mobil.merk, booking.* FROM booking JOIN mobil ON 
                booking.id_mobil=mobil.id_mobil WHERE id_login = '$id' ORDER BY id_booking DESC";
    }else{
        $sql = "SELECT mobil.merk, booking.* FROM booking JOIN mobil ON 
                booking.id_mobil=mobil.id_mobil ORDER BY id_booking DESC";
    }
    $hasil = $koneksi->query($sql)->fetchAll();
?>

<div class="container" style="margin-top: 3rem; margin-bottom: 3rem;">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="font-weight-bold" style="color: #1a1a1a; letter-spacing: -0.02em;">
                <i class="fa fa-calendar-check-o" style="color: #C9A961; margin-right: 10px;"></i>
                Daftar Booking
            </h2>
            <div class="premium-line"></div>
        </div>
    </div>

    <!-- Booking Table Card -->
    <div class="card admin-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fa fa-list-alt mr-2"></i>
                    Semua Booking
                </h5>
                <span class="badge badge-light" style="background: rgba(201, 169, 97, 0.2); color: #C9A961; padding: 0.5rem 1rem; font-size: 13px;">
                    Total: <?= count($hasil); ?> Booking
                </span>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php if(count($hasil) > 0): ?>
            <div class="table-responsive">
                <table class="table table-admin table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 12%;">Kode Booking</th>
                            <th style="width: 15%;">Type jasa</th>
                            <th style="width: 15%;">Nama Penyewa</th>
                            <th style="width: 12%;">Tanggal Sewa</th>
                            <th style="width: 10%;">Paket Penyewaan</th>
                            <th style="width: 13%;">Total Harga</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 8%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($hasil as $isi): ?>
                        <tr>
                            <td class="font-weight-bold" style="color: #666;"><?= $no; ?></td>
                            <td>
                                <span class="badge badge-dark" style="font-size: 12px; padding: 0.4rem 0.8rem; font-weight: 500;">
                                    <?= $isi['kode_booking']; ?>
                                </span>
                            </td>
                            <td class="font-weight-bold" style="color: #1a1a1a;">
                                <i class="fa fa-wrench   mr-1" style="color: #C9A961;"></i>
                                <?= $isi['merk']; ?>
                            </td>
                            <td>
                                <i class="fa fa-user mr-1" style="color: #999; font-size: 12px;"></i>
                                <?= $isi['nama']; ?>
                            </td>
                            <td>
                                <i class="fa fa-calendar mr-1" style="color: #999; font-size: 12px;"></i>
                                <?= date('d/m/Y', strtotime($isi['tanggal'])); ?>
                            </td>
                            <td>
                                <span style="color: #1a1a1a; font-weight: 500;">
                                    <?= $isi['lama_sewa']; ?> 
                                    <small style="color: #999;">paket</small>
                                </span>
                            </td>
                            <td class="font-weight-bold" style="color: #C9A961;">
                                Rp <?= number_format($isi['total_harga'], 0, ',', '.'); ?>
                            </td>
                            <td>
                                <?php 
                                $status = strtolower($isi['konfirmasi_pembayaran']);
                                if($status == 'sudah dikonfirmasi'): 
                                ?>
                                    <span class="badge badge-success" style="padding: 0.4rem 0.8rem; font-size: 11px;">
                                        <i class="fa fa-check-circle mr-1"></i>
                                        Dikonfirmasi
                                    </span>
                                <?php elseif($status == 'sedang diproses'): ?>
                                    <span class="badge badge-warning text-dark" style="padding: 0.4rem 0.8rem; font-size: 11px;">
                                        <i class="fa fa-clock-o mr-1"></i>
                                        Diproses
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-secondary" style="padding: 0.4rem 0.8rem; font-size: 11px;">
                                        <i class="fa fa-hourglass-half mr-1"></i>
                                        Menunggu
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="bayar.php?id=<?= $isi['kode_booking']; ?>" 
                                   class="btn btn-sm btn-admin-view" 
                                   title="Lihat Detail">
                                    <i class="fa fa-eye mr-1"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="fa fa-inbox text-muted" style="font-size: 4rem; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                <h5 class="text-muted">Belum Ada Booking</h5>
                <p class="text-muted mb-0">Data booking akan muncul di sini</p>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if(count($hasil) > 0): ?>
        <div class="card-footer" style="background: #fafafa; border-top: 1px solid #f0f0f0; padding: 1rem 1.5rem;">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="fa fa-info-circle mr-1"></i>
                    Menampilkan <?= count($hasil); ?> data booking
                </small>
                <div>
                    <button class="btn btn-sm btn-outline-primary" onclick="window.print();">
                        <i class="fa fa-print mr-1"></i>
                        Cetak
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="exportTableToExcel();">
                        <i class="fa fa-file-excel-o mr-1"></i>
                        Export Excel
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Info Cards -->
    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 8px;">
                <div class="card-body text-black">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" 
                             style="width: 50px; height: 50px; background: rgba(201, 169, 97, 0.2);">
                            <i class="fa fa-calendar-check-o" style="color: #C9A961; font-size: 24px;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 font-weight-bold"><?= count($hasil); ?></h3>
                            <small style="opacity: 0.8;">Total Booking</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card border-0" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 8px;">
                <div class="card-body text-black">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" 
                        style="width: 50px; height: 50px; background: rgba(201, 169, 97, 0.2);">
                            <i class="fa fa-check-circle" style="color: #C9A961; font-size: 24px;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 font-weight-bold">
                                <?php 
                                $konfirmasi = array_filter($hasil, function($item) {
                                    return strtolower($item['konfirmasi_pembayaran']) == 'sudah dikonfirmasi';
                                });
                                echo count($konfirmasi);
                                ?>
                            </h3>
                            <small style="opacity: 0.8;">Dikonfirmasi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card border-0" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 8px;">
                <div class="card-body text-black">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" 
                        style="width: 50px; height: 50px; background: rgba(201, 169, 97, 0.2);">
                            <i class="fa fa-clock-o" style="color: #C9A961; font-size: 24px;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 font-weight-bold">
                                <?php 
                                $pending = array_filter($hasil, function($item) {
                                    return strtolower($item['konfirmasi_pembayaran']) != 'sudah dikonfirmasi';
                                });
                                echo count($pending);
                                ?>
                            </h3>
                            <small style="opacity: 0.8;">Menunggu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function exportTableToExcel() {
    alert('Fitur export Excel akan segera tersedia!');
    // Implementasi export Excel bisa ditambahkan di sini
}
</script>

<style>
@media print {
    .card-footer,
    .btn,
    .navbar,
    .jumbotron,
    .footer,
    .copyright {
        display: none !important;
    }
    
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
    
    .card-header {
        background: #f8f9fa !important;
        color: #000 !important;
    }
}
h3{
    color: #000 !important;
}
@media (max-width: 768px) {
    .table-admin {
        font-size: 12px;
    }
    
    .btn-sm {
        font-size: 11px;
        padding: 0.3rem 0.6rem;
    }
    
    .badge {
        font-size: 10px !important;
    }
}
</style>

<?php include '../footer.php'; ?>