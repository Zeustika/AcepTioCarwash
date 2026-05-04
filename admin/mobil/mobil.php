<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'Daftar Mobil';
    include '../header.php';
    if(empty($_SESSION['USER']))
    {
        session_start();
    }
?>

<div class="container" style="margin-top: 3rem; margin-bottom: 3rem;">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="font-weight-bold mb-1" style="color: #1a1a1a; letter-spacing: -0.02em;">
                        <i class="fa fa-wrench" style="color: #C9A961; margin-right: 10px;"></i>
                        Daftar Jasa
                    </h2>
                    <p class="text-muted mb-0" style="font-size: 14px;">Kelola semua data</p>
                </div>
                <a href="tambah.php" class="btn btn-primary">
                    <i class="fa fa-plus-circle mr-2"></i>
                    Tambah Jasa Baru
                </a>
            </div>
            <div class="premium-line"></div>
        </div>
    </div>

    <!-- Car List Card -->
    <div class="card admin-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fa fa-list mr-2"></i>
                    Semua Jasa
                </h5>
                <?php
                    $sql = "SELECT *FROM mobil ORDER BY id_mobil ASC";
                    $row = $koneksi->prepare($sql);
                    $row->execute();
                    $hasil = $row->fetchAll();
                    $total_mobil = count($hasil);
                    
                    // Hitung mobil berdasarkan status
                    $tersedia = 0;
                    $disewa = 0;
                    foreach($hasil as $item) {
                        if(strtolower($item['status']) == 'tersedia') {
                            $tersedia++;
                        } else {
                            $disewa++;
                        }
                    }
                ?>
                <span class="badge badge-light" style="background: rgba(201, 169, 97, 0.2); color: #C9A961; padding: 0.5rem 1rem; font-size: 13px;">
                    <i class="fa fa-wrench mr-1"></i>
                    Total: <?= $total_mobil; ?> Unit
                </span>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php if($total_mobil > 0): ?>
            <div class="table-responsive">
                <table class="table table-admin table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 15%;">Gambar</th>
                            <th style="width: 18%;">Type Jasa</th>
                            <th style="width: 0%;"></th>
                            <th style="width: 13%;">Harga</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 20%;">Deskripsi</th>
                            <th style="width: 12%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            foreach($hasil as $isi):
                        ?>
                        <tr>
                            <td class="font-weight-bold" style="color: #666;"><?= $no; ?></td>
                            <td>
                                <div style="position: relative; overflow: hidden; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <img src="../../assets/image/<?= $isi['gambar']; ?>" 
                                         class="img-fluid" 
                                         style="width: 100%; height: 80px; object-fit: cover; transition: transform 0.3s ease;"
                                         onmouseover="this.style.transform='scale(1.05)'"
                                         onmouseout="this.style.transform='scale(1)'"
                                         alt="<?= $isi['merk']; ?>">
                                </div>
                            </td>
                            <td class="font-weight-bold" style="color: #1a1a1a;">
                                <i class="fa fa-wrench mr-2" style="color: #C9A961; font-size: 14px;"></i>
                                <?= $isi['merk']; ?>
                            </td>
                            <td>
                                <span class="badge badge-dark" style="font-size: 12px; padding: 0.4rem 0.8rem; font-weight: 500; letter-spacing: 0.5px;">
                                    <?= $isi['no_plat']; ?>
                                </span>
                            </td>
                            <td class="font-weight-bold" style="color: #C9A961; font-size: 15px;">
                                Rp <?= number_format($isi['harga'], 0, ',', '.'); ?>
                                <small class="d-block text-muted" style="font-size: 11px; font-weight: 400;">per hari</small>
                            </td>
                            <td>
                                <?php if(strtolower($isi['status']) == 'tersedia'): ?>
                                    <span class="badge badge-success" style="padding: 0.5rem 0.9rem; font-size: 11px; font-weight: 500;">
                                        <i class="fa fa-check-circle mr-1"></i>
                                        Tersedia
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-danger" style="padding: 0.5rem 0.9rem; font-size: 11px; font-weight: 500;">
                                        <i class="fa fa-times-circle mr-1"></i>
                                        Disewa
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <p class="mb-0" style="font-size: 13px; color: #666; line-height: 1.5;">
                                    <?php 
                                    $deskripsi = $isi['deskripsi'];
                                    echo strlen($deskripsi) > 60 ? substr($deskripsi, 0, 60) . '...' : $deskripsi;
                                    ?>
                                </p>
                            </td>
                            <td style="text-align: center;">
                                <div class="btn-group" role="group">
                                    <a href="edit.php?id=<?= $isi['id_mobil']; ?>" 
                                       class="btn btn-sm btn-admin-edit" 
                                       title="Edit Mobil">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="proses.php?aksi=hapus&id=<?= $isi['id_mobil']; ?>&gambar=<?= $isi['gambar']; ?>" 
                                       class="btn btn-sm btn-admin-delete" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus mobil <?= $isi['merk']; ?>?')"
                                       title="Hapus Mobil">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="fa fa-wrench text-muted" style="font-size: 4rem; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                <h5 class="text-muted">Belum Ada Mobil</h5>
                <p class="text-muted mb-3">Mulai tambahkan mobil rental Anda</p>
                <a href="tambah.php" class="btn btn-primary">
                    <i class="fa fa-plus-circle mr-2"></i>
                    Tambah Mobil Pertama
                </a>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if($total_mobil > 0): ?>
        <div class="card-footer" style="background: #fafafa; border-top: 1px solid #f0f0f0; padding: 1rem 1.5rem;">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="fa fa-info-circle mr-1"></i>
                    Menampilkan <?= $total_mobil; ?> unit mobil
                </small>
                <div>
                    <button class="btn btn-sm btn-outline-primary" onclick="window.print();">
                        <i class="fa fa-print mr-1"></i>
                        Cetak
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 8px;">
                <div class="card-body text-black">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" 
                             style="width: 50px; height: 50px; background: rgba(201, 169, 97, 0.2);">
                            <i class="fa fa-wrench" style="color: #C9A961; font-size: 24px;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 font-weight-bold"><?= $total_mobil; ?></h3>
                            <small style="opacity: 0.8; color: #000">Total Jasa</small>
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
                            <h3 class="mb-0 font-weight-bold"><?= $tersedia; ?></h3>
                            <small style="opacity: 0.8;">Jasa Tersedia</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Hover effect untuk tombol aksi */
