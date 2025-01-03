<?php $halamanSaatIni = basename($_SERVER['PHP_SELF']) ?>
<style>
  .dropdown-menu {
    width: 10vw !important;
  }
</style>
<nav class="container-fluid d-flex justify-content-between align-items-center px-4 py-3 border-bottom  z-3" id="navbarBesar">
  <h3 class="fw-bold text-success">Skamart</h3>
  <?php if (isset($_SESSION['username'])): ?>
    <?php if($halamanSaatIni != "dashboard.php") {?>
      <button class="button-back mt-2 me-md-3 ms-auto"><a href="dashboard.php" class="text-reset text-decoration-none text-nowrap "><i class="bi bi-caret-left"></i>Kembali Ke Beranda</a></button>
    <?php } else {?>
      <div class="dropdown">
        <i class="bi bi-person-circle fs-3" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
        <ul class="dropdown-menu dropdown-menu-light border shadow-sm">
          <li><span class="dropdown-item d-flex align-items-center column-gap-2"><i class="bi bi-person-circle"></i><span class="text-nowrap"><?php echo htmlspecialchars($_SESSION['username']); ?></span></span></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item d-flex align-items-center" href="../Controllers/authController.php?action=logout"><i class="bi bi-box-arrow-in-left mx-2"></i> Sign Out</a></li>
        </ul>
      </div>
    <?php }?>
  <?php else: ?>
    <div class="log border-start border-2 ps-1 ps-md-4 d-none d-md-block">
      <a href="../Auth/login.php" class="btn btn-outline-success">Masuk</a>
      <a href="../Auth/register.php" class="btn btn-success">Daftar</a>
    </div>
  <?php endif; ?>
</nav>