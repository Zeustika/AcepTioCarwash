<?php
    session_start();
    if(!empty($_SESSION['USER']['level'] == 'admin')){ 

    }else{ 
        echo '<script>alert("Login Khusus Admin !");window.location="../index.php";</script>';
    }
 
    // select untuk panggil nama admin
    $id_login = $_SESSION['USER']['id_login'];
    
    $row = $koneksi->prepare("SELECT * FROM login WHERE id_login=?");
    $row->execute(array($id_login));
    $hasil_login = $row->fetch();
?>

<!doctype html>
<html lang="id">
  <head>
    <title><?php echo $title_web;?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin Panel - <?= $info_web->nama_rental;?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo $url;?>assets/css/bootstrap.css" >
    <link rel="stylesheet" href="<?php echo $url;?>assets/css/font-awesome.css" >
    <link rel="stylesheet" href="<?php echo $url;?>assets/css/main.css" >
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo $url;?>assets/image/favicon.ico">
  </head>
  <body>
    <!-- Top Header Bar -->
    <div style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); padding: 0.5rem 0; border-bottom: 2px solid #C9A961;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small style="color: rgba(255,255,255,0.7); font-size: 12px;">
                        <i class="fa fa-shield mr-2" style="color: #C9A961;"></i>
                        Admin Dashboard
                    </small>
                </div>
                <div class="col-md-6 text-right">
                    <small style="color: rgba(255,255,255,0.7); font-size: 12px;">
                        <i class="fa fa-calendar mr-1" style="color: #C9A961;"></i>
                        <?php echo date('l, d F Y'); ?>
                        <span class="mx-2">|</span>
                        <i class="fa fa-clock-o mr-1" style="color: #C9A961;"></i>
                        <span id="current-time"></span>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Jumbotron -->
    <div class="jumbotron pt-4 pb-4 mb-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                        </div>
                        <div>
                            <h2 class="mb-1">
                                <b style="text-transform:uppercase; background: linear-gradient(60deg, #ffffff, #C9A961); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                    <?= $info_web->nama_rental;?>
                                </b>
                            </h2>
                            <p class="mb-0" style="color: rgba(255,255,255,0.7); font-size: 14px;">
                                <i class="fa fa-dashboard mr-2"></i>
                                Admin Control Panel
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <div class="d-inline-flex align-items-center" style="background: rgba(255,255,255,0.1); padding: 0.75rem 1.25rem; border-radius: 50px; border: 1px solid rgba(201, 169, 97, 0.3);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" 
                             style="width: 45px; height: 45px; background: linear-gradient(135deg, #C9A961, #B8985A); color: #fff; font-weight: 700; font-size: 18px; box-shadow: 0 4px 12px rgba(201, 169, 97, 0.4);">
                            <?= strtoupper(substr($hasil_login['nama_pengguna'], 0, 1)); ?>
                        </div>
                        <div class="text-left">
                            <div style="color: #000; font-weight: 600; font-size: 15px; line-height: 1.2;">
                                <?php echo $hasil_login['nama_pengguna'];?>
                            </div>
                            <small style="color: #C9A961; font-size: 12px; font-weight: 500;">
                                <i class="fa fa-circle" style="font-size: 8px; margin-right: 5px; animation: pulse 2s infinite;"></i>
                                Administrator
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-custom" style="margin-top: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 1000;">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $url;?>admin/" style="position: relative;">
                <b>
                    Admin Panel
                </b>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item <?php if($title_web == 'Dashboard'){ echo 'active';}?>">
                        <a class="nav-link" href="<?php echo $url;?>admin/">
                            <i class="fa fa-home mr-1"></i>
                            Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if($title_web == 'User'){ echo 'active';}?>">
                        <a class="nav-link" href="<?php echo $url;?>admin/user/index.php">
                            <i class="fa fa-users mr-1"></i>
                            User / Pelanggan
                        </a>
                    </li>
                    <li class="nav-item 
                        <?php if($title_web == 'Daftar Mobil'){ echo 'active';}?>
                        <?php if($title_web == 'Tambah Mobil'){ echo 'active';}?>
                        <?php if($title_web == 'Edit Mobil'){ echo 'active';}?>">
                        <a class="nav-link" href="<?php echo $url;?>admin/mobil/mobil.php">
                            <i class="fa fa-wrench mr-1"></i>
                            Daftar Jasa
                        </a>
                    </li>
                    <li class="nav-item 
                        <?php if($title_web == 'Daftar Booking'){ echo 'active';}?>
                        <?php if($title_web == 'Konfirmasi'){ echo 'active';}?>">
                        <a class="nav-link" href="<?php echo $url;?>admin/booking/booking.php">
                            <i class="fa fa-calendar-check-o mr-1"></i>
                            Daftar Booking
                        </a>
                    </li>
                    <li class="nav-item <?php if($title_web == 'Peminjaman'){ echo 'active';}?>">
                        <a class="nav-link" href="<?php echo $url;?>admin/peminjaman/peminjaman.php">
                            <i class="fa fa-exchange mr-1"></i>
                            Booking
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: flex; align-items: center;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mr-2" 
                                 style="width: 32px; height: 32px; background: linear-gradient(135deg, #C9A961, #B8985A); color: #fff; font-weight: 600; font-size: 14px;">
                                <?= strtoupper(substr($hasil_login['nama_pengguna'], 0, 1)); ?>
                            </div>
                            <span style="font-weight: 500;">
                                <?php echo $hasil_login['nama_pengguna'];?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown" style="border: 1px solid #e0e0e0; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 8px; min-width: 220px;">
                            <div class="dropdown-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: #fff; padding: 1rem; border-radius: 8px 8px 0 0;">
                                <div class="text-center">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" 
                                         style="width: 50px; height: 50px; background: linear-gradient(135deg, #C9A961, #B8985A); color: #fff; font-weight: 700; font-size: 20px;">
                                        <?= strtoupper(substr($hasil_login['nama_pengguna'], 0, 1)); ?>
                                    </div>
                                    <div style="font-weight: 600; font-size: 14px;">
                                        <?php echo $hasil_login['nama_pengguna'];?>
                                    </div>
                                    <small style="color: #C9A961; font-size: 12px;">
                                        Administrator
                                    </small>
                                </div>
                            </div>
                            <div class="dropdown-divider" style="margin: 0;"></div>
                            <a class="dropdown-item" href="<?php echo $url;?>admin/" style="padding: 0.75rem 1rem; transition: all 0.3s ease;">
                                <i class="fa fa-dashboard mr-2" style="color: #C9A961; width: 20px;"></i>
                                Dashboard
                            </a>
                            <a class="dropdown-item" href="#" style="padding: 0.75rem 1rem; transition: all 0.3s ease;">
                                <i class="fa fa-user mr-2" style="color: #C9A961; width: 20px;"></i>
                                Profil Saya
                            </a>
                            <a class="dropdown-item" href="#" style="padding: 0.75rem 1rem; transition: all 0.3s ease;">
                                <i class="fa fa-cog mr-2" style="color: #C9A961; width: 20px;"></i>
                                Pengaturan
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" onclick="return confirm('Apakah anda ingin logout ?');" href="<?php echo $url;?>admin/logout.php" style="padding: 0.75rem 1rem; color: #dc3545; transition: all 0.3s ease;">
                                <i class="fa fa-sign-out mr-2" style="width: 20px;"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb (Optional - can be added on each page) -->
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: transparent; padding: 0; margin-bottom: 0;">
                <li class="breadcrumb-item">
                    <a href="<?php echo $url;?>admin/" style="color: #666; text-decoration: none; font-size: 13px;">
                        <i class="fa fa-home mr-1"></i>
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="color: #C9A961; font-size: 13px; font-weight: 500;">
                    <?php echo $title_web;?>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Real-time Clock Script -->
    <script>
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
    }
    
    // Update time immediately and then every second
    updateTime();
    setInterval(updateTime, 1000);
    </script>

    <style>
    /* Additional Styles for Enhanced Header */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Dropdown hover effects */
    .dropdown-item:hover {
        background: rgba(201, 169, 97, 0.08) !important;
        color: #1a1a1a !important;
        padding-left: 1.5rem !important;
    }

    .dropdown-item:hover i {
        transform: translateX(3px);
        transition: transform 0.3s ease;
    }

    /* Navbar Sticky Shadow */
    .navbar-custom {
        transition: box-shadow 0.3s ease;
    }

    .navbar-custom.scrolled {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }

    /* Navbar Brand Hover Effect */
    .navbar-brand:hover {
        transform: translateX(3px);
    }

    /* Active Nav Indicator Enhancement */
    .navbar-custom .nav-item.active .nav-link {
        position: relative;
    }

    .navbar-custom .nav-item.active .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 60%;
        background: #C9A961;
        border-radius: 0 2px 2px 0;
    }

    /* Breadcrumb Enhancement */
    .breadcrumb-item + .breadcrumb-item::before {
        content: '›';
        color: #C9A961;
        font-weight: 600;
        font-size: 16px;
    }

    .breadcrumb-item a:hover {
        color: #C9A961 !important;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .jumbotron h2 {
            font-size: 1.3rem;
        }
        
        .jumbotron .col-md-4 {
            margin-top: 1rem;
            text-align: left !important;
        }
        
        .d-inline-flex {
            width: 100%;
        }
        
        .navbar-custom .nav-link {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .navbar-custom .nav-item.active .nav-link::before {
            display: none;
        }
        
        .navbar-custom .nav-item.active .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 2px;
            background: #C9A961;
        }
    }

    /* Loading Bar Animation */
    @keyframes loadingBar {
        0% { width: 0%; }
        100% { width: 100%; }
    }

    .loading-bar {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        background: #C9A961;
        z-index: 9999;
        animation: loadingBar 1s ease-out;
    }
    </style>