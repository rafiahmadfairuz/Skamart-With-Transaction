/*
updateContainerClass() = digunakan hanya untuk menambah dan menghapus class, ini agar responsif lebih bagus
*/
function updateContainerClass() {
  if ($(window).width() < 1200) {
    $("#promo.container").removeClass("container");
    $("#banner.container-md").removeClass("container-md");
    $("#carousel-dalam.rounded-4").removeClass("rounded-4");
    $(".promo").addClass("container-fluid");
    $(".brand.container").removeClass("container");
    $(".brand").addClass("container-fluid");
  } else {
    $("#carousel-dalam").addClass("rounded-4");
    $("#banner").addClass("container-md");
    $(".promo.container-fluid").removeClass("container-fluid");
    $("#promo").addClass("container");
    $(".brand.container-fluid").removeClass("container-fluid");
    $(".brand").addClass("container");
  }
  if ($(window).width() < 992) {
    $("#beranda.container").removeClass("container");
    $("#beranda").addClass("container-fluid");
  } else {
    $("#beranda.container-fluid").removeClass("container-fluid");
    $("#beranda").addClass("container");
  }
  if ($(window).width() < 400) {
    $("#pf.container-fluid").removeClass("container-fluid");
    $("#footer.rounded-top-5").removeClass("rounded-top-5");
  } else {
    $("#pf").addClass("container-fluid");
    $("#footer").addClass("rounded-top-5");
  }
}
$(window).resize(function () { // bila ada perubahan ukuran layar otomatis memanggil function updateContainerClass(), dnaa mengeksekusinya
  updateContainerClass();
});


// Menambahkan event listener pada elemen dengan kelas "zoom"
// Event yang didengar / yang di deteksi: "mouseenter", "mousemove", dan "mouseleave"
$(document).on("mouseenter mousemove mouseleave", ".zoom", function (e) {
  let $this = $(this); // Elemen saat ini yang memicu event

  if (e.type === "mouseenter") {
    // Ketika kursor masuk ke elemen .zoom
    $this.addClass("zoomed"); // Tambahkan kelas "zoomed" untuk efek zoom (misalnya, memperbesar gambar)
  } else if (e.type === "mousemove" && $this.hasClass("zoomed")) {
    // Ketika kursor bergerak di atas elemen dan elemen memiliki kelas "zoomed"
    let { left, top } = $this.offset(); // Posisi elemen relatif terhadap dokumen
    let { width, height } = $this[0].getBoundingClientRect(); // Ukuran elemen dalam piksel
    let mouseX = e.pageX - left; // Posisi X kursor relatif terhadap elemen
    let mouseY = e.pageY - top;  // Posisi Y kursor relatif terhadap elemen
    let originX = (mouseX / width) * 50; // Menghitung titik fokus horizontal dalam format persentase
    let originY = (mouseY / height) * 50; // Menghitung titik fokus vertikal dalam format persentase

    // Mengatur titik fokus zoom berdasarkan posisi kursor
    $this.css("transform-origin", `${originX}% ${originY}%`);
  } else if (e.type === "mouseleave") {
    // Ketika kursor meninggalkan elemen
    $this
      .removeClass("zoomed") // Hapus kelas "zoomed" untuk menghentikan efek zoom
      .css("transform-origin", "center center"); // Reset titik fokus ke tengah elemen
  }
});

// bila class img-kecil di click, maka....
$(".img-kecil").on("click", function () {
  // Periksa apakah elemen yang diklik memiliki kelas "img-kecil"
  if ($(this).hasClass("img-kecil")) {
    // Ganti  src img-utama dengan src img-kecil yang sedang di klik
    $(".img-utama").attr("src", $(this).attr("src"));
  }
});


