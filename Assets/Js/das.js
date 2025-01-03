// Fungsi untuk memperbarui nomor gambar carousel
function updateImageNumber() {
  const $carousel = $("#carouselExampleIndicators");
  const totalSlides = $carousel.find(".carousel-item").length;
  const activeIndex = $carousel.find(".carousel-item.active").index();
  $("#carouselImageNumber").text(`Image ${activeIndex + 1} / ${totalSlides || 0}`);
}

$("#imageInput").on("change", function () {
  const files = this.files;
  const filesLength = files.length;
  $("#carouselIndicators, #carouselInner").empty();
  $("#carouselImageNumber").text("Image 0 / 0");
  const validImageTypes = ["image/jpeg", "image/png"];
  let allImagesValid = true;
  
  $.each(files, function (index, file) {
    const reader = new FileReader(); //agar bisa membaca file, mengkonversi menjadi format yang sesuai (seperti data URL atau teks), dan melakukan manipulasi 
    reader.onload = function (event) {
      const indicatorClass = index === 0 ? "active" : "";
      const itemClass = index === 0 ? "carousel-item active" : "carousel-item";
      $("#carouselIndicators").append(
        `<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="${index}" class="${indicatorClass}" aria-current="${index === 0 ? "true" : "false"}" aria-label="Slide ${index + 1}"></button>`
      );
      $("#carouselInner").append(
        `<div class="${itemClass}">
          <img src="${event.target.result}" class="d-block w-100 gambar zoom" alt="Image ${index + 1}">
        </div>`
      );
      if (index === filesLength - 1) {
        $("#carouselExampleIndicators").carousel(0);
        updateImageNumber();
      }
    };
    reader.readAsDataURL(file);
  });
});

$("#carouselExampleIndicators").on("slid.bs.carousel", updateImageNumber);

updateImageNumber();


$(document).on("mouseenter mousemove mouseleave", ".zoom", function (e) {
  let $this = $(this);
  if (e.type === "mouseenter") {
    $this.addClass("zoomed");
  } else if (e.type === "mousemove" && $this.hasClass("zoomed")) {
    let { left, top } = $this.offset();
    let { width, height } = $this[0].getBoundingClientRect();
    let mouseX = e.pageX - left;
    let mouseY = e.pageY - top;
    let originX = (mouseX / width) * 50;
    let originY = (mouseY / height) * 50;

    $this.css("transform-origin", `${originX}% ${originY}%`);
  } else if (e.type === "mouseleave") {
    $this.removeClass("zoomed").css("transform-origin", "center center");
  }
});

