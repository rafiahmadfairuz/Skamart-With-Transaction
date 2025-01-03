<?php
require_once "Config/database.php";
$conn = connectDatabase();
function buatOrder()
{
    global $conn;
    $kode_barang = $_GET['kode_barang'];

    // Mendapatkan data barang
    $query_harga = "SELECT * FROM master_barang WHERE kode_barang = '$kode_barang'";
    $mendapatkan_harga = mysqli_query($conn, $query_harga);
    $data = mysqli_fetch_assoc($mendapatkan_harga);
    $total_harga = $data['harga'];

    $kode_user = $_SESSION['kode_user'];

    // Membuat transaksi
    $queryCreateTransaksi = "INSERT INTO master_transaksi(kode_barang, kode_user, total_barang) VALUE ('$kode_barang', $kode_user, $total_harga)";
    mysqli_query($conn, $queryCreateTransaksi);

    // Mendapatkan ID transaksi
    $idTransaksiAktif = mysqli_insert_id($conn);

    // Mengembalikan array berisi data barang dan ID transaksi
    return [
        'data' => $data,
        'id_transaksi' => $idTransaksiAktif,
    ];
}


function selesaikanTransaksi($id)
{
    global $conn;
    $kode_barang = $_POST['kode_barang'];
    $alamat = $_POST['alamat'];
    $kode_pos = $_POST['kode_pos'];
    $total_baru = $_POST['totalBaru'];
    $dibayar = $_POST['dibayar'];
    $kembali = $_POST['kembali'];
    $queryUpdateTransaksi = "UPDATE master_transaksi SET lokasi = '$alamat', kode_pos = '$kode_pos', total_barang = $total_baru,  dibayar = $dibayar, kembali = $kembali, status = 'berhasil' WHERE id = $id";
    mysqli_query($conn, $queryUpdateTransaksi);
    $queryUpdateStok = "UPDATE master_barang SET stok = stok - 1, terjual = terjual + 1, rating = rating + 00.1 WHERE kode_barang = '$kode_barang'";
    mysqli_query($conn, $queryUpdateStok);
    $_SESSION['flash_message'] = [
        "header" => "Berhasil",
        "message" => "Berhasil Membeli, Barang Akan segera Dikirim Ke rumah Anda",
    ];
    header("Location:index.php");
    exit;
}