function applyFilters() {
  // Ambil nilai input dari elemen HTML dengan id atau class tertentu:
  var minHarga = $("#minHarga").val(); // ambil nilainya satu per satu
  var maxHarga = $("#maxHarga").val(); 
  var rangeStok = $("#rangeStok").val(); 
  var ratingOrder = $("#ratingOrder").val(); 
  var category = $(".kotak-kategori.terpilih").data("category"); 
  var keyword = $("#search-input").val(); 

  // request ajax ke server
  $.ajax({
    url: "../../index.php", // endpoint yang dipanggil
    method: "GET", // method get
    data: {
      // Kirim semua parameter filter yang diambil sebelumnya ke server.
      minHarga: minHarga,         // Filter minimum harga.
      maxHarga: maxHarga,         // Filter maksimum harga.
      rangeStok: rangeStok,       // Filter stok.
      ratingOrder: ratingOrder,   // Filter urutan rating.
      category: category,         // Filter kategori produk.
      search: keyword,            // Filter berdasarkan kata kunci pencarian.
    },
    success: function (response) {
      // Jika permintaan berhasil, ganti konten elemen dengan id "displayProduk" dengan respon yang dikembalikan server
      $("#displayProduk").html(response);
    },
    error: function (xhr, status, error) {
      console.error(error); // bila eror tampilkan di console
    },
  });
}


// bila button dengan id resetFilter di Click, maka akan mereset value dari input yang ada di dalam ini
$("#resetFilter").on("click", function () {
  $("#minHarga").val(""); // reset value input minharga
  $("#maxHarga").val(""); // reset value max harga
  $("#rangeStok").val("500"); // set value rangestok menjadi 500(defaultnya)
  $("#ratingOrder").val("asc"); // diurutkan menjadi ascending
  $("#search-input").val(""); // reset input search
  $(".kotak-kategori").removeClass("terpilih"); // menghapus class terpilih dari button kategori(digunakan untuk filter berdasarkan kategori)
  applyFilters(); // lalu memanggil function applyFilters() dengan value diatas
});


// jika minHarga, maxHarga, rangeStok, ratingOrder, kotak teredteksi ada inputan atau di ubah valuenya atau di click maka menjalankan function 
$("#minHarga, #maxHarga, #rangeStok, #ratingOrder, .kotak").on(
  "input change click",
  function () {
    if ($(this).hasClass("kotak")) { // bila yang di klik punya class kotak, maka
      $(".kotak-kategori").removeClass("terpilih"); // semua dengan class kottak-kategori yang punya class terpilih dihapus
      $(this).find(".kotak-kategori").addClass("terpilih"); // sedangkan kotak yang sedang di klik ditambahkan class terpilih
    }
    applyFilters();  // lalu memanggil function applyFilters() 
  }
);

$("#search-input").on("input", function () {
  var keyword = $(this).val(); // mengambil inputan pengguna
  if (keyword.length > 0) { // jika panjang inputan lebih dari 0 atau tidak kosong
    applyFilters(); //  panggil function applyFilters() 
  } else {
    getAllProducts(); // jika kosong maka panggil function getAllProducts()
  }
});

