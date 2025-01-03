<?php
session_start();  
require_once "Components/Head-User.php";
require_once 'Components/Navbar-User.php';
require_once "Components/Carousle.php";
require_once "Components/Kategori.php";
require_once "Components/StaticPromo.php";
?>

<!-- ======================================================================= DISPLAY PRODUK ======================================================================= -->
<div class="container py-5" id="produk">
  <div class="judul-produk  d-flex justify-content-between align-items-center">
    <h4 class="fw-bold ms-0 ms-lg-4 text-center text-nowrap">Temukan Kebutuhan Anda</h4>
    <?php require_once "Components/Filter.php";  ?>
  </div>
  <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xl-5 g-4 " id="displayProduk" id="product-container">
    <?php
    require_once 'Controllers/productcontroller.php';
    tampilkanSemuaProduk(); // manggil function. hasilnya apa? lihat sendiri di functionnya logic disana semua, disini hanya tinggal manggil agar lebih rapi dan mudah di cari
    ?>
  </div>
</div>
<!-- =========================================================================================================================================================== -->
 
<?php require_once "Components/About.php"; ?>

<!-- ======================================================================= BEST SELLER ======================================================================= -->
<div class="container py-5" id="palinglaris">
<h4 class="fw-bold ms-0 text-success text-center my-5 text-decoration-underline h2" style="text-decoration-thickness: 4px; text-underline-offset: 8px; color: #333; ">Top Produk Paling Banyak Dicari dan Dibeli</h4>
  <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 g-4" id="produkTerlaris">
  <?php require_once "Components/8ProdukTerlaris.php"; ?>
  </div>
</div>
<!-- =========================================================================================================================================================== -->

<?php
require_once "Components/Footer.php";
require_once "Components/Modal.php";
$userId = isset($_SESSION['kode_user']) ? $_SESSION['kode_user'] : null; // menadpatkan kode_user, jika tidak ada atau belum login, maka nilainya null
?>
<script>
  if ('<?php echo $userId; ?>') {
    sessionStorage.setItem('userId', '<?php echo $userId; ?>'); // bila $userId ada nilainya, maka simpan di sessionStorage browser agar bisa digunakan kembali nanti
    var userId = sessionStorage.getItem('userId'); // dapatkan nilai id nya
  }
</script>
<?php require_once "Components/ClosingBodyUser.php"; ?>