<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'User';
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
                        <i class="fa fa-users" style="color: #C9A961; margin-right: 10px;"></i>
                        Daftar User / Pelanggan
                    </h2>
                    <p class="text-muted mb-0" style="font-size: 14px;">Kelola data pelanggan Tio Carwash</p>
                </div>
            </div>
            <div class="premium-line"></div>
        </div>
    </div>

    <!-- User List Card -->
    <div class="card admin-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fa fa-list-ul mr-2"></i>
                    Semua Pelanggan
                </h5>
                <?php 
                    $sql = "SELECT * FROM login WHERE level = 'Pengguna' ORDER BY id_login DESC";
                    $row = $koneksi->prepare($sql);
                    $row->execute();
                    $hasil = $row->fetchAll(PDO::FETCH_OBJ);
                    $total_users = count($hasil);
                ?>
                <span class="badge badge-light" style="background: rgba(201, 169, 97, 0.2); color: #C9A961; padding: 0.5rem 1rem; font-size: 13px;">
                    <i class="fa fa-user mr-1"></i>
                    Total: <?= $total_users; ?> Pelanggan
                </span>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php if($total_users > 0): ?>
            <div class="table-responsive">
                <table class="table table-admin table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 8%;">No</th>
                            <th style="width: 30%;">Nama Pengguna</th>
                            <th style="width: 25%;">Username</th>
                            <th style="width: 20%;">Level</th>
                            <th style="width: 17%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            foreach($hasil as $r):
                        ?>
                        <tr>
                            <td class="font-weight-bold" style="color: #666;"><?= $no; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" 
                                         style="width: 40px; height: 40px; background: linear-gradient(135deg, #C9A961, #B8985A); color: #fff; font-weight: 600; font-size: 16px;">
                                        <?= strtoupper(substr($r->nama_pengguna, 0, 1)); ?>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold" style="color: #1a1a1a; font-size: 14px;">
                                            <?= $r->nama_pengguna; ?>
                                        </div>
                                        <small class="text-muted" style="font-size: 12px;">
                                            <i class="fa fa-circle" style="color: #28a745; font-size: 8px; margin-right: 5px;"></i>
                                            Pelanggan Aktif
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="color: #666; font-size: 14px;">
                                    <i class="fa fa-at mr-2" style="color: #C9A961; font-size: 13px;"></i>
                                    <?= $r->username; ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-info" style="background: rgba(201, 169, 97, 0.15); color: #C9A961; padding: 0.5rem 0.9rem; font-size: 12px; font-weight: 500; border: 1px solid rgba(201, 169, 97, 0.3);">
                                    <i class="fa fa-user-circle mr-1"></i>
                                    Pengguna
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo $url;?>admin/booking/booking.php?id=<?= $r->id_login;?>" 
                                   class="btn btn-sm btn-admin-view" 
                                   title="Lihat Detail Transaksi">
                                    <i class="fa fa-file-text-o mr-1"></i>
                                    Detail Transaksi
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
                <i class="fa fa-users text-muted" style="font-size: 4rem; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                <h5 class="text-muted">Belum Ada Pelanggan</h5>
                <p class="text-muted mb-0">Data pelanggan akan muncul di sini</p>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if($total_users > 0): ?>
        <div class="card-footer" style="background: #fafafa; border-top: 1px solid #f0f0f0; padding: 1rem 1.5rem;">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="fa fa-info-circle mr-1"></i>
                    Menampilkan <?= $total_users; ?> pelanggan terdaftar
                </small>
                <div>
                    <button class="btn btn-sm btn-outline-primary" onclick="window.print();">
                        <i class="fa fa-print mr-1"></i>
                        Cetak
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="exportToExcel();">
                        <i class="fa fa-file-excel-o mr-1"></i>
                        Export Excel
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
                            <i class="fa fa-users" style="color: #C9A961; font-size: 24px;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 font-weight-bold"><?= $total_users; ?></h3>
                            <small style="opacity: 0.8;">Total Pelanggan</small>
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
                            <i class="fa fa-user" style="color: #C9A961; font-size: 24px;"></i>
                        </div>
                        <div>
                            <?php
                                // Hitung pelanggan aktif (yang pernah booking)
                                $sql_active = "SELECT COUNT(DISTINCT id_login) as active FROM booking";
                                $row_active = $koneksi->prepare($sql_active);
                                $row_active->execute();
                                $active_users = $row_active->fetch(PDO::FETCH_OBJ)->active;
                            ?>
                            <h3 class="mb-0 font-weight-bold"><?= $active_users; ?></h3>
                            <small style="opacity: 0.8; color:#000">Pelanggan Aktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card border-0" style="background: linear-gradient(135deg, #C9A961 0%, #B8985A 100%); border-radius: 8px;">
                <div class="card-body text-black">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" 
                             style="width: 50px; height: 50px; background: rgba(201, 169, 97, 0.2);">
                            <i class="fa fa-user-plus" style="color: #C9A961; font-size: 24px;"></i>
                        </div>
                        <div>
                            <?php
                                // Hitung pelanggan baru (belum pernah booking)
                                $new_users = $total_users - $active_users;
                            ?>
                            <h3 class="mb-0 font-weight-bold"><?= $new_users; ?></h3>
                            <small style="opacity: 0.8;">Pelanggan Baru</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0" style="background: rgba(201, 169, 97, 0.05); border-left: 4px solid #C9A961;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-lightbulb-o mr-3" style="color: #C9A961; font-size: 24px;"></i>
                        <div>
                            <h6 class="mb-1 font-weight-bold" style="color: #1a1a1a;">Tips Manajemen Pelanggan</h6>
                            <p class="mb-0 text-muted" style="font-size: 13px;">
                                Klik "Detail Transaksi" untuk melihat riwayat booking setiap pelanggan. 
                                Gunakan data ini untuk memberikan pelayanan yang lebih baik.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function exportToExcel() {
    alert('Fitur export Excel akan segera tersedia!');
    // Implementasi export Excel bisa ditambahkan di sini
}
</script>

<style>
/* Avatar Hover Effect */
.rounded-circle {
    transition: all 0.3s ease;
}

.table-admin tbody tr:hover .rounded-circle {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(201, 169, 97, 0.3);
}

/* Status Indicator Animation */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.fa-circle {
    animation: pulse 2s infinite;
}

/* Button Hover Effects */
.btn-admin-view:hover {
    transform: translateY(-2px) translateX(0);
}

/* Print Styles */
@media print {
    .btn,
    .card-footer,
    .navbar,
    .jumbotron,
    .footer,
    .copyright,
    .row.mt-4,
    .row.mt-3 {
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
    
    .rounded-circle {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .table-admin {
        font-size: 12px;
    }
    
    .rounded-circle {
        width: 32px !important;
        height: 32px !important;
        font-size: 14px !important;
    }
    
    .btn-admin-view {
        padding: 0.4rem 0.7rem;
        font-size: 11px;
    }
    
    .badge {
        font-size: 10px !important;
        padding: 0.4rem 0.7rem !important;
    }
    
    h2 {
        font-size: 1.5rem;
    }
    
    .d-flex.align-items-center {
        font-size: 13px;
    }
}

@media (max-width: 576px) {
    .table-admin .d-flex.align-items-center {
        flex-direction: column;
        align-items: flex-start !important;
        text-align: left;
    }
    
    .table-admin .rounded-circle {
        margin-bottom: 0.5rem;
        margin-right: 0 !important;
    }
    
    .card-footer .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .card-footer .btn {
        margin-top: 0.5rem;
        width: 100%;
    }
}

/* Enhanced Table Row Hover */
.table-admin tbody tr {
    transition: all 0.3s ease;
}

.table-admin tbody tr:hover {
    background: rgba(201, 169, 97, 0.06) !important;
    transform: translateX(5px);
    box-shadow: -3px 0 0 #C9A961;
}

/* Loading Animation for Avatar */
.rounded-circle {
    position: relative;
    overflow: hidden;
}

.rounded-circle::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s ease;
}

h3 {
  color:#000 !important;
}

.table-admin tbody tr:hover .rounded-circle::before {
    left: 100%;
}
</style>

<?php include '../footer.php'; ?>