function getAllProducts() { 
  // request ajax
  $.ajax({
    url: "../../index.php", // endpoint yang di tembak
    method: "GET", // pakai method get
    data: {
      allProducts: true, // parameter getnya adalah allProduct
    },
    success: function (response) {
      // Jika permintaan berhasil, ganti konten elemen dengan id "displayProduk" dengan respon yang dikembalikan server
      $("#displayProduk").html(response);
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

function addToCart(productId, userId) {
  // - productId: ID produk yang ingin ditambahkan ke keranjang.
  // - userId: ID pengguna yang sedang login
  $.ajax({
    url: "Controllers/cartcontroller.php", // Endpoint
    type: "POST", // Metode POST
    data: { 
      action: "add", // Parameter "action" memberi tahu server bahwa ini adalah permintaan untuk menambahkan produk.
      product_id: productId, // Kirim ID produk yang ingin ditambahkan.
      user_id: userId,       // Kirim ID pengguna untuk menghubungkan produk dengan pengguna.
    },
    dataType: "json", // respon yang diharapkan dari server
    success: function (response) {
      // bila berhasil...
      console.log(response); // console untuk debugging saja / cek saja
      if (response.success) {
        // Jika server mengembalikan respons sukses:
        updateCart(response.product); // Panggil fungsi untuk memperbarui tampilan keranjang dengan produk yang baru ditambahkan.
        updateCartCount(response.cart_count); // Perbarui jumlah total item di keranjang (biasanya ditampilkan di ikon keranjang).

        // Tampilkan modal konfirmasi bahwa produk berhasil ditambahkan ke keranjang.
        const myModal = new bootstrap.Modal(
          document.getElementById("modalBerhasil") // Modal dengan ID "modalBerhasil" ditampilkan menggunakan Bootstrap.
        );
        myModal.show(); // tampilkan modal
      } else {
        alert("Gagal menambahkan produk ke keranjang."); 
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("Terjadi kesalahan. Coba lagi."); // bila ada eror dari server
    },
  });
}

function updateCart(product) {
  
  // Fungsi updateCart bertugas untuk memperbarui tampilan keranjang belanja.
  // Parameter:
  // - product: Objek yang berisi informasi tentang produk (seperti ID, nama, harga, varian, jumlah stok, jumlah yang dipesan, dll.).

  const existingItem = $(
    `#keranjang .cart-item[data-kode-barang="${product.kode_barang}"]`
  );
  // Periksa apakah produk dengan kode barang yang sama sudah ada di dalam keranjang.
  // Selector mencari elemen dengan class "cart-item" di dalam elemen dengan id "keranjang" yang memiliki atribut "data-kode-barang" sesuai dengan `product.kode_barang`.

  const gambarArray = product.gambar_barang.split(",");
  // Pisahkan string URL gambar menjadi array menggunakan koma (`,`) sebagai pemisah.
  // Biasanya digunakan jika ada beberapa gambar untuk produk, tetapi hanya gambar pertama yang akan digunakan di sini.

  if (existingItem.length > 0) {
    // Jika elemen produk sudah ada di keranjang (produk dengan kode barang yang sama ditemukan):
    existingItem.find(".jumlah").text(`X ${product.quantity}`);
    // Perbarui jumlah produk yang ditampilkan di keranjang.
  } else {
    // Jika produk belum ada di keranjang:
    const cartItem = `
            <div class="container-fluid border-bottom py-2 cart-item" data-kode-barang="${product.kode_barang}"  data-harga="${product.harga}">
                <!-- Wrapper untuk setiap item di keranjang -->
                <div class="d-flex justify-content-between">
                    <div class="d-flex column-gap-0 column-gap-sm-1 column-gap-md-5">
                        <!-- Kolom kiri: Gambar dan detail produk -->
                        <input type="checkbox" class="cart-checkbox" onchange="updateSelectedItems()">
                        <!-- Checkbox untuk memilih item -->
                        <div>
                            <img src="Assets/Image/uploads/${gambarArray[0]}" alt="Product Image">
                            <!-- Gambar produk pertama diambil dari gambarArray -->
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="cart-item-title">${product.nama_barang}</div>
                            <!-- Nama produk -->
                            <div class="cart-item-price text-secondary">Rp. ${product.harga}</div>
                            <!-- Harga produk -->
                            <div class="cart-item-price text-secondary">Varian: ${product.varian}</div>
                            <!-- Varian produk -->
                            <div class="cart-item-price text-secondary">Stok: ${product.stok}</div>
                            <!-- Stok produk -->
                        </div>
                    </div>
                    <div class="d-flex text-nowrap  align-items-center justify-content-center">
                        <!-- Kolom kanan: Jumlah produk dan tombol hapus -->
                        <p class="fw-bold jumlah fs-5">X ${product.quantity}</p>
                        <!-- Jumlah produk yang dipesan -->
                         <button class="btn w-100 mb-3" id="hapuscart" data-product-id="${product.id}">
                            <i class="bi fw-bold bi-trash3"></i>
                         </button>
                         <!-- Tombol untuk menghapus item dari keranjang -->
                    </div>
                </div>
            </div>
        `;
    $("#keranjang").append(cartItem);
    // Tambahkan elemen `cartItem` baru ke dalam elemen dengan id "keranjang".
  }
}


function updateSelectedItems() {
  let selectedItemCount = 0;
  let totalPrice = 0;
  $("#keranjang .cart-checkbox:checked").each(function () {
    // Mengambil elemen terdekat yang memiliki kelas 'cart-item' dari checkbox yang dipilih
    const cartItem = $(this).closest(".cart-item");

    // Mengambil harga item dari data atribut 'data-harga' pada elemen '.cart-item'
    const itemPrice = parseFloat(cartItem.data("harga")); // string jadi desimal

    // Mengambil jumlah item dari elemen dengan kelas '.jumlah' dan menghapus teks 'X '
    const itemQuantity = parseInt(  // string jadi angka bulat
        cartItem.find(".jumlah").text().replace("X ", "")
    );
    selectedItemCount += itemQuantity;
    totalPrice += itemPrice * itemQuantity;
  });
  $("#selectedItemsCount").text(`Selected Item (${selectedItemCount})`);
  $("#totalPrice").text(`Rp. ${totalPrice.toLocaleString()}`);
}

function tampilkanModalPembelian() {
  let selectedItems = [];
  let totalQuantity = 0;
  let totalPrice = 0;
  $("#keranjang .cart-checkbox:checked").each(function () {
    const cartItem = $(this).closest(".cart-item");
    const itemName = cartItem.find(".cart-item-title").text();
    const itemPrice = parseFloat(
      cartItem  // Menyimpan elemen cartItem (produk dalam keranjang) dalam variabel.
        .find(".cart-item-price")  // Mencari elemen dengan kelas "cart-item-price" dalam cartItem.
        .eq(0)  // Mengambil elemen pertama yang ditemukan
        .text()  // Mendapatkan teks (harga) dari elemen yang ditemukan.
        .replace("Rp. ", "")  // Menghapus bagian "Rp. " dari string harga (karena harga diawali dengan "Rp. ").
        .replace(",", "")  // Menghapus tanda koma (jika ada) dalam harga, seperti pada "1,000,000".
    );
        
    const itemQuantity = parseInt(
      cartItem.find(".jumlah").text().replace("X ", "")
    );

    selectedItems.push({ // push itu method array untuk menambah elemen ke dalam array di index terakhir
      name: itemName,
      quantity: itemQuantity,
      price: itemPrice,
    });

    totalQuantity += itemQuantity;
    totalPrice += itemPrice * itemQuantity;
  });

  if (selectedItems.length === 0) {
    alert("Pilih setidaknya satu item untuk melanjutkan pembelian.");
    return;
  }

  let modalItemsList = $("#modalItemsList");
  modalItemsList.empty();

  selectedItems.forEach((item) => {
    modalItemsList.append(
      `<li>${item.name} - ${item.quantity} pcs - Rp. ${(
        item.price * item.quantity
      ).toLocaleString()}</li>`
    );
  });

  $("#modalTotalQuantity").text(totalQuantity);
  $("#modalTotalPrice").text("Rp. " + totalPrice.toLocaleString());

  if (totalQuantity != 0 && totalQuantity != null) {
    const myModal = new bootstrap.Modal(
      document.getElementById("exampleModal")
    );
    myModal.show();
  }
}

$("#beliSekarangBtn").click(function () {
  tampilkanModalPembelian();
});

function updateCartCount(count) {
  if (count > 0) {
    $(".bi-cart2").append(
      '<span class="position-absolute  start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 13px; top: 16px;">' +
        count +
        "</span>"
    );
  } else {
    $(".bi-cart2 .badge").remove();
  }
}

$(document).on("click", "#hapuscart", function () {
  const productId = $(this).data("product-id");
  var iduser = sessionStorage.getItem("userId");
  const userId = iduser;

  if (productId && userId) {
    $.ajax({
      url: "Controllers/cartcontroller.php",
      type: "POST",
      data: {
        action: "remove",
        product_id: productId,
        user_id: userId,
      },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          $(`.cart-item[data-product-id="${productId}"]`).remove();
          fetchCartCount(userId);
          setTimeout(() => {
            location.reload();
          }, 90);
        } else {
          console.log("Gagal menghapus item dari keranjang.");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Gagal menghapus item dari keranjang.");
      },
    });
  } else {
    console.log("Error: Produk ID atau User ID tidak ditemukan.");
  }
});

function fetchCartCount(userId) {
  if (userId) {
    $.ajax({
      url: "Controllers/cartcontroller.php",
      type: "GET",
      data: { action: "count", user_id: userId },
      dataType: "json",
      success: function (response) {
        updateCartCount(response.cart_count);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error Status: " + textStatus);
        console.log("Error Thrown: " + errorThrown);
        console.log("Response Text: " + jqXHR.responseText);
      },
    });
  } else {
    console.log("Error: User ID is missing.");
  }
}

function fetchCart(userId) {
  $.ajax({
    url: "Controllers/cartcontroller.php", // URL untuk memproses keranjang
    type: "POST",
    data: { action: "get", user_id: userId },
    dataType: "json",
    success: function (response) {
      console.log(response);
      if (response.success) {
        response.cart_items.forEach(function (product) {
          updateCart(product);
        });
      } else {
        alert("Gagal mengambil data keranjang.");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error Status: " + textStatus);
      console.log("Error Thrown: " + errorThrown);
      console.log("Response Text: " + jqXHR.responseText);
      alert("Terjadi kesalahan. Coba lagi.");
    },
  });
}



// Simpan total awal (tanpa ongkos kirim)
let totalAwal = parseFloat($("#total").text()) || 0;

// Fungsi untuk menghitung total harga dengan ongkos kirim
function total(ongkos) {
  // Hitung total baru berdasarkan total awal + ongkos kirim
  let totalBaru = totalAwal + ongkos;

  // Perbarui elemen total dengan total baru
  $("#total").text(totalBaru);
  $("#totalBaru").val(totalBaru);
  
  // Perbarui logika uang kembalian jika ada
  let uangPembeli = parseFloat($("#inputPembayaran").val()) || 0;
  dapatkanUang(uangPembeli);
}

// Event listener untuk input radio kurir
$("input[name='kurir']").on("change", function () {
  // Cari elemen <label> terdekat, lalu temukan elemen <span> dengan class 'data-ongkos'
  let ongkos = $(this).closest("label").find(".data-ongkos").text();
  
  // Konversi nilai ke angka
  ongkos = parseInt(ongkos, 10) || 0;

  // Tampilkan biaya pengiriman yang dipilih
  $("#biayaPengiriman").text(ongkos);

  // Perbarui total harga
  total(ongkos);
});


// Fungsi untuk menghitung uang kembalian
function dapatkanUang(uangPembeli) {
  let total = parseFloat($("#total").text()) || 0; // Ubah total ke angka
  const bayar = $("#bayar");
  const inputKembalian = $("#kembalian"); // Ambil elemen input kembalian
  
  // Ubah uangPembeli ke angka
  uangPembeli = parseFloat(uangPembeli) || 0;

  if (total > uangPembeli) {
      bayar.prop("disabled", true); // Nonaktifkan tombol
      inputKembalian.val(""); // Kosongkan kembalian jika uang tidak cukup
  } else if (uangPembeli >= total) {
      let kembalian = uangPembeli - total;
      inputKembalian.val(kembalian); // Tetapkan nilai kembalian
      bayar.prop("disabled", false); // Aktifkan tombol
  }
}

// Event listener untuk input pembayaran
$("#inputPembayaran").on("input", function () {
  let uangPembeli = $(this).val();
  dapatkanUang(uangPembeli);
});





$(document).ready(function () {
  // ini dijalankan saat seluruh elemen dom siap, atau gampangnya website sudah load sepenuhnya
  var userId = sessionStorage.getItem("userId"); 
  // mengambil id pengguna yang sedang login dari sessionStorage

  // untuk memperbarui keranjang
  fetchCartCount(userId); 
  fetchCart(userId); 
});

