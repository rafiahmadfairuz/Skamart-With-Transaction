<?php
 session_start(); 
 require_once "../Controllers/adminController.php";
 $data = detail($_GET['view']);
 $gambarArray = explode(',',$data['gambar_barang']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Skamart</title>
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
    <!-- BODY -->
    <div class="d-flex row justify-content-center  py-3 container-fluid detail ">
        <div id="carouselExampleIndicators" class="carousel slide d-flex flex-column col-10 col-lg-4">
            <div class="carousel-indicators">
                <?php foreach ($gambarArray as $index => $gambar): ?>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $index; ?>" <?php echo $index === 0 ? 'class="active"' : ''; ?> aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $index + 1; ?>"></button>
                <?php endforeach; ?>
            </div>
            <div class="carousel-inner border shadow">
                <?php foreach ($gambarArray as $index => $gambar): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <img src="../Assets/Image/uploads/<?php echo $gambar; ?>" class="d-block w-100 gambar zoom" alt="Gambar <?php echo $index + 1; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            </button>
            <span id="carouselImageNumber" class="border mt-3 py-2 px-5 fw-bold shadow bg-light">Image 1 / <?php echo count($gambarArray); ?></span>
        </div>


        <div class="border shadow col-11 col-lg-5 py-3 px-5 mt-3 mt-lg-0">
            <h2 class="fw-bold text-success text-nowrap py-4 border-bottom">Preview Barang </h2>
            <div class="py-5">
                <div class="d-flex column-gap-2 align-items-center">
                    <p class="fw-bold">Kode Barang : </p>
                    <p><?php echo $data['kode_barang'] ?></p>
                </div>
                <div class="d-flex column-gap-2 align-items-center">
                    <p class="fw-bold">Nama Barang : </p>
                    <p><?php echo $data['nama_barang'] ?></p>
                </div>
                <div class="d-flex column-gap-2 align-items-center">
                    <p class="fw-bold">Satuan : </p>
                    <p><?php echo $data['satuan'] ?></p>
                </div>
                <div class="d-flex column-gap-2 align-items-center">
                    <p class="fw-bold">Diskon : </p>
                    <p><?php echo $data['diskon'] ?></p>
                </div>
                <div class="d-flex column-gap-2 align-items-center">
                    <p class="fw-bold">Varian : </p>
                    <p><?php echo $data['varian'] ?></p>
                </div>
                <div class="d-flex column-gap-2 align-items-center">
                    <p class="fw-bold">Harga : </p>
                    <p><?php echo $data['harga'] ?></p>
                </div>
                <div class="d-flex column-gap-2 align-items-center">
                    <p class="fw-bold">Jumlah Stok : </p>
                    <p><?php echo $data['stok'] ?></p>
                </div>
                <div class="d-flex column-gap-2 align-items-center">
                    <p class="fw-bold">Nama Kategori : </p>
                    <p><?php echo $data['nama'] ?></p>
                </div>
                <div class="d-flex column-gap-2 align-items-center">
                    <p class="fw-bold">Nilai : </p>
                    <p><?php echo $data['rating'] ?? 0 ?></p>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?= '../Assets/Js/das.js' ?>"></script>
</body>

</html>