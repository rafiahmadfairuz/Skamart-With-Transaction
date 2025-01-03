<?php
require_once 'Controllers/productcontroller.php';
$result = diskon70();
?>
<div class="container my-3 my-md-5 d-flex justify-content-center align-items-center" id="promo">
    <div class=" promo d-flex flex-column flex-lg-row justify-content-between py-3 py-md-5 rounded">
        <div class="d-flex flex-column col-12 col-lg-3 px-0 px-lg-5 ms-3 ms-lg-0 ">
            <h1 class="fw-bold mb-2 mb-md-4 display-2 ">Flash Sale</h1>
            <h4 class="fw-bold my-2 d-none d-lg-block">Diskon tiap hari sampai 70%!</h4>
            <p class="d-none d-lg-block">Mau nikmatin Flash Deal? Beli Sekarang Di Skamart</p>
        </div>
        <div class="pr">
            <div class="kotak-promo d-flex justify-content-around ">

            <?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $gambarUtama = explode(',', $row['gambar_barang'])[0];
        
        // Menghitung harga asli (sebelum diskon)
        $hargaDiskon = (float)$row['harga'];
        $diskon = (float)$row['diskon'];
        $hargaAsli = $hargaDiskon / (1 - ($diskon / 100));       
            echo "<a href='index.php?id=" . htmlspecialchars($row['kode_barang']) . "' class='text-decoration-none mx-2 card d-flex' 
                data-kategori='" . htmlspecialchars($row['nama']) . "' 
                data-harga='" . htmlspecialchars($row['harga']) . "' 
                data-stok='" . htmlspecialchars($row['stok']) . "' 
                data-nama='" . htmlspecialchars($row['nama_barang']) . "' id='card-promo'>
                    <img loading='lazy' src='Assets/Image/uploads/" . htmlspecialchars($gambarUtama) . "' class='card-img-top align-self-center mt-2' alt='...'>
                    <div class='card-body text-nowrap'>
                        <span class='card-title fs-5'>" . htmlspecialchars($row['nama_barang']) . "</span><br>
                        <span class='border border-success text-success px-2'>" . htmlspecialchars($row['nama']) . "</span>
                        <span class='border border-danger text-success px-2'>PROMO</span>
                        <div class='d-flex align-items-center column-gap-2 text-nowrap'>
                            <h5 class='card-text fw-bold my-1'>Rp " . htmlspecialchars($row['harga']) . "</h5>
                            <span class='text-secondary'>Stok: " . htmlspecialchars($row['stok']) . "</span>
                        </div>
                        <div class='d-flex align-items-center column-gap-2 text-nowrap'>
                            <span class='text-secondary text-decoration-line-through'>Rp " . number_format($hargaAsli, 0, ',', '.') . "</span>
                            <span class='fw-bold text-success'>" . htmlspecialchars($row['diskon']) . "%</span>
                        </div>
                        <div class='d-flex align-items-center d-none d-md-block'><i class='bi bi-geo-alt-fill text-success me-2'></i><span>Madura</span></div>
                        <div class='rating d-flex align-items-center'>
                            <div class='d-flex  align-items-center'>
                                <i class='bi bi-star-fill me-2 text-warning '></i>
                                <span>" . htmlspecialchars($row['rating'] > 5 ? 5 : $row['rating']) . "</span>
                            </div>
                            <div class='vr mx-2'></div>
                            <span class='ulasan'>" . htmlspecialchars($row['terjual']) . " (Terjual)</span>
                        </div>
                    </div>
                </a>";
    }
} else {
    echo "
      <div class='tidakDitemukan text-center p-5 text-danger w-100'>
          <h1 class='fw-bold'>Maaf, Produk Tidak Tersedia / Tidak Ditemukan. Silahkan Cari Yang Lain....</h1>
      </div>
  ";
}
?>

            </div>
        </div>
    </div>
</div>