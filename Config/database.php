<?php
// function untuk menghubungkan web kita buat dengan database mysql.
function connectDatabase() {
    // Nama server tempat database berada (biasanya "localhost")
    $servername = "localhost";  
    
    // Nama pengguna database (defaultnya "root" untuk XAMPP atau Laragon).
    $username = "root";        
    
    // Password untuk pengguna database (defaultnya kosong jika menggunakan XAMPP atau Laragon).
    $password = "";            
    
    // Nama database yang akan digunakan (ganti sesuai dengan nama database Anda / yang kamu buat).
    $dbname = "skamart_db";        

    // buat koneksinya dengan memasukkan argumen yang dibutuhkan dengan memanggil class mysqli
    $conn = new mysqli($servername, $username, $password, $dbname);

    // cek berhasil kesambung apa gak
    if ($conn->connect_error) { 
        // jika tidak kesambung atau gagal, maka hentikan proggram dan menampilkan pesan eror
        die("Connection failed: " . $conn->connect_error); 
    }
    // jika berhasil maka yaang dikembalikan dari pemanggilan function ini adalah objek koneksi ke database, atau simpelnya kalau ingin berinteraksi dengan database maka tinggal panggil objek ini lalu lanjut query
    return $conn;
}
