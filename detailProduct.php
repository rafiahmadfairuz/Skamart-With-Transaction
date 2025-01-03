<?php 
session_start(); 
require_once 'Controllers/cartcontroller.php'; 
require_once "Components/Head-User.php";
?>
<body>
  <!-- Modal berhasil, ini nanti dipanggil dari JS saat kita berhasil menambahkan item di keranjang -->
  <div class="modal fade" id="modalBerhasil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Sukses</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h2 class="fw-bold text-center">Sukses Tambah Item</h2>
        </div>
      </div>
    </div>
  </div>
  <?php include 'Components/Navbar-User.php'; ?>
  <div class="container-fluid d-flex justify-content-center ">
    <?php include 'Components/DetailCard.php'; ?>
  </div>
  <?php require_once "Components/Footer.php"; ?>
  <?php require_once "Components/ClosingBodyUser.php"; ?>