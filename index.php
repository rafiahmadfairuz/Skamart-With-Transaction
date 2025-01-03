<?php
// Jika Ada request method GET, lanjut....
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Menginclude file, agar saya bisa ambil atau menggunakan function yang ada di dalamnya
    include_once 'Controllers/productcontroller.php';

    // Mengambil parameter dari URL jika ada, kalo gak ada maka nilai nya null
    $minHarga = $_GET['minHarga'] ?? null; 
    $maxHarga = $_GET['maxHarga'] ?? null; 
    $rangeStok = $_GET['rangeStok'] ?? null; 
    $ratingOrder = $_GET['ratingOrder'] ?? null; 
    $category = $_GET['category'] ?? null; 
    $keyword = $_GET['search'] ?? null; 

    // jika salah satu variabel diatas ada yang nilainya tidak null, maka.......
    if ($minHarga || $maxHarga || $rangeStok || $ratingOrder || $category || $keyword) {
        // panggil fungsi yang ada di contoller yaitu produkYangSudahDiFilter, dan mengirim parameternya juga dengan value yang ada
        $filteredProducts = produkYangSudahDiFilter($conn, $minHarga, $maxHarga, $rangeStok, $ratingOrder, $category, $keyword);

        // kirim hasil function tadi atau produk yang sudah difilter ke file DisplayProduk.php
        require 'Components/DisplayProduk.php'; 
        exit; // Menghentikan skrip setelah produk ditampilkan.
    } 
    // Jika ada parameter id di URL, tampilkan detail produk sesuai ID.
    elseif (isset($_GET['id'])) {
        $id = $_GET['id']; // Mengambil ID produk dari URL.
        
        // Memanggil fungsi untuk menampilkan detail produk berdasarkan ID.
        tampilkanDetailProduk($id);
    } 
    // Jika yang ada adalah parameter `allProducts` di URL, tampilkan semua produk.
    elseif (isset($_GET['allProducts'])) {
        // Memanggil fungsi untuk mendapatkan semua produk.
        tampilkanSemuaProduk();
    } 
    // Jika tidak ada parameter yang sesuai, lempar pengguna ke halaman utama.
    else {
        header("Location: halamanutama.php"); 
        exit; 
    }
} 
// Jika request selain get atau tidak ada request, lempar pengguna ke halaman utama.
else {
    header("Location: halamanutama.php"); 
    exit; 
}
