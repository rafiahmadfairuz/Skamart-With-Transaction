-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 03, 2025 at 05:44 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skamart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` bigint NOT NULL,
  `kode_user` bigint NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `kode_user`, `kode_barang`, `quantity`) VALUES
(3, 1, '6456434', 14),
(6, 1, '9999', 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_barang`
--

CREATE TABLE `master_barang` (
  `kode_barang` varchar(255) NOT NULL,
  `kode_kategori` bigint NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `rating` float NOT NULL DEFAULT '0',
  `diskon` float NOT NULL,
  `gambar_barang` text NOT NULL,
  `stok` bigint NOT NULL,
  `varian` varchar(255) NOT NULL,
  `harga` bigint NOT NULL,
  `terjual` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_barang`
--

INSERT INTO `master_barang` (`kode_barang`, `kode_kategori`, `nama_barang`, `deskripsi`, `satuan`, `rating`, `diskon`, `gambar_barang`, `stok`, `varian`, `harga`, `terjual`) VALUES
('1111', 1, 'Lays', '       Lays adalah merek keripik kentang yang terkenal dengan rasa gurih dan renyahnya Berikut adalah beberapa deskripsi tentang Lays \r\nAsal\r\nLays berasal dari Amerika Serikat dan merupakan nama perusahaan yang mendirikan merek keripik tersebut', 'Kg', 1.2, 90, '6776d3405635e7.56263744.png,6776d340565587.94080783.png,6776d340566ec0.93335008.png,6776d340568473.27007628.png,6776d340569a23.66475844.jpg,6776d34056b1e6.09972977.jpg', 118, 'Original', 11459, 4),
('4354', 5, 'Brokoli', '  22323', 'Kg', 0.1, 70, '6776d3494177b9.94224098.jpg,6776d349419914.44577962.jpg,6776d34941b072.13756262.jpg,6776d34941c6f0.99595146.jpg,6776d34941e1b5.72645709.jpg,6776d349420b61.25082863.jpg', 7655, 'Coklat', 19918, 2),
('55865', 4, 'Jeruk', ' 123314324', 'Kg', 0, 12, '6776d35ea92e36.78022196.jpg,6776d35ea957e2.56501382.jpg,6776d35ea97013.33680022.jpg,6776d35ea98606.36114347.jpg,6776d35ea9a1a6.92420063.jpg,6776d35ea9b647.00860002.jpg', 1233, 'Coklat', 19988, 0),
('64564', 2, 'Le Minerale', '   eweqeqeqe', 'Pcs', 0, 70, '6776d3685a3cc3.55800434.png,6776d3685a6490.08692814.png,6776d3685a8184.88596632.png,6776d3685a96a7.84070715.png,6776d3685aab06.52177536.jpg,6776d3685ac022.20491350.jpg', 123, 'Coklat', 78884, 0),
('6456434', 5, 'Brokoli', '   3213', 'Kg', 0, 32, '6776d370604f50.50574394.png,6776d370607a44.64119004.png,6776d370661341.35868761.png,6776d370663101.33146281.jpg,6776d3706647f3.49689041.jpg,6776d370665e56.16975551.jpg', 32, 'Coklat', 19936, 0),
('9999', 1, 'Le Minerale', '  ', 'Kg', 0, 70, '6776d3521ccbd9.60827867.jpg,6776d3521cec50.02375625.jpg,6776d3521d0599.50382131.jpg,6776d3521d1d42.58878686.jpg,6776d3521d34e7.78552961.jpg,6776d3521d4ba9.48534175.png', 0, 'Coklat', 199930, 2);

-- --------------------------------------------------------

--
-- Table structure for table `master_kategori`
--

CREATE TABLE `master_kategori` (
  `kode_kategori` bigint NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_kategori`
--

INSERT INTO `master_kategori` (`kode_kategori`, `nama`) VALUES
(1, 'Jajanan'),
(2, 'Minuman'),
(3, 'Buah'),
(4, 'Sayuran'),
(5, 'Bumbu'),
(6, 'Kebutuhan Harian');

-- --------------------------------------------------------

--
-- Table structure for table `master_transaksi`
--

CREATE TABLE `master_transaksi` (
  `id` bigint NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `kode_user` bigint NOT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kode_pos` varchar(255) DEFAULT NULL,
  `total_barang` int NOT NULL,
  `dibayar` int DEFAULT NULL,
  `kembali` int DEFAULT NULL,
  `status` enum('pending','berhasil','gagal') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_transaksi`
--

INSERT INTO `master_transaksi` (`id`, `kode_barang`, `kode_user`, `lokasi`, `kode_pos`, `total_barang`, `dibayar`, `kembali`, `status`) VALUES
(34, '1111', 1, NULL, NULL, 11619, NULL, NULL, 'pending'),
(35, '1111', 1, NULL, NULL, 11619, NULL, NULL, 'pending'),
(36, '1111', 1, 'Krian', '1234', 16619, 231231, 214612, 'berhasil'),
(37, '55865', 1, 'Krian', '2345', 24988, 4324234, 4299246, 'berhasil'),
(38, '6456434', 1, NULL, NULL, 19936, NULL, NULL, 'pending'),
(39, '64564', 1, NULL, NULL, 0, NULL, NULL, 'pending'),
(40, '6456434', 1, NULL, NULL, 19936, NULL, NULL, 'pending'),
(41, '9999', 1, 'Krian', '2134', 204987, 3131313, 2926326, 'berhasil'),
(42, '4354', 1, 'Krian', '43324', 25988, 4344234, 4318246, 'berhasil'),
(43, '9999', 1, 'Krian', '3213', 204987, 31223123, 31018136, 'berhasil'),
(44, '1111', 1, NULL, NULL, 11549, NULL, NULL, 'pending'),
(45, '1111', 1, 'Krian', '5435', 16459, 5435345, 5418886, 'berhasil'),
(46, '1111', 1, 'Krian', '4234', 16459, 4324234, 4307775, 'berhasil'),
(47, '1111', 1, 'Krian', '4324', 16459, 424242, 407783, 'berhasil'),
(48, '1111', 1, 'Krian', '4234', 16459, 432423, 415964, 'berhasil'),
(49, '4354', 1, 'Krian', '4324', 24918, 312313, 287395, 'berhasil');

-- --------------------------------------------------------

--
-- Table structure for table `master_user`
--

CREATE TABLE `master_user` (
  `kode_user` bigint NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_user`
--

INSERT INTO `master_user` (`kode_user`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'rafi', 'rafi@gmail.com', '$2y$10$6OG0jrWEyMt0vqETWlB3Geq3OCUfFz2sHIhAG8UcV70njicOCtpnW', '2025-01-02 17:41:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_barang` (`kode_barang`),
  ADD KEY `kode_user` (`kode_user`);

--
-- Indexes for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD UNIQUE KEY `kode_barang_unique` (`kode_barang`),
  ADD KEY `kode_kategori` (`kode_kategori`);

--
-- Indexes for table `master_kategori`
--
ALTER TABLE `master_kategori`
  ADD PRIMARY KEY (`kode_kategori`);

--
-- Indexes for table `master_transaksi`
--
ALTER TABLE `master_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_barang_transaksi` (`kode_barang`),
  ADD KEY `kode_user_tran` (`kode_user`);

--
-- Indexes for table `master_user`
--
ALTER TABLE `master_user`
  ADD PRIMARY KEY (`kode_user`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `master_kategori`
--
ALTER TABLE `master_kategori`
  MODIFY `kode_kategori` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `master_transaksi`
--
ALTER TABLE `master_transaksi`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `master_user`
--
ALTER TABLE `master_user`
  MODIFY `kode_user` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `kode_barang` FOREIGN KEY (`kode_barang`) REFERENCES `master_barang` (`kode_barang`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `kode_user` FOREIGN KEY (`kode_user`) REFERENCES `master_user` (`kode_user`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD CONSTRAINT `kode_kategori` FOREIGN KEY (`kode_kategori`) REFERENCES `master_kategori` (`kode_kategori`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `master_transaksi`
--
ALTER TABLE `master_transaksi`
  ADD CONSTRAINT `kode_barang_transaksi` FOREIGN KEY (`kode_barang`) REFERENCES `master_barang` (`kode_barang`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `kode_user_tran` FOREIGN KEY (`kode_user`) REFERENCES `master_user` (`kode_user`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
