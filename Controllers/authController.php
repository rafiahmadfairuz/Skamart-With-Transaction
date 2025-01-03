<?php
// Mengimpor file konfigurasi database agar fungsi connectDatabase() dapat digunakan.
require_once "../config/database.php";

// Fungsi untuk memeriksa apakah pengguna sudah login.
function cek() {
    // Mengecek apakah session 'email' sudah diatur. 
    // Jika iya, kembalikan true; jika tidak, kembalikan false.
    return isset($_SESSION['email']) ? true : false;
}

// Fungsi untuk login pengguna.
function login() {
    // Membuat koneksi ke database.
    $conn = connectDatabase();

    // Mengambil data 'email' dan 'password' yang dikirimkan dari form login.
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek jika pengguna adalah admin dengan email dan password tertentu.
    if ($email === 'admin@gmail.com' && $password === '12345678') {
        // Jika admin, set session dengan data admin dan arahkan ke dashboard admin.
        $_SESSION['username'] = 'admin';
        $_SESSION['email'] = $email;
        $_SESSION['modal_header'] = "Sukses";
        $_SESSION['modal_message'] = "Selamat Datang Admin";
        header("Location: ../Admin/dashboard.php");
        exit();
    } else {
        // Jika bukan admin, cek email di tabel `master_user`.
        $stmt = $conn->prepare("SELECT * FROM master_user WHERE email=?");
        $stmt->bind_param("s", $email); // Menghindari SQL Injection dengan parameter binding.
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Jika email ditemukan, ambil datanya.
            $data = $result->fetch_assoc();
            // Verifikasi apakah password yang diinput sesuai dengan password di database.
            if (password_verify($password, $data['password'])) {
                // Jika password sesuai, set session dan arahkan ke halaman utama.
                $_SESSION['kode_user'] = $data['kode_user'];
                $_SESSION['username'] = $email;
                $_SESSION['flash_message'] = [
                    'header' => 'Sukses',
                    'message' => "Selamat Datang " . $data['username']
                ];
                header("Location: ../halamanutama.php");
                exit();
            } else {
                // Jika password tidak sesuai, tampilkan error dan kembalikan ke halaman sebelumnya.
                $_SESSION['errors'] = "Email/password tidak sesuai";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        } else {
            // Jika email tidak ditemukan, tampilkan error dan kembalikan ke halaman sebelumnya.
            $_SESSION['errors'] = "Email/password tidak sesuai";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}

// Fungsi untuk registrasi pengguna baru.
function register() {
    // Membuat koneksi ke database.
    $conn = connectDatabase();

    // Mengecek apakah data `username` dikirimkan dari form registrasi.
    if (isset($_POST['username'])) {
        $username = $_POST['username']; // Ambil data username.
        $email = $_POST['email'];       // Ambil data email.
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Enkripsi password menggunakan BCRYPT.

        // Cek apakah username atau email sudah ada di database.
        $stmt = $conn->prepare("SELECT * FROM master_user WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Jika username atau email sudah ada, tampilkan error dan kembalikan ke halaman sebelumnya.
            $_SESSION['errors'] = "Username atau Email sudah terdaftar";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            // Jika tidak ada duplikasi, masukkan data baru ke database.
            $stmt = $conn->prepare("INSERT INTO master_user (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                // Jika berhasil, tampilkan pesan sukses dan arahkan ke halaman sebelumnya.
                $_SESSION['flash_message'] = [
                    'header' => 'Berhasil',
                    'message' => 'Berhasil Mendaftar, Silahkan Login'
                ];
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                // Jika gagal memasukkan data, tampilkan error.
                $_SESSION['errors'] = "Terjadi kesalahan saat mendaftar, coba lagi nanti";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    }
}


function cekAdmin()
{
    if (cek()) {
        if ($_SESSION['username'] == "admin") {
            return true;
        } else {
            session_destroy();
            $_SESSION['flash_message'] = [
                'header' => 'Akses Ditolak',
                'message' => 'Anda Bukan Admin'
            ];
            header('Location:../Auth/login.php');
            exit;
        }
    } else {
        header('Location:../Auth/login.php');
        exit;
    }
}

function logout()
{
    session_start();
    session_unset();
    session_destroy();

    session_start();
    $_SESSION['flash_message'] = [
        'header' => 'Berhasil',
        'message' => 'Berhasil Logout'
    ];
    header('Location:../Auth/login.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == "login") {
    session_start();
    login();
} else if (isset($_GET['action']) && $_GET['action'] == "register") {
    session_start();
    register();
} else if(isset($_GET['action']) && $_GET['action'] == "logout") {
    logout();
}