.btn-group .btn {
    margin: 0 2px;
}

h3 {
    color: #000000;
}

.btn-admin-edit:hover i,
.btn-admin-delete:hover i {
    animation: bounceIcon 0.5s ease;
}

@keyframes bounceIcon {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

/* Image hover effect */
.table-admin tbody tr:hover img {
    transform: scale(1.05);
}

/* Print styles */
@media print {
    .btn,
    .card-footer,
    .navbar,
    .jumbotron,
    .footer,
    .copyright,
    .row.mt-4 {
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
    
    .table-admin thead {
        background: #f8f9fa !important;
        color: #000 !important;
    }
}

/* Mobile responsive */
@media (max-width: 768px) {
    .table-admin {
        font-size: 11px;
    }
    
    .table-admin img {
        height: 60px !important;
    }
    
    .btn-group .btn {
        padding: 0.3rem 0.5rem;
        font-size: 11px;
    }
    
    .badge {
        font-size: 10px !important;
        padding: 0.3rem 0.6rem !important;
    }
    
    h2 {
        font-size: 1.5rem;
    }
    

    .card-body p {
        font-size: 12px !important;
    }
}

@media (max-width: 576px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .d-flex.justify-content-between .btn {
        margin-top: 1rem;
        width: 100%;
    }
}
</style>

<?php include '../footer.php'; ?>