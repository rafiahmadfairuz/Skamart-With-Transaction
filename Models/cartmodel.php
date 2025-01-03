<?php
include_once __DIR__ . '/../Config/database.php';

function addToCart($kode_user, $productId) {
    $conn = connectDatabase();
    $query = "SELECT * FROM cart WHERE kode_user = ? AND kode_barang = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $kode_user, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $query = "UPDATE cart SET quantity = quantity + 1 WHERE kode_user = ? AND kode_barang = ?";
    } else {
        $query = "INSERT INTO cart (kode_user, kode_barang, quantity) VALUES (?, ?, 1)";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $kode_user, $productId);
    return $stmt->execute();
}

function getCartItemCount($kode_user) {
    $conn = connectDatabase();
    $query = "SELECT SUM(quantity) AS total_items FROM cart WHERE kode_user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $kode_user);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total_items'] ? $row['total_items'] : 0;
}

function getProductDetails($productId, $kode_user) {
    $conn = connectDatabase();
    $query = "
       SELECT 
           master_barang.kode_barang, 
           master_barang.nama_barang, 
           master_barang.harga, 
           master_kategori.nama, 
           master_barang.gambar_barang, 
           master_barang.stok, 
           master_barang.deskripsi, 
           master_barang.satuan, 
           master_barang.diskon, 
           master_barang.varian, 
           cart.quantity, 
           cart.id 
       FROM 
           master_barang 
       LEFT JOIN 
           master_kategori ON master_barang.kode_kategori = master_kategori.kode_kategori 
       LEFT JOIN 
           cart ON master_barang.kode_barang = cart.kode_barang 
       WHERE 
           cart.kode_user = ? 
           AND master_barang.kode_barang = ?;
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $kode_user, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        // Mengembalikan data produk dalam bentuk array
        $stmt->close();
        $conn->close();
        return [
            'kode_barang' => $product['kode_barang'],
            'nama_barang' => $product['nama_barang'],
            'stok' => $product['stok'],
            'varian' => $product['varian'],
            'harga' => $product['harga'],
            'gambar_barang' => $product['gambar_barang'],
            'quantity' => $product['quantity'],
            'ide' => $product['id'],
        ];
    } else {
        $stmt->close();
        $conn->close();
        return null; // Jika tidak ada produk ditemukan
    }
}


function getCartItemsByUserId($kode_user) {
    $conn = connectDatabase();
   
    $query = "
       SELECT 
    master_barang.kode_barang, 
    master_barang.nama_barang, 
    master_barang.harga, 
    master_kategori.nama, 
    master_barang.gambar_barang, 
    master_barang.stok, 
    master_barang.deskripsi, 
    master_barang.satuan, 
    master_barang.diskon, 
    master_barang.varian, 
    cart.quantity, 
    cart.id 
FROM 
    master_barang 
LEFT JOIN 
    master_kategori ON master_barang.kode_kategori = master_kategori.kode_kategori 
LEFT JOIN 
    cart ON master_barang.kode_barang = cart.kode_barang 
WHERE 
    cart.kode_user = ?;

    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $kode_user);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function removeFromCart($kode_user, $productId) {
    $conn = connectDatabase();
    $query = "DELETE FROM cart WHERE kode_user = ? AND id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $kode_user, $productId);
    return $stmt->execute();
}
?>
