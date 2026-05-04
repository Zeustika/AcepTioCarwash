<footer class="footer mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5><?= $info_web->nama_rental;?></h5>
        <p>Solusi Cuci premium untuk kebutuhan transportasi anda.</p>
        <div class="social-links mt-3">
          <a href="https://github.com/zeustika" class="mr-2"><i class="fa fa-github"></i></a>
          <a href="#" class="mr-2"><i class="fa fa-instagram"></i></a>
          <a href="#" class="mr-2"><i class="fa fa-twitter"></i></a>
          <a href="#"><i class="fa fa-whatsapp"></i></a>
        </div>
      </div>
      <div class="col-md-4">
        <h5>Informasi</h5>
        <ul class="list-unstyled">
          <li><a href="index.php">Home</a></li>
          <li><a href="blog.php">Daftar Jasa</a></li>
          <li><a href="kontak.php">Kontak Kami</a></li>
          <li><a href="syarat.php">Syarat & Ketentuan</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h5>Kontak</h5>
        <ul class="list-unstyled">
          <li><i class="fa fa-map-marker mr-2"></i>Setiawargi, Kec. Tamansari, Kab. Tasikmalaya, Jawa Barat</li>
          <li><i class="fa fa-phone mr-2"></i> +62 877-8382-1979</li>
          <li><i class="fa fa-envelope mr-2"></i> businnes@aceptiocarwash.com</li>
        </ul>
      </div>
    </div>
    <hr class="footer-divider">
    <div class="row">
      <div class="col-md-12 text-center">
        <p class="mb-0">Copyright © <?= date('Y');?> <?= $info_web->nama_rental;?> | Tugas PABP IF Unsil</p>
      </div>
    </div>
  </div>
</footer>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>