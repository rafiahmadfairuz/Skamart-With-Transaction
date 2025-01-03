<?php
require_once 'Config/database.php';
$conn = connectDatabase();

function getAllProducts($conn)
{
    $stmt = $conn->prepare("SELECT master_barang.kode_barang, master_barang.rating, master_barang.terjual ,master_barang.nama_barang, master_barang.harga, master_kategori.nama, master_barang.gambar_barang, master_barang.stok, master_barang.deskripsi, master_barang.satuan, master_barang.diskon, master_barang.varian FROM master_barang LEFT JOIN master_kategori ON master_barang.kode_kategori = master_kategori.kode_kategori");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}


function getFilteredProducts($conn, $minHarga, $maxHarga, $rangeStok, $ratingOrder, $category, $keyword)
{
    $sql = "SELECT master_barang.kode_barang,  master_barang.terjual ,  master_barang.rating, master_barang.nama_barang, master_barang.harga, master_kategori.nama, master_barang.gambar_barang, master_barang.stok, master_barang.deskripsi, master_barang.satuan, master_barang.diskon, master_barang.varian FROM master_barang LEFT JOIN master_kategori ON master_barang.kode_kategori = master_kategori.kode_kategori  WHERE 1=1";

    // Filter harga
    if (!empty($minHarga)) {
        $sql .= " AND master_barang.harga >= " . intval($minHarga);
    }
    if (!empty($maxHarga)) {
        $sql .= " AND master_barang.harga <= " . intval($maxHarga);
    }

    // Filter stok
    if (!empty($rangeStok)) {
        $sql .= " AND master_barang.stok <= " . intval($rangeStok);
    }

    
    // Filter kategori
    if (!empty($category)) {
        $sql .= " AND master_kategori.nama = '" . $conn->real_escape_string($category) . "'";
    }
    
    // Filter pencarian
    if (!empty($keyword)) {
        $sql .= " AND master_barang.nama_barang LIKE '%" . $conn->real_escape_string($keyword) . "%'";
    }
    
    // Filter rating
    if (!empty($ratingOrder)) {
        if ($ratingOrder == 'highest') {
            $sql .= " ORDER BY master_barang.rating DESC";
        } else if ($ratingOrder == 'lowest') {
            $sql .= " ORDER BY master_barang.rating ASC";
        }
    }

    return $conn->query($sql);
}

function getProductById($conn, $id)
{
    $sql = "SELECT master_barang.kode_barang,  master_barang.terjual ,  master_barang.rating, master_barang.nama_barang, master_barang.harga, master_kategori.nama, master_barang.gambar_barang, master_barang.stok, master_barang.deskripsi, master_barang.satuan, master_barang.diskon, master_barang.varian FROM master_barang LEFT JOIN master_kategori ON master_barang.kode_kategori = master_kategori.kode_kategori WHERE master_barang.kode_barang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
    return $product;
}

function getProdukTerlaris($conn)
{
    $stmt = $conn->prepare("SELECT master_barang.kode_barang,  master_barang.rating,  master_barang.terjual , master_barang.nama_barang, master_barang.harga, master_kategori.nama, master_barang.gambar_barang, master_barang.stok, master_barang.deskripsi, master_barang.satuan, master_barang.diskon, master_barang.varian FROM master_barang LEFT JOIN master_kategori ON master_barang.kode_kategori = master_kategori.kode_kategori ORDER BY master_barang.terjual DESC LIMIT 12");  // Membatasi hasil query menjadi 12 produk teratas
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function getProdukDiskon($conn)
{
    $stmt = $conn->prepare("SELECT master_barang.kode_barang,  master_barang.rating,  master_barang.terjual , master_barang.nama_barang, master_barang.harga, master_kategori.nama, master_barang.gambar_barang, master_barang.stok, master_barang.deskripsi, master_barang.satuan, master_barang.diskon, master_barang.varian FROM master_barang LEFT JOIN master_kategori ON master_barang.kode_kategori = master_kategori.kode_kategori WHERE master_barang.diskon > 69 LIMIT 4");  // Membatasi hasil query menjadi 12 produk teratas
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}


