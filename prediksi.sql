-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2023 at 02:14 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prediksi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_lengkap`, `username`, `password`) VALUES
(1, 'Administrator', 'admin', '$2y$10$KnNA4XrKFh6M0P0jJ3uLbeoINVxtZ8aK1hCpDiiOSbuYEV52tJlWG'),
(4, 'Ika Nofita', 'Ika', '$2y$10$tuU1EClp59TWAGbztxXaDeZKggxBy1hs.JGnq.ZIwyH/hAQ7QXpaS'),
(5, 'Heri Kuswanto', 'Heri', '$2y$10$LhveWeuxuLRdVtuQY8ajQOFGldtLLOJcw0V3/SKuVLCC07Ae5Pm.u');

-- --------------------------------------------------------

--
-- Table structure for table `hasil`
--

CREATE TABLE `hasil` (
  `id_hasil` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `bulan` varchar(10) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `orders` int(11) NOT NULL,
  `shipment` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `produksi_prediksi` int(11) NOT NULL,
  `produksi_aktual` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hasil`
--

INSERT INTO `hasil` (`id_hasil`, `id_produk`, `bulan`, `tahun`, `orders`, `shipment`, `stok`, `produksi_prediksi`, `produksi_aktual`) VALUES
(2, 1, 'SEPTEMBER', '2022', 350, 350, 0, 345, 345),
(3, 2, 'SEPTEMBER', '2022', 300, 300, 0, 283, 280),
(5, 6, 'SEPTEMBER', '2022', 500, 545, 0, 415, 410),
(6, 9, 'SEPTEMBER', '2022', 200, 200, 10, 305, 305),
(8, 3, 'SEPTEMBER', '2022', 425, 425, 40, 349, NULL),
(9, 3, 'SEPTEMBER', '2022', 425, 425, 40, 349, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`) VALUES
(1, 'Bolu Siliwangi Klasik'),
(2, 'Bolu Siliwangi Spesial'),
(3, 'Kue Balok Lumer Ki Raden'),
(4, 'Bolu Roll'),
(5, 'Pie Brownies'),
(6, 'Fudgy Brownies Mini'),
(7, 'Lekker Holand'),
(8, 'Roti Unyil'),
(9, 'Bolen Pisang Coklat'),
(10, 'Kue Ketawa Kering'),
(11, 'Kucang Ori'),
(12, 'Kucang Coklat'),
(13, 'Kucang Mix'),
(14, 'Kue Pia Pinang Mas'),
(15, 'Baso Tulang Rangu Sami Raos'),
(16, 'Baso Aci Geprek Sami Raos'),
(17, 'Lapis Legit'),
(18, 'Kebablasan'),
(19, 'Naget Champ'),
(20, 'Nugget Salam 500g'),
(21, 'Yoghurt Stik'),
(22, 'Dimsum Isi'),
(23, 'Perfectio Spicy Wings 500g'),
(24, 'Chicken Karage Perfectio'),
(25, 'Nugget Kanzler'),
(26, 'Anggur Crimson'),
(27, 'Apel Fuji '),
(28, 'Pir Century'),
(29, 'Jelly Inaco'),
(30, 'Stik Bawang Dzanilla'),
(31, 'Waffer Kogen'),
(32, 'Kolang Kaling'),
(33, 'Bakso Warisan'),
(34, 'Nugget Ayam Viva Dahlia'),
(35, 'Cireng Mercon Isi 10'),
(36, 'Nugget So Eco 1kg'),
(37, 'Nugget Bartoz 500g'),
(38, 'Chicken Katsu Hokben'),
(39, 'Pempek Ciksumar'),
(40, 'Lemonilo kuah '),
(41, 'Bawang Goreng Premium 200g'),
(42, 'Saos Hot1'),
(43, 'Durian Montong 500g'),
(44, 'Edo Donat Kentang'),
(45, 'Chococrunch Simba'),
(46, 'Kerupuk Kulit Razka'),
(47, 'Aneka Kerupuk Queen Jaya'),
(48, 'Kentang Mustofa 500g'),
(49, 'Singkong Balado 500g'),
(50, 'MI Richeese'),
(51, 'Paket Belfoods'),
(52, 'Otak Otak Mentari'),
(53, 'Nastar Klasik'),
(54, 'Nugget So NIce 250g'),
(55, 'Abon Karwati'),
(56, 'Fanta 250ml'),
(57, 'Santan Sasa'),
(58, 'Vitalia BUrger'),
(59, 'Ice Cream Box'),
(60, 'Susu Almond'),
(61, 'Sarden Brilian'),
(62, 'Beef Slice 500g'),
(63, 'Roti Burger Isi 6pcs '),
(64, 'Stik Bawang FWS'),
(65, 'Mariposa Snack Kentang'),
(66, 'Sabun Dettol'),
(67, 'Sitrun'),
(68, 'Topron'),
(69, 'Molto 1L'),
(70, 'Shampoo Sunsilk'),
(71, 'Baso Aci Ayam Suir'),
(72, 'Ayam Potong So Good'),
(73, 'Pangsit Tulang Rangu'),
(74, 'Sabun Colek Kiloan'),
(75, 'Kerupuk Kemplang Yunes'),
(76, 'Sunlight 650ml'),
(77, 'Mawar Laundry 1L'),
(78, 'Paket Teh Celup'),
(79, 'Tisu Jolly 200sheet'),
(80, 'Rinso Sachet'),
(81, 'Roti Bagelen Kering'),
(82, 'Seblak Kencur'),
(83, 'Kerupuk Slondok'),
(84, 'Stik Gabus 900g'),
(85, 'Jeruk Santang'),
(86, 'Es Teler Sultan'),
(87, 'Rinso Matic 1,65ml'),
(88, 'Paket Sosro + Free Tumbler'),
(89, 'Pancake Durian'),
(90, 'Pilus Ori 250g'),
(91, 'Kelengkeng'),
(92, 'Anggur Red Globe'),
(93, 'Kentang Marquise'),
(94, 'Waffer Khong Guan Classic'),
(95, 'Lollipop Mini'),
(96, 'Jus Durian 100ml'),
(97, 'Usus Ori'),
(98, 'Usus Balado'),
(99, 'Roti Maryam Isi 5pcs'),
(100, 'Lemonilo Goreng'),
(101, 'Permen Asem 400g'),
(102, 'Permen Jahe 380g'),
(103, 'Paket Shampo isi 20 Sachet'),
(104, ' Kiwi Fiola'),
(105, 'Mariposa Kentang Keju'),
(106, 'Mariposa Kentang Balado'),
(107, 'Telur Gabus 900g'),
(108, 'Masker Duckbil isi 50pcs'),
(109, 'Masker Earloop isi 50pcs'),
(110, 'Masker KF94 Warna isi 10pcs'),
(111, 'Masker KF94 Warna Hitam & Putih isi 10pcs'),
(112, 'Kripik Tempe 350g'),
(113, 'Basreng Ori 120g'),
(114, 'Basreng Pedes 120g'),
(115, 'Lemari Naiba Nacase Boston 7205 BBL'),
(116, 'Botol NIce 400ml'),
(117, 'Botol Love'),
(118, 'Botol Gemoy'),
(119, 'Teapot Warna'),
(120, 'Botol Gradasi 1L'),
(121, 'Keset Anyam'),
(122, 'Bolde Supermop SOLANA'),
(123, 'Cetakan Waffle Mini'),
(124, 'Payung 3 Dimensi'),
(125, 'Dispenser Beras 10kg'),
(126, 'Kipas Berdiri TD'),
(127, 'Automatic Water Pump'),
(128, 'Rantang Piknik Golden Sunkist'),
(129, 'Dispenser Golden Sunkist'),
(130, 'STB Dcolar'),
(131, 'Cleanser Pembersih Panci'),
(132, 'Teko Listrik Yamakawa 1,8L'),
(133, 'Handuk Microfiber Motif'),
(134, 'Rak Apartemen HC'),
(135, 'Hanger Kawat Haka'),
(136, 'Dispenser Tami-1136'),
(137, 'Regulator Caisar Premium'),
(138, 'Food Cover 5 susun'),
(139, 'Food Cover 4 Susun'),
(140, 'Balmut'),
(141, 'Magic Com Miyako MCM 638'),
(142, 'Magic Com Cosmos CRJ 3237'),
(143, 'Magic Com Cosmos CRJ 5208'),
(144, 'Rice Cooker Cosmos CRJ-323S'),
(145, 'Magic Com Cosmos CRJ 5508'),
(146, 'Magic Com Cosmos CRJ 6301'),
(147, 'Magic Com Cosmos CRJ 9308'),
(148, 'Magic Com Cosmos CRJ 6023N'),
(149, 'Cutlery Tray Rovega'),
(150, 'Blender Daging Stainless Texania'),
(151, 'Kipas 3 in 1 TD'),
(152, 'Keranjang Laundry'),
(153, 'Fry Pan Supra Rosemary 18cm'),
(154, 'Fry Pan Supra Rosemary 22cm'),
(155, 'Vitalia Tea Set Teko Cangkir');

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

CREATE TABLE `training` (
  `id_training` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `bulan` varchar(10) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `orders` int(11) NOT NULL,
  `shipment` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `produksi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `training`
--

INSERT INTO `training` (`id_training`, `id_produk`, `bulan`, `tahun`, `orders`, `shipment`, `stok`, `produksi`) VALUES
(1, 1, 'JANUARI', '2022', 200, 200, 60, 180),
(2, 1, 'FEBRUARI', '2022', 170, 170, 40, 150),
(3, 1, 'MARET', '2022', 220, 200, 20, 180),
(4, 1, 'APRIL', '2022', 120, 120, 0, 150),
(5, 1, 'MEI', '2022', 180, 180, 30, 170),
(6, 1, 'JUNI', '2022', 300, 300, 20, 300),
(7, 1, 'JULI', '2022', 420, 410, 20, 390),
(8, 1, 'AGUSTUS', '2022', 500, 500, 0, 530),
(9, 2, 'JANUARI', '2022', 260, 260, 30, 250),
(10, 2, 'FEBRUARI', '2022', 200, 200, 20, 200),
(11, 2, 'MARET', '2022', 180, 170, 20, 150),
(12, 2, 'APRIL', '2022', 250, 250, 0, 280),
(13, 2, 'MEI', '2022', 150, 150, 30, 140),
(14, 2, 'JUNI', '2022', 230, 230, 30, 225),
(15, 2, 'JULI', '2022', 370, 350, 25, 325),
(16, 2, 'AGUSTUS', '2022', 400, 400, 0, 420),
(17, 3, 'JANUARI', '2022', 300, 300, 10, 330),
(18, 3, 'FEBRUARI', '2022', 250, 250, 40, 240),
(19, 3, 'MARET', '2022', 280, 280, 30, 290),
(20, 3, 'APRIL', '2022', 320, 300, 40, 260),
(21, 3, 'MEI', '2022', 250, 250, 0, 300),
(22, 3, 'JUNI', '2022', 300, 300, 50, 250),
(23, 3, 'JULI', '2022', 360, 360, 0, 400),
(24, 3, 'AGUSTUS', '2022', 330, 330, 40, 300),
(25, 6, 'JANUARI', '2022', 200, 200, 0, 250),
(26, 6, 'FEBRUARI', '2022', 280, 250, 50, 200),
(27, 6, 'MARET', '2022', 350, 350, 0, 380),
(28, 6, 'APRIL', '2022', 270, 270, 30, 250),
(29, 6, 'MEI', '2022', 250, 250, 10, 245),
(30, 6, 'JUNI', '2022', 420, 410, 5, 405),
(31, 6, 'AGUSTUS', '2022', 400, 400, 0, 415),
(32, 9, 'JANUARI', '2022', 200, 200, 0, 220),
(33, 9, 'FEBRUARI', '2022', 230, 230, 20, 220),
(34, 9, 'MARET', '2022', 250, 250, 10, 250),
(35, 9, 'APRIL', '2022', 270, 270, 10, 265),
(36, 9, 'MEI', '2022', 300, 300, 5, 315),
(37, 9, 'JUNI', '2022', 320, 300, 20, 280),
(38, 9, 'JULI', '2022', 350, 350, 0, 360),
(39, 9, 'AGUSTUS', '2022', 380, 380, 10, 390);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`id_training`),
  ADD KEY `id_produk` (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `id_training` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `hasil_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `training`
--
ALTER TABLE `training`
  ADD CONSTRAINT `training_ibfk_3` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
