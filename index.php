<?php
require 'koneksi/koneksi.php';
if(empty($_SESSION['USER']))
{
    session_start();
}
include 'header.php';
?>

<div class="container mt-4">
    <div class="carousel-container">
        <div id="carouselId" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php 
                    $querymobil =  $koneksi -> query('SELECT * FROM mobil ORDER BY id_mobil DESC')->fetchAll();
                    $no = 1;
                    foreach($querymobil as $isi)
                    {
                ?>
                <li data-target="#carouselId" data-slide-to="<?= $no;?>" class="<?php if($no == '1'){ echo 'active';}?>"></li>
                <?php $no++;}?>
            </ol>
            <div class="carousel-inner" role="listbox">
                <?php 
                    $no = 1;
                    foreach($querymobil as $isi)
                    {
                ?>
                <div class="carousel-item <?php if($no == '1'){ echo 'active';}?>">
                    <img src="assets/image/<?= $isi['gambar'];?>" alt="<?= $isi['merk'];?>" 
                    class="img-fluid" style="object-fit:cover;width:100%;height:500px;">
                    <div class="carousel-caption d-none d-md-block">
                        <h3><?= $isi['merk'];?></h3>
                        <small><?= $isi['deskripsi'];?></small>
                    </div>
                </div>
                <?php $no++;}?>
            </div>
            <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <?php if($_SESSION['USER']){?>
                        <h5 class="card-title">Selamat Datang</h5>
                        <p class="text-muted"><?php echo $_SESSION['USER']['nama_pengguna'];?></p>
                        <hr>
                        <div class="d-grid gap-2">
                            <?php if($_SESSION['USER']['level'] == 'admin'){?>
                                <a href="admin/index.php" class="btn btn-primary btn-block">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            <?php }else{?>
                                <a href="blog.php" class="btn btn-primary btn-block">
                                    <i class="fa fa-wrench"></i> Booking Sekarang
                                </a>
                            <?php }?>
                            <a href="admin/logout.php" class="btn btn-outline-danger btn-block" onclick="return confirm('Apakah anda ingin logout ?');">
                                <i class="fa fa-sign-out"></i> Logout
                            </a>
                        </div>
                    <?php }else{?>
                    <form method="post" action="koneksi/proses.php?id=login">
                        <h5 class="card-title text-center mb-4">Login</h5>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="user" id="username" class="form-control" placeholder="Masukkan username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="pass" id="password" class="form-control" placeholder="Masukkan password" required>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-sign-in"></i> Login
                            </button>
                        </div>
                        <div class="text-center mt-3">
                            <a class="btn btn-outline-secondary btn-block" data-toggle="modal" data-target="#modelId">
                                <i class="fa fa-user-plus"></i> Daftar Akun
                            </a>
                        </div>
                    </form>
                    <?php }?>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Layanan Kami</h5>
                    <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fa fa-check text-success"></i> Cuci Eksterior & Interior</li>
                    <li class="list-group-item"><i class="fa fa-check text-success"></i> Vakum & Lap Dashboard</li>
                    <li class="list-group-item"><i class="fa fa-check text-success"></i> Semir Ban & Poles Kaca</li>
                    <li class="list-group-item"><i class="fa fa-check text-success"></i> Pewangi Ruangan Gratis</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="row">
                <?php 
                    $query = $koneksi->query('SELECT * FROM mobil ORDER BY id_mobil DESC')->fetchAll();
                    foreach($query as $isi)
                    {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="position-relative">
                            <img src="assets/image/<?php echo $isi['gambar'];?>" class="card-img-top" alt="<?php echo $isi['merk'];?>">
                            <?php if($isi['status'] == 'Tersedia'){?>
                                <div class="position-absolute badge-status">
                                    <span class="badge badge-success">Tersedia</span>
                                </div>
                            <?php }else{?>
                                <div class="position-absolute badge-status">
                                    <span class="badge badge-danger">Tidak Tersedia</span>
                                </div>
                            <?php }?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $isi['merk'];?></h5>
                            <div class="price-tag">
                                <span class="price">Rp. <?php echo number_format($isi['harga']);?> <small></small></span>
                            </div>
                            <div class="features">
                                <span class="badge badge-light"><i class="fa fa-tag"></i> Free Wheel polish</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between">
                                <a href="booking.php?id=<?php echo $isi['id_mobil'];?>" class="btn btn-success btn-sm">
                                    <i class="fa fa-calendar-check-o"></i> Booking
                                </a>
                                <a href="detail.php?id=<?php echo $isi['id_mobil'];?>" class="btn btn-info btn-sm">
                                    <i class="fa fa-info-circle"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Akun Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="koneksi/proses.php?id=daftar">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="username_daftar">Username</label>
                        <input type="text" name="user" id="username_daftar" class="form-control" placeholder="Masukkan username" required>
                    </div>
                    <div class="form-group">
                        <label for="password_daftar">Password</label>
                        <input type="password" name="pass" id="password_daftar" class="form-control" placeholder="Masukkan password" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Daftar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>