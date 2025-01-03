<?php
if ($product) {
    $gambarArray = explode(',', $product['gambar_barang']);

    echo "<div class='container-fluid d-flex justify-content-center '>
        <div class='container d-flex flex-column flex-xl-row justify-content-center py-lg-5 column-gap-4 detail-produk'>
            <!-- IMAGE PRODUCT -->
            <div class='d-flex flex-column align-items-center align-items-xl-start'>
                <h2 class='fw-bold d-none d-xl-block'>" . htmlspecialchars($product['nama_barang']) . "</h2>
                <div class='bungkusImg'>
                    <img src='Assets/Image/uploads/" . htmlspecialchars($gambarArray[0]) . "' class='img-utama zoom rounded mt-3'>
                </div>
                <div class='mt-3 d-flex justify-content-center bungkusImgKecil'>";

    foreach ($gambarArray as $index => $gambar) {
        echo "<img src='Assets/Image/uploads/" . htmlspecialchars($gambar) . "' class='img-kecil border rounded mx-1' data-id='" . ($index + 1) . "'>";
    }

    echo "</div>
            </div>
            
            <!-- DESKRIPSI -->
            <div class='py-3 col-12 col-xl-4'>
                <div class='border-bottom'>
                    <h1 class='display-6 text-nowrap'>" . htmlspecialchars($product['nama_barang']) . "</h1>
                    <div class='text-nowrap d-flex align-items-center column-gap-2 w-100 my-4'>
                        <span>Terjual <span class='text-secondary'>" . htmlspecialchars($product['terjual']) . "</span></span> fsdfksjfjskfjksjfkjsdfkjskfjlskjfkjsfkjslfjskjfl
                        <div class='d-flex align-items-center'>
                            <i class='bi bi-star-fill me-2 text-warning'></i>
                            <span>4.5 <span class='text-secondary d-none d-sm-inline'>(" . htmlspecialchars($product['rating'] > 5 ? 5 : $product['rating']) . " rating)</span></span>
                        </div>
                    </div>
                    <h1 class='fw-bold'>Rp " . htmlspecialchars($product['harga']) . "</h1>
                </div>
                <div>
                    <h2 class='border-bottom py-2'>Detail</h2>
                    <div class='py-4'>
                        <p><span class='text-secondary'>Sisa Stok: </span><span class='fw-bolder'>" . htmlspecialchars($product['stok']) . "</span></p>
                        <p><span class='text-secondary'>Kategori: </span>" . htmlspecialchars($product['nama']) . "</p>
                        <p><span class='text-secondary'>Satuan: </span>" . htmlspecialchars($product['satuan']) . "</p>
                        <p><span class='text-secondary'>Asal pengiriman: </span> Madura </p>
                        <p><span class='text-secondary'>Garansi: </span>1 " . htmlspecialchars($product['varian']) . "</p>
                        <div class='deskripsi mt-4 border-top border-1 py-3'>
                            <div class='row align-items-center'>
                                <div class='d-flex justify-content-between align-items-center'>
                                    <h4>Deskripsi Produk</h4>
                                    <i class='bi bi-caret-down-fill fs-3' type='button' data-bs-toggle='collapse' data-bs-target='#productDescription' aria-controls='productDescription' aria-expanded='false' aria-label='Toggle description'></i>
                                </div>
                                <div class='collapse border-top pt-2' id='productDescription'>
                                    " . htmlspecialchars($product['deskripsi']) . "
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- CO -->
            <div class='border border-2 rounded p-3 co my-xl-4 bg-light shadow'>
                <div class='border-bottom py-3'>
                    <h4 class='fw-bold'>Atur Pesanan</h4>
                    <div class='d-flex align-items-center column-gap-2'>
                        <img src='Assets/Image/uploads/" . htmlspecialchars($gambarArray[0]) . "'  class='img-co'>
                        <p>" . htmlspecialchars($product['nama_barang']) . "</p>
                    </div>
                </div>
                <div class='d-flex justify-content-between align-items-center my-4'>
                    <p class='text-secondary text-nowrap'>Subtotal: </p>
                    <h4 class='text-nowrap'>Rp " . htmlspecialchars($product['harga']) . "</h4>
                </div>
                <div class='d-flex flex-column'>";

    if (isset($_SESSION['kode_user'])) {
        if($product['stok'] > 0){
            echo "<a href='pembayaran.php?kode_barang=" . htmlspecialchars($product['kode_barang']) . "' class='text-decoration-none btn btn-success mb-2 card-link fw-bold'>Beli</a>
            <button class='btn btn-outline-success fw-bold text-nowrap' onclick=\"addToCart('" . htmlspecialchars($product['kode_barang']) . "', '" . $_SESSION['kode_user'] . "')\">Masukkan Keranjang</button>";
        } else {
            echo "<button disabled class='text-decoration-none btn btn-success mb-2 card-link fw-bold'>Stok Habis</button>
            <button class='btn btn-outline-success fw-bold text-nowrap' onclick=\"addToCart('" . htmlspecialchars($product['kode_barang']) . "', '" . $_SESSION['kode_user'] . "')\">Masukkan Keranjang</button>";
        }
      
    } else {
        echo "<a href='Auth/login.php' class='text-decoration-none btn btn-success mb-2 card-link fw-bold'>Login untuk Membeli</a>";
    }
    echo "</div>
            </div>
        </div>
    </div>";
} else {
    echo "Detail produk tidak tersedia.";
}
