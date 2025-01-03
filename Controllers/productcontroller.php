<?php
require_once 'Models/productmodel.php';

function tampilkanDetailProduk($id)
{
    global $conn; 
    $product = getProductById($conn, $id);
    if ($product) {
        require 'detailProduct.php';
    } else {
        echo "Produk tidak ditemukan!";
    }
}

function tampilkanSemuaProduk()
{
    global $conn;
    require_once 'Models/productmodel.php';
    $products = getAllProducts($conn);

    if ($products) {
        require 'Components/DisplayProduk.php';
    }
}

function produkYangSudahDiFilter($conn, $minHarga, $maxHarga, $rangeStok, $ratingOrder, $category, $keyword)
{
    return getFilteredProducts($conn, $minHarga, $maxHarga, $rangeStok, $ratingOrder, $category, $keyword);
}

function produkTerlaris()
{
    global $conn;
    return getProdukTerlaris($conn);
}

function diskon70()
{
    global $conn;
    return getProdukDiskon($conn);
}