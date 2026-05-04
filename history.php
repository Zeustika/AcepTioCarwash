<?php
    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
    if (empty($_SESSION['USER'])) {
        echo '<script>alert("Harap Login");window.location="index.php"</script>';
    }
    $hasil = $koneksi->query("SELECT mobil.merk, booking.* FROM booking JOIN mobil ON 
    booking.id_mobil=mobil.id_mobil ORDER BY id_booking DESC")->fetchAll();
?>

<div class="wrapper d-flex flex-column min-vh-100">
    <div class="container py-5 flex-grow-1" id="content-page">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pt-4">
                        <h4 class="mb-0 text-primary fw-bold">
                            </i>Riwayat Transaksi
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%" class="text-center">No.</th>
                                        <th width="15%">Kode Booking</th>
                                        <th width="15%">Mobil</th>
                                        <th width="15%">Nama</th>
                                        <th width="12%">Tanggal</th>
                                        <th width="10%" class="text-center">Durasi</th>
                                        <th width="15%">Total</th>
                                        <th width="8%" class="text-center">Status</th>
                                        <th width="5%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($hasil) > 0): ?>
                                        <?php $no = 1; foreach($hasil as $isi): ?>
                                        <tr>
                                            <td class="text-center"><?= $no; ?></td>
                                            <td>
                                                <span class="badge bg-light text-dark border"><?= $isi['kode_booking']; ?></span>
                                            </td>
                                            <td><?= $isi['merk']; ?></td>
                                            <td><?= $isi['nama']; ?></td>
                                            <td><?= date('d M Y', strtotime($isi['tanggal'])); ?></td>
                                            <td class="text-center"><?= $isi['lama_sewa']; ?> hari</td>
                                            <td>Rp <?= number_format($isi['total_harga'], 0, ',', '.'); ?></td>
                                            <td class="text-center">
                                                <span class="badge rounded-pill bg-<?= $isi['konfirmasi_pembayaran'] == 'sudah' ? 'success' : 'warning'; ?>">
                                                    <?= ucfirst($isi['konfirmasi_pembayaran']); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="bayar.php?id=<?= $isi['kode_booking']; ?>" class="btn btn-sm btn-outline-primary rounded-circle" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $no++; endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-3"></i>
                                                    <p class="mb-0">Belum ada riwayat transaksi</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if(count($hasil) > 0): ?>
                    <div class="card-footer bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Menampilkan <?= count($hasil); ?> transaksi
                            </div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</div>