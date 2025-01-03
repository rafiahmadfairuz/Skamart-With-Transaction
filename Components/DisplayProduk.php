<?php
$products = isset($filteredProducts) ? $filteredProducts : $products;
if ($products instanceof mysqli_result && $products->num_rows > 0) {
    while ($row = $products->fetch_assoc()) {
        $gambarUtama = explode(',', $row['gambar_barang'])[0];
        echo "<a href='index.php?id=" . htmlspecialchars($row['kode_barang']) . "' class='text-decoration-none col card-produk' 
        data-kategori='" . htmlspecialchars($row['nama']) . "' 
        data-harga='" . htmlspecialchars($row['harga']) . "' 
        data-stok='" . htmlspecialchars($row['stok']) . "' 
        data-nama='" . htmlspecialchars($row['nama_barang']) . "'>
            <div class='card mx-auto'>
                <img loading='lazy' src='Assets/Image/uploads/" . htmlspecialchars($gambarUtama) . "' 
                class='card-img-top' >
                <div class='card-body text-nowrap'>
                    <span class='card-title fs-5'>" . htmlspecialchars($row['nama_barang']) . "</span><br>
                    <span class='border border-success text-success px-2'>" . htmlspecialchars($row['nama']) . "</span>
                    <div class='d-flex align-items-center column-gap-1 text-nowrap'>
                        <h5 class='card-text fw-bold my-1'>Rp " . htmlspecialchars($row['harga']) . "</h5>
                    </div>
                    <span class='text-secondary stok'>Stok: " . htmlspecialchars($row['stok']) . "</span>
                    <div class='rating d-flex align-items-center'>
                        <div class='d-flex align-items-center'>
                            <i class='bi bi-star-fill me-2 text-warning'></i>
                            <span>" . htmlspecialchars($row['rating'] > 5 ? 5 : $row['rating']) . "</span>
                        </div>
                        <div class='vr mx-1 mx-md-2'></div>
                        <span class='ulasan'>" . htmlspecialchars($row['terjual']) . " (Terjual)</span>
                    </div>
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
