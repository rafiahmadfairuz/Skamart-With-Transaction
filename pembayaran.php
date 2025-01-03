<?php 
session_start();  // Memulai sesi 
require_once "Controllers/paymentController.php";

if(isset($_GET['selesai'])){
    $idTransaksiAktif = $_GET['selesai'];
    selesaikanTransaksi($idTransaksiAktif);
} else {
    $result = buatOrder();
$harga = $result['data'];
$transaksiAktif = $result['id_transaksi'];


}

?>
<?php require_once "Components/Head-User.php"; ?>  <!-- Menampilkan komponen head --> 
<?php include 'Components/Navbar-User.php'; ?>   <!-- kalau ada kode seperti ini, itu artinya hanya menampilkan komponen. Kenapa dipisah?? tujuannya agar lebih rapi dan lebih jelas kalau ingin ngubah per komponen saja --> 
<div class="container">
    <div class="row mt-5">
        <div class="col-12">
            <h1 class="fw-bold text-decoration-underline">Pembayaran</h1>
            <p>Nama Produk Yang Dibeli : <b><?= $harga['nama_barang']?> </b>  </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <form action='?selesai=<?php echo $transaksiAktif; ?>' method="POST">
                <h3 class="fw-bold">Alamat Pengiriman</h3>
                <label class="w-100 mb-3">
                    Alamat lengkap <br>
                    <input type="text" name="alamat" class="form-control">
                </label>
                <label class="w-100 mb-3">
                    Kode POS <br>
                    <input type="number" name="kode_pos" class="form-control">
                </label>

                <h3 class="fw-bold mt-5">Kurir Pengiriman</h3>
                <label class="w-100 mb-3 border rounded p-2">
                    <input type="radio" name="kurir" >
                    <img src="Assets/Image/img/kurir-1.png">
                    <div class="float-end">+ IDR <span class="data-ongkos">5000</span></div>
                </label>
                <label class="w-100 mb-3 border rounded p-2">
                    <input type="radio" name="kurir">
                    <img src="Assets/Image/img/kurir-2.png">
                    <div class="float-end">+ IDR <span class="data-ongkos">6000</span></div>
                </label>
                <label class="w-100 mb-3 border rounded p-2">
                    <input type="radio" name="kurir">
                    <img src="Assets/Image/img/kurir-1.png">
                    <div class="float-end">+ IDR <span class="data-ongkos">22000</span> (Instan)</div>
                </label>
                <label class="w-100 mb-3 border rounded p-2">
                    <input type="radio" name="kurir">
                    <img src="Assets/Image/img/kurir-2.png">
                    <div class="float-end">+ IDR <span class="data-ongkos">23000</span> (Instan)</div>
                </label>

           
        </div>

        <div class="col-md-4 offset-md-1">
            <div class="card bayar">
                <div class="card-header bg-white">
                    <h3 class="fw-bold">Detail Pembayaran</h3>
                </div>
                <div class="card-body">
                    <div class="row mt-2 mb-2">
                        <div class="col-md"><small>Sub Total</small></div>
                        <div class="col-md">IDR <?= $harga['harga'] ?></div>
                    </div>
                    <div class="row mt-2 mb-2">
                        <div class="col-md"><small>Biaya pengiriman</small></div>
                        <div class="col-md">IDR <span id="biayaPengiriman">0</span></div>
                    </div>
                    <div class="row mt-2 mb-2">
                        <div class="col-md"><small>Total</small></div>
                        <div class="col-md" >IDR <span id="total"><?= $harga['harga'] ?></span></div>
                    </div>
                    <input type="hidden" name="totalBaru" id="totalBaru">
                    <input type="hidden" name="kode_barang" value="<?= $_GET['kode_barang']?>">
                </div>

            </div>
            <div class="card bayar my-3">
                <div class="card-header bg-white">
                    <h3 class="fw-bold">Input Pembayaran</h3>
                </div>
                <div class="card-body">
                    <label for="">Nominal Uang</label>
                   <input type="number" name="dibayar" class="form-control" id="inputPembayaran">
                </div>
                <div class="card-body">
                    <label for="">Kembalian</label>
                   <input type="number" name="kembali" class="form-control" id="kembalian" readonly>
                </div>
                <div class="card-footer">
                    <button type="submit" id="bayar" class="btn btn-lg btn-success w-100" disabled>Bayar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once "Components/Footer.php"; ?>
<?php require_once "Components/ClosingBodyUser.php"; ?>

