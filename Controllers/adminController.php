<?php
require_once "../Config/database.php";
$conn = connectDatabase();
function create()
{
    global $conn;
    $kode_barang = $_POST['kode_barang'];
    $kode_kategori = $_POST['kode_kategori'];
    $nama_barang = $_POST['nama_barang'];
    $d = $_POST['deskripsi'];
    $satuan = $_POST['satuan'];
    $diskon = $_POST['diskon'];
    $varian = $_POST['varian'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $hargaDiskon =  max(0, $harga - $diskon);
    $deskripsi = preg_replace("/[^a-zA-Z0-9\s]/", "", $d);


    if (!empty($_FILES['gambar']['name'][0])) {
        $jumlahFile = count($_FILES['gambar']['name']);
        if ($jumlahFile != 6) {
            $_SESSION['peringatan'] = 'Masukkan 6 Gambar!';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
        $ekstensiDiizinkan = ['jpg', 'jpeg', 'png'];
        $semuaGambar = [];
        for ($i = 0; $i < $jumlahFile; $i++) {
            $namaGambar = $_FILES['gambar']['name'][$i];
            $lokasiSementara = $_FILES['gambar']['tmp_name'][$i];
            $errorGambar = $_FILES['gambar']['error'][$i];
            $ekstensiGambar = strtolower(pathinfo($namaGambar, PATHINFO_EXTENSION));

            if (!in_array($ekstensiGambar, $ekstensiDiizinkan)) {
                $_SESSION['peringatan'] = 'Hanya file .jpg dan .png yang diperbolehkan.'; // kirim eror
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }
            if ($errorGambar === 0) { // jika eror gambar 0
                $namaBaru = uniqid('', true) . '.' . $ekstensiGambar;
                $tujuanPindah = '../Assets/Image/uploads/' . $namaBaru;
                if (move_uploaded_file($lokasiSementara, $tujuanPindah)) { // simpan dulu gambarnya di folder kita
                    $semuaGambar[] = $namaBaru; // masukkan 1 gambar ke variabel $semuaGambar
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan saat mengupload gambar.'; // kirim eror
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Ada kesalahan dengan file ' . $namaGambar; // kirim eror
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }

        $gambarString = implode(',', $semuaGambar);
        $queryInsertMasterGambar = "INSERT INTO master_barang(kode_barang, kode_kategori, nama_barang, varian, deskripsi, satuan, diskon, gambar_barang, stok, harga) VALUE ('$kode_barang',$kode_kategori,'$nama_barang', '$varian','$deskripsi','$satuan', $diskon, '$gambarString', $stok, $hargaDiskon)";
        if (!mysqli_query($conn, $queryInsertMasterGambar)) {
            $_SESSION['error'] = 'Terjadi kesalahan saat mengupload gambar.'; // kirim eror
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
        $_SESSION['flash_message'] = [
            "header" => "Berhasil",
            "message" => "Berhasil menambah Produk Baru",
        ];
        header("Location:../Admin/dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = 'Silahkan Upload Gambar';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

function getData($id)
{
    global $conn;
    $query = "SELECT * FROM master_barang WHERE kode_barang = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}


function update()
{
    global $conn;
    $kode_barang = $_POST['kode_barang'];
    $d = $_POST['deskripsi'];
    $diskon = $_POST['diskon'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $hargaDiskon =  max(0, $harga - $diskon) ;
    $deskripsi = preg_replace("/[^a-zA-Z0-9\s]/", "", $d);

    // Cek apakah ada file gambar yang diunggah
    if (!empty($_FILES['gambar']['name'][0])) {
        $jumlahFile = count($_FILES['gambar']['name']);
        if ($jumlahFile != 6) {
            $_SESSION['peringatan'] = 'Masukkan 6 Gambar!';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $ekstensiDiizinkan = ['jpg', 'jpeg', 'png'];
        $semuaGambar = [];

        // Ambil gambar lama dari database
        $queryGambarLama = "SELECT gambar_barang FROM master_barang WHERE kode_barang = '$kode_barang'";
        $result = mysqli_query($conn, $queryGambarLama);
        $dataGambarLama = mysqli_fetch_assoc($result);
        $gambarLamaArray = explode(',', $dataGambarLama['gambar_barang']);

        for ($i = 0; $i < $jumlahFile; $i++) {
            $namaGambar = $_FILES['gambar']['name'][$i];
            $lokasiSementara = $_FILES['gambar']['tmp_name'][$i];
            $errorGambar = $_FILES['gambar']['error'][$i];
            $ekstensiGambar = strtolower(pathinfo($namaGambar, PATHINFO_EXTENSION));

            if (!in_array($ekstensiGambar, $ekstensiDiizinkan)) {
                $_SESSION['peringatan'] = 'Hanya file .jpg dan .png yang diperbolehkan.';
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }

            if ($errorGambar === 0) {
                $namaBaru = uniqid('', true) . '.' . $ekstensiGambar;
                $tujuanPindah = '../Assets/Image/uploads/' . $namaBaru;

                if (move_uploaded_file($lokasiSementara, $tujuanPindah)) {
                    $semuaGambar[] = $namaBaru;
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan saat mengupload gambar.';
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Ada kesalahan dengan file ' . $namaGambar;
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }

        // Hapus gambar lama dari penyimpanan
        foreach ($gambarLamaArray as $gambarLama) {
            $pathGambarLama = '../Assets/Image/uploads/' . $gambarLama;
            if (file_exists($pathGambarLama)) {
                unlink($pathGambarLama);
            }
        }

        // Perbarui data dengan gambar baru
        $gambarString = implode(',', $semuaGambar);
        $queryUpdate = "UPDATE master_barang SET deskripsi = '$deskripsi', diskon = $diskon, gambar_barang = '$gambarString', stok = $stok, harga = $hargaDiskon WHERE kode_barang = '$kode_barang'";
    } else {
        // Perbarui data tanpa mengganti gambar
        $queryUpdate = "UPDATE master_barang SET deskripsi = '$deskripsi', diskon = $diskon, stok = $stok, harga = $hargaDiskon WHERE kode_barang = '$kode_barang'";
    }

    if (mysqli_query($conn, $queryUpdate)) {
        $_SESSION['flash_message'] = [
            "header" => "Berhasil",
            "message" => "Berhasil memperbarui Produk",
        ];
        header("Location: ../Admin/dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = 'Terjadi kesalahan saat memperbarui data.';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

function delete($id)
{
    global $conn;
    $query = "DELETE FROM master_barang WHERE kode_barang = $id";
    $_SESSION['flash_message'] = [
        "header" => "Berhasil",
        "message" => "Berhasil memperbarui Produk",
    ];
    header("Location: ../Admin/dashboard.php");
    exit;
}

function detail($id)
{
    global $conn;
    $query = "SELECT master_barang.*, master_kategori.nama FROM master_barang JOIN master_kategori ON master_barang.kode_kategori = master_kategori.kode_kategori WHERE master_barang.kode_barang = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function getAll()
{
    global $conn;
    $query = "SELECT master_barang.kode_barang, master_barang.nama_barang, master_barang.harga, master_kategori.nama FROM master_barang LEFT JOIN master_kategori ON master_barang.kode_kategori = master_kategori.kode_kategori";
    return mysqli_query($conn, $query);
    
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'create') {
        create();
    } else if ($_GET['action'] == 'update') {
        update();
    }
} else if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    delete($id);
}
