<div class="dropdown">
    <i class="bi bi-funnel fs-3" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
    <ul class="dropdown-menu dropdown-menu-light border shadow-sm p-3" style="width: 60vw;">
        <div class="w-100 d-flex justify-content-center justify-content-lg-end">
            <button type="button" class="btn btn-success" id="resetFilter">Reset Filter</button>
        </div>
        <hr class="text-success">
        <li class="mb-3">
            <label for="priceRange" class="form-label">Range Harga</label>
            <div class="d-flex align-items-center">
                <input type="number" name="hargarendah" class="form-control" id="minHarga" placeholder="Min" min="1" max="10000000" step="5000">
                <hr class="mx-2 w-25">
                <input type="number" name="hargatinggi" class="form-control" id="maxHarga" placeholder="Max" min="1" max="10000000" step="5000">
            </div>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li class="mb-3">
            <label for="stockRange" class="form-label">Range Stok</label>
            <div class="d-flex align-items-center">
                <input type="range" name="" class="form-range flex-grow-1" id="rangeStok" value="500" min="1" max="500">
                <span class="ms-2 text-nowrap" id="stokTerpilih">500</span>
            </div>
        </li>
        <li class="mb-3">
            <label for="ratingOrder" class="form-label">Urutkan Rating</label>
            <select id="ratingOrder" name="rating" class="form-select">
                <option value="">Pilih Urutan Rating</option>
                <option value="highest">Tertinggi</option>
                <option value="lowest">Terendah</option>
            </select>
        </li>
    </ul>
</div>