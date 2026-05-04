<?php
    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
    if(empty($_SESSION['USER']))
    {
        echo '<script>alert("Harap Login");window.location="index.php"</script>';
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
        echo '<script>alert("Update Data Profil Berhasil !");window.location="profil.php"</script>';
        exit;
    }
?>

<div class="container py-5" id="content-page">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="text-primary mb-4 text-center">Edit Profil</h4>
                    <form action="" method="post">
                        <?php
                            $id =  $_SESSION["USER"]["id_login"];
                            $sql = "SELECT * FROM login WHERE id_login = ?";
                            $row = $koneksi->prepare($sql);
                            $row->execute(array($id));
                            $edit_profil = $row->fetch(PDO::FETCH_OBJ);
                        ?>
                        <div class="form-group mb-3">
                            <label for="nama_pengguna" class="form-label">Nama Pengguna</label>
                            <input type="text" class="form-control" value="<?= $edit_profil->nama_pengguna;?>" name="nama_pengguna" id="nama_pengguna" placeholder=""/>
                        </div>
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" required class="form-control" value="<?= $edit_profil->username;?>" name="username" id="username" placeholder=""/>
                        </div>
                        <div class="form-group mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" required class="form-control" value="" name="password" id="password" placeholder=""/>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-4">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>

<?php include 'footer.php';?>