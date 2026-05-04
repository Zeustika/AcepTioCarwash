<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get website information from database if not already set
if (!isset($info_web)) {
    require 'koneksi/koneksi.php';
    $info_web = $koneksi->query("SELECT * FROM info_rental LIMIT 1")->fetch();
}

// Set default URL for admin if not defined
if (!isset($url)) {
    $url = '';
}

// Current page for active nav item
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!doctype html>
<html lang="en">
<head>
    <title><?= htmlspecialchars($info_web->nama_rental ?? 'Mamat Car Rental') ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= htmlspecialchars($info_web->deskripsi ?? 'Premium Auto Spa') ?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/font-awesome.css">
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/head.css">
    <link rel="icon" type="image/png" href="assets/image/tiocar.png">
</head>
<body>
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="logo-container">
                        <a href="index.php">
                            <img src="assets/image/tiocar.png" alt="<?= htmlspecialchars($info_web->nama_rental ?? 'Car Rental Logo') ?>" class="logo-img" onerror="this.src='https://via.placeholder.com/45x45?text=LOGO';this.onerror='';">
                        </a>
                        <div class="brand-text">
                            <h2><b><?= htmlspecialchars(strtoupper($info_web->nama_rental ?? 'Mamat Car Rental')) ?></b></h2>
                            <p><?= htmlspecialchars($info_web->slogan ?? 'Premium Auto Spa') ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <form class="search-form float-right" method="get" action="blog.php">
                        <div class="input-group search-input-group">
                            <input class="form-control" type="search" name="cari" placeholder="Cari Service yang ada perlukan" aria-label="Search" value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
                            <div class="input-group-append">
                                <button class="btn btn-search" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <?php
                    $nav_items = [
                        'index.php' => ['Home', 'fa-home'],
                        'blog.php' => ['Daftar Jasa', 'fa-wrench'],
                        'kontak.php' => ['Kontak Kami', 'fa-phone'],
                        'location.php' => ['lokasi', 'fa-map']
                    ];
                    
                    if(!empty($_SESSION['USER'])) {
                        $nav_items['history.php'] = ['History', 'fa-history'];
                        $nav_items['profil.php'] = ['Profil', 'fa-user'];
                    }
                    
                    foreach ($nav_items as $page => $item) {
                        $active = ($current_page === $page) ? 'active' : '';
                        echo '<li class="nav-item '.$active.'">
                            <a class="nav-link" href="'.$page.'">
                                <i class="fa '.$item[1].' mr-1"></i> '.$item[0].'
                            </a>
                        </li>';
                    }
                    ?>
                </ul>
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
                
                <ul class="navbar-nav ml-auto user-nav">
                    <?php if(!empty($_SESSION['USER'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-circle mr-1"></i> <?= htmlspecialchars($_SESSION['USER']['nama_pengguna']) ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profil.php"><i class="fa fa-user mr-2"></i> Profil</a>
                                <a class="dropdown-item" href="history.php"><i class="fa fa-history mr-2"></i> History</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" onclick="return confirm('Apakah anda ingin logout ?');" href="<?= $url ?>admin/logout.php">
                                    <i class="fa fa-sign-out mr-2"></i> Logout
                                </a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link btn-login1" href="index.php">
                                <i class="fa fa-sign-in mr-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-register1" href="index.php" data-toggle="modal" data-target="#modelId">
                                <i class="fa fa-user-plus mr-1"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>