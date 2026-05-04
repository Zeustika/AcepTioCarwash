<?php
    require '../koneksi/koneksi.php';
    $title_web = 'Dashboard';
    include 'header.php';
    if(empty($_SESSION['USER']))
    {
        session_start();
    }
    if(!empty($_POST['nama_rental']))
    {
        $data[] =  htmlspecialchars($_POST["nama_rental"]);
        $data[] =  htmlspecialchars($_POST["telp"]);
        $data[] =  htmlspecialchars($_POST["alamat"]);
        $data[] =  htmlspecialchars($_POST["email"]);
        $data[] =  htmlspecialchars($_POST["no_rek"]);
        $data[] =  1;
        $sql = "UPDATE infoweb SET nama_rental = ?, telp = ?, alamat = ?, email = ?, no_rek = ?  WHERE id = ? ";
        $row = $koneksi->prepare($sql);
        $row->execute($data);
        echo '<script>alert("Update Data Info Website Berhasil !");window.location="index.php"</script>';
        exit;
    }

    if(!empty($_POST['nama_pengguna']))
    {
        $data[] =  htmlspecialchars($_POST["nama_pengguna"]);
        $data[] =  htmlspecialchars($_POST["username"]);
        $data[] =  md5($_POST["password"]);
        $data[] =  $_SESSION['USER']['id_login'];
        $sql = "UPDATE login SET nama_pengguna = ?, username = ?, password = ? WHERE id_login = ? ";
        $row = $koneksi->prepare($sql);
        $row->execute($data);
        echo '<script>alert("Update Data Profil Berhasil !");window.location="index.php"</script>';
        exit;
    }

    // Get statistics
    $sql_mobil = "SELECT COUNT(*) as total FROM mobil";
    $row_mobil = $koneksi->prepare($sql_mobil);
    $row_mobil->execute();
    $total_mobil = $row_mobil->fetch(PDO::FETCH_OBJ)->total;

    $sql_tersedia = "SELECT COUNT(*) as total FROM mobil WHERE LOWER(status) = 'tersedia'";
    $row_tersedia = $koneksi->prepare($sql_tersedia);
    $row_tersedia->execute();
    $mobil_tersedia = $row_tersedia->fetch(PDO::FETCH_OBJ)->total;

    $sql_booking = "SELECT COUNT(*) as total FROM booking";
    $row_booking = $koneksi->prepare($sql_booking);
    $row_booking->execute();
    $total_booking = $row_booking->fetch(PDO::FETCH_OBJ)->total;

    $sql_users = "SELECT COUNT(*) as total FROM login WHERE level = 'Pengguna'";
    $row_users = $koneksi->prepare($sql_users);
    $row_users->execute();
    $total_users = $row_users->fetch(PDO::FETCH_OBJ)->total;

    $sql_pending = "SELECT COUNT(*) as total FROM booking WHERE LOWER(konfirmasi_pembayaran) != 'sudah dikonfirmasi'";
    $row_pending = $koneksi->prepare($sql_pending);
    $row_pending->execute();
    $booking_pending = $row_pending->fetch(PDO::FETCH_OBJ)->total;
?>

<div class="container" style="margin-top: 2rem; margin-bottom: 3rem;">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 12px; overflow: hidden;">
                <div class="card-body" style="padding: 2rem;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="text-black mb-2" style="font-weight: 700; color: #1a1a1a;">
                                Selamat Datang, <?php echo $hasil_login['nama_pengguna'];?>
                            </h3>
                            <p class="text-black mb-0" style="opacity: 0.8; font-size: 15px; color: #1a1a1a;>
                                <i class="fa fa-clock-o mr-2" style="color: #C9A961;"></i>
                                <?php 
                                $hour = date('H');
                                if($hour >= 5 && $hour < 12) {
                                    echo "Selamat Pagi";
                                } elseif($hour >= 12 && $hour < 15) {
                                    echo "Selamat Siang";
                                } elseif($hour >= 15 && $hour < 18) {
                                    echo "Selamat Sore";
                                } else {
                                    echo "Selamat Malam";
                                }
                                ?>
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="d-inline-block" style="padding: 1rem 1.5rem; background: rgba(201, 169, 97, 0.15); border-radius: 50px; border: 2px solid #C9A961;">
                                <i class="fa fa-dashboard" style="color: #C9A961; font-size: 24px; margin-right: 10px;"></i>
                                <span style="color: #C9A961; font-weight: 600; font-size: 16px;">Dashboard</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, #C9A961 0%, #B8985A 100%); border-radius: 12px; box-shadow: 0 4px 16px rgba(201, 169, 97, 0.3);">
                <div class="card-body text-black" style="padding: 1.5rem;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="mb-1" style="opacity: 0.9; font-size: 13px; font-weight: 500;">Total jasa</p>
                            <h2 class="mb-0 font-weight-bold" style="font-size: 2.5rem;"><?= $total_mobil; ?></h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2);">
                            <i class="fa fa-wrench" style="font-size: 24px;"></i>
                        </div>
                    </div>
                    <a href="<?php echo $url;?>admin/mobil/mobil.php" class="text-black" style="font-size: 13px; text-decoration: none; opacity: 0.9;">
                        <i class="fa fa-arrow-right mr-1"></i>
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 12px; box-shadow: 0 4px 16px rgba(40, 167, 69, 0.3);">
                <div class="card-body text-black" style="padding: 1.5rem;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="mb-1" style="opacity: 0.9; font-size: 13px; font-weight: 500;">Jasa tersedia</p>
                            <h2 class="mb-0 font-weight-bold" style="font-size: 2.5rem;"><?= $mobil_tersedia; ?></h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2);">
                            <i class="fa fa-check-circle" style="font-size: 24px;"></i>
                        </div>
                    </div>
                    <div class="text-black" style="font-size: 13px; opacity: 0.9;">
                        <i class="fa fa-info-circle mr-1"></i>
                        Siap disewakan
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border-radius: 12px; box-shadow: 0 4px 16px rgba(0, 123, 255, 0.3);">
                <div class="card-body text-black" style="padding: 1.5rem;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="mb-1" style="opacity: 0.9; font-size: 13px; font-weight: 500;">Total Booking</p>
                            <h2 class="mb-0 font-weight-bold" style="font-size: 2.5rem;"><?= $total_booking; ?></h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2);">
                            <i class="fa fa-calendar-check-o" style="font-size: 24px;"></i>
                        </div>
                    </div>
                    <a href="<?php echo $url;?>admin/booking/booking.php" class="text-black" style="font-size: 13px; text-decoration: none; opacity: 0.9;">
                        <i class="fa fa-arrow-right mr-1"></i>
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 12px; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);">
                <div class="card-body text-black" style="padding: 1.5rem;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="mb-1" style="opacity: 0.9; font-size: 13px; font-weight: 500;">Total Pelanggan</p>
                            <h2 class="mb-0 font-weight-bold" style="font-size: 2.5rem;"><?= $total_users; ?></h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: rgba(201, 169, 97, 0.3);">
                            <i class="fa fa-users" style="font-size: 24px; color: #C9A961;"></i>
                        </div>
                    </div>
                    <a href="<?php echo $url;?>admin/user/index.php" class="text-black" style="font-size: 13px; text-decoration: none; opacity: 0.9;">
                        <i class="fa fa-arrow-right mr-1"></i>
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert for Pending Bookings -->
    <?php if($booking_pending > 0): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning border-0" style="border-radius: 8px; border-left: 4px solid #ffc107 !important; background: rgba(255, 193, 7, 0.1);">
                <div class="d-flex align-items-center">
                    <i class="fa fa-exclamation-triangle mr-3" style="color: #ffc107; font-size: 24px;"></i>
                    <div>
                        <h6 class="mb-1 font-weight-bold" style="color: #1a1a1a;">Perhatian!</h6>
                        <p class="mb-0" style="color: #666; font-size: 14px;">
                            Terdapat <strong><?= $booking_pending; ?> booking</strong> yang menunggu konfirmasi pembayaran. 
                            <a href="<?php echo $url;?>admin/booking/booking.php" style="color: #ffc107; font-weight: 600;">Cek Sekarang →</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Settings Section -->
    <div class="row">
        <!-- Info Website Card -->
        <div class="col-lg-6 mb-4">
            <div class="card admin-card h-100">
                <div class="card-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-bottom: 2px solid #C9A961;">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-globe mr-3" style="color: #C9A961; font-size: 20px;"></i>
                        <h5 class="mb-0" style="color: #fff; font-weight: 600;">Info Website</h5>
                    </div>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <form action="" method="post">
                        <?php
                            $sql = "SELECT * FROM infoweb WHERE id = 1";
                            $row = $koneksi->prepare($sql);
                            $row->execute();
                            $edit = $row->fetch(PDO::FETCH_OBJ);
                        ?>
                        <div class="form-group">
                            <label for="nama_rental" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                <i class="fa fa-building-o mr-2" style="color: #C9A961;"></i>
                                Nama Rental
                            </label>
                            <input type="text" class="form-control" value="<?= $edit->nama_rental;?>" name="nama_rental" id="nama_rental" placeholder="Masukkan nama rental" required/>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                        <i class="fa fa-envelope-o mr-2" style="color: #C9A961;"></i>
                                        Email
                                    </label>
                                    <input type="email" class="form-control" value="<?= $edit->email;?>" name="email" id="email" placeholder="email@example.com" required/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="telp" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                        <i class="fa fa-phone mr-2" style="color: #C9A961;"></i>
                                        Telepon
                                    </label>
                                    <input type="text" class="form-control" value="<?= $edit->telp;?>" name="telp" id="telp" placeholder="0812xxxxxxxx" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                <i class="fa fa-map-marker mr-2" style="color: #C9A961;"></i>
                                Alamat
                            </label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Masukkan alamat lengkap" required><?= $edit->alamat;?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_rek" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                <i class="fa fa-credit-card mr-2" style="color: #C9A961;"></i>
                                Nomor Rekening
                            </label>
                            <textarea class="form-control" name="no_rek" id="no_rek" rows="2" placeholder="Bank - No. Rekening - Nama Pemilik" required><?= $edit->no_rek;?></textarea>
                            <small class="form-text text-muted">
                                <i class="fa fa-info-circle mr-1"></i>
                                Format: Nama Bank - Nomor Rekening - Nama Pemilik
                            </small>
                        </div>
                        <div class="premium-line"></div>
                        <button type="submit" class="btn btn-primary btn-block" style="padding: 0.75rem; font-weight: 600;">
                            <i class="fa fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Profil Admin Card -->
        <div class="col-lg-6 mb-4">
            <div class="card admin-card h-100">
                <div class="card-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-bottom: 2px solid #C9A961;">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-user-circle mr-3" style="color: #C9A961; font-size: 20px;"></i>
                        <h5 class="mb-0" style="color: #fff; font-weight: 600;">Profil Admin</h5>
                    </div>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <!-- Admin Avatar Display -->
                    <div class="text-center mb-4" style="padding: 1.5rem; background: rgba(201, 169, 97, 0.05); border-radius: 8px;">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px; background: linear-gradient(135deg, #C9A961, #B8985A); color: #fff; font-weight: 700; font-size: 32px; box-shadow: 0 4px 16px rgba(201, 169, 97, 0.4);">
                            <?= strtoupper(substr($hasil_login['nama_pengguna'], 0, 1)); ?>
                        </div>
                        <h5 class="mb-1 font-weight-bold" style="color: #1a1a1a;"><?= $hasil_login['nama_pengguna']; ?></h5>
                        <p class="mb-0 text-muted" style="font-size: 14px;">
                            <i class="fa fa-shield mr-1" style="color: #C9A961;"></i>
                            Administrator
                        </p>
                    </div>

                    <form action="" method="post">
                    <?php
                        $id =  $_SESSION["USER"]["id_login"];
                        $sql = "SELECT * FROM login WHERE id_login = ?";
                        $row = $koneksi->prepare($sql);
                        $row->execute(array($id));
                        $edit_profil = $row->fetch(PDO::FETCH_OBJ);
                    ?>
                        <div class="form-group">
                            <label for="nama_pengguna" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                <i class="fa fa-user mr-2" style="color: #C9A961;"></i>
                                Nama Pengguna
                            </label>
                            <input type="text" class="form-control" value="<?= $edit_profil->nama_pengguna;?>" name="nama_pengguna" id="nama_pengguna" placeholder="Masukkan nama pengguna" required/>
                        </div>
                        <div class="form-group">
                            <label for="username" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                <i class="fa fa-at mr-2" style="color: #C9A961;"></i>
                                Username
                            </label>
                            <input type="text" required class="form-control" value="<?= $edit_profil->username;?>" name="username" id="username" placeholder="Masukkan username"/>
                        </div>
                        <div class="form-group">
                            <label for="password" style="font-weight: 600; color: #1a1a1a; font-size: 14px;">
                                <i class="fa fa-lock mr-2" style="color: #C9A961;"></i>
                                Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" required class="form-control" value="" name="password" id="password" placeholder="Masukkan password baru"/>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()" style="border-color: #e0e0e0;">
                                        <i class="fa fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fa fa-info-circle mr-1"></i>
                                Minimal 6 karakter untuk keamanan lebih baik
                            </small>
                        </div>
                        <div class="premium-line"></div>
                        <button type="submit" class="btn btn-primary btn-block" style="padding: 0.75rem; font-weight: 600;">
                            <i class="fa fa-save mr-2"></i> Update Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0" style="background: rgba(201, 169, 97, 0.05); border-radius: 8px;">
                <div class="card-body" style="padding: 1.5rem;">
                    <h6 class="mb-3 font-weight-bold" style="color: #1a1a1a;">
                        <i class="fa fa-bolt mr-2" style="color: #C9A961;"></i>
                        Quick Actions
                    </h6>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?php echo $url;?>admin/mobil/tambah.php" class="btn btn-outline-primary btn-block" style="padding: 1rem; border-width: 2px;">
                                <i class="fa fa-plus-circle d-block mb-2" style="font-size: 24px;"></i>
                                <span style="font-size: 13px; font-weight: 600;">Tambah Jasa</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?php echo $url;?>admin/booking/booking.php" class="btn btn-outline-primary btn-block" style="padding: 1rem; border-width: 2px;">
                                <i class="fa fa-list-alt d-block mb-2" style="font-size: 24px;"></i>
                                <span style="font-size: 13px; font-weight: 600;">Lihat Booking</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?php echo $url;?>admin/user/index.php" class="btn btn-outline-primary btn-block" style="padding: 1rem; border-width: 2px;">
                                <i class="fa fa-users d-block mb-2" style="font-size: 24px;"></i>
                                <span style="font-size: 13px; font-weight: 600;">Kelola Pelanggan</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?php echo $url;?>admin/peminjaman/peminjaman.php" class="btn btn-outline-primary btn-block" style="padding: 1rem; border-width: 2px;">
                                <i class="fa fa-exchange d-block mb-2" style="font-size: 24px;"></i>
                                <span style="font-size: 13px; font-weight: 600;">Peminjaman</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle Password Visibility
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// Form Validation Enhancement
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i> Menyimpan...';
        submitBtn.disabled = true;
    });
});
</script>

<style>
/* Dashboard Specific Styles */
.stats-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.stats-card:hover {
    transform: translateY(-5px);
}

/* Form Enhancements */
.form-control:focus {
    border-color: #C9A961;
    box-shadow: 0 0 0 0.2rem rgba(201, 169, 97, 0.15);
}

.form-control {
    font-size: 14px;
    padding: 0.75rem 1rem;
}

label {
    margin-bottom: 0.5rem;
}

/* Button Hover Effects */
.btn-outline-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(201, 169, 97, 0.2);
}

/* Alert Animation */
.alert {
    animation: slideDown 0.5s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Card Hover Effects */
.admin-card {
    transition: all 0.3s ease;
}

.admin-card:hover {
    box-shadow: 0 8px 24px rgba(201, 169, 97, 0.15);
}

/* Responsive */
@media (max-width: 768px) {
    .stats-card h2 {
        font-size: 2rem !important;
    }
    
    .rounded-circle {
        width: 40px !important;
        height: 40px !important;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
}
</style>

<?php include 'footer.php';?>