<?php
 session_start(); 
 require_once "../Controllers/adminController.php";
 $data = getData($_GET['update']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skamart | Update Produk</title>
    <!-- STYLE CSS -->
    <link rel="stylesheet" href="<?= '../Assets/Css/style.css' ?>">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../Components/Navbar-Admin.php'; ?>
    <div class="d-flex row justify-content-center  py-3 container-fluid detail ">
        <form action="../Controllers/adminController.php?action=update" method="POST" class="col-md-6 order-1 order-md-0" enctype="multipart/form-data">
                <input type="hidden" class="form-control border-success" id="kodeBarang" value="<?= $data['kode_barang']?>" name="kode_barang">
            <div class="mb-3">
                <label for="nama_barang" class="form-label fw-bold">Nama Barang</label>
                <input type="text" class="form-control border-success" name="nama_barang" value="<?= $data['nama_barang']?>" id="nama_barang" disabled>
            </div>
            <div class="mb-3">
                <label for="imageInput" class="form-label fw-bold">Gambar Poduk <span class="fw-bold text-danger">(Masukkan 6 Gambar) Bila Tidak Update Gambar Kosongkan Saja</span></label>
                <input type="file" multiple class="form-control border-success" id="imageInput" name="gambar[]" accept=".jpg,.png">
                <?php if (isset($_SESSION['peringatan'])): ?>
                    <span class="text-danger fw-bold"><?= htmlspecialchars($_SESSION['peringatan']) ?></span>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="keterangan_barang" class="form-label fw-bold">Keterangan</label>
                <textarea style="max-height: 100px;" name="deskripsi" type="text" class="form-control border-success"  id="keterangan_barang" required> <?= $data['deskripsi']?></textarea>
            </div>
            <?php if (isset($_SESSION['error'])): ?>
                    <span class="text-danger fw-bold"><?= htmlspecialchars($_SESSION['error']) ?></span>
            <?php endif ?>
            <div class="mb-3">
                <label for="harga" class="form-label fw-bold">Harga</label>
                <input type="number" class="form-control border-success" id="harga" name="harga"  value="<?= $data['harga']?>" required>
            </div>
            <div class="mb-3">
                <label for="diskon" class="form-label fw-bold">Diskon</label>
                <input type="number" max="90" name="diskon" class="form-control border-success" id="diskon"  value="<?= $data['diskon']?>" required>
            </div>
            <div class="mb-3">
                <label for="sttok" class="form-label fw-bold">Jumlah Stok</label>
                <input type="number" class="form-control border-success" id="sttok" name="stok"  value="<?= $data['stok']?>" required>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" name="create" class="btn btn-success me-2 fw-bold">Save</button>
                <button type="reset" name="reset" class="btn btn-outline-danger">Cancel</button>
            </div>
        </form>
        <div id="carouselExampleIndicators" class="carousel slide d-flex flex-column col-10 col-lg-4 mt-5">
            <div class="carousel-indicators" id="carouselIndicators"></div>
            <div class="carousel-inner border shadow" id="carouselInner"></div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <span id="carouselImageNumber" class="border mt-3 py-2 px-5 fw-bold shadow bg-light">Image 1 / 0</span>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?= '../Assets/Js/das.js' ?>"></script>
    <?php
    unset($_SESSION['peringatan']);
    unset($_SESSION['error']);
    ?>
</body>
</html>