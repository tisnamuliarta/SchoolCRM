-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 02, 2018 at 03:33 PM
-- Server version: 5.7.18
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_kegiatan`
--

CREATE TABLE `tb_kegiatan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_kelas` int(10) UNSIGNED DEFAULT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `deskripsi` text,
  `tgl` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kegiatan`
--

INSERT INTO `tb_kegiatan` (`id`, `id_kelas`, `nip`, `nama`, `deskripsi`, `tgl`) VALUES
(4, 6, '1010101', 'Menulis', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-04'),
(5, 6, '1010101', 'Berhitung', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-05'),
(6, 6, '1010101', 'asasa', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-06'),
(7, 6, '1010101', 'wdwdwd', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-07'),
(8, 6, '1010101', 'aaa', 'Man bun venmo gochujang, synth quinoa scenester ethical', '2017-12-08'),
(9, 6, '1010101', 'wsswwwdwfc', 'Man bun venmo gochujang, synth quinoa scenester', '2017-12-11'),
(10, 6, '1010101', 'sdsfww', 'Sriracha direct trade portland live-edge swag.', '2017-12-12'),
(11, 6, '1010101', 'akhakusha', ' direct trade portland live-edge swag.', '2017-12-13'),
(12, 6, '1010101', 'dwdswdswd', ' tile. Sriracha direct trade portland live-edge swag.', '2017-12-14'),
(13, 6, '1010101', 'Wdwsddsw', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art p', '2017-12-15'),
(14, 6, '1010101', 'scsss', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-18'),
(15, 6, '1010101', 'fefefwqasds', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-19'),
(16, 6, '1010101', 'daas', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-20'),
(17, 6, '1010101', 'asdaas', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-21'),
(18, 6, '1010101', 'sasa', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-22'),
(19, 6, '1010101', 'daasas', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-25'),
(20, 6, '1010101', 'qsqqsq', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-26'),
(21, 6, '1010101', 'dadad', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-27'),
(22, 6, '1010101', 'wdwdwswd', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-28'),
(23, 6, '1010101', 'wdwswsw', 'Man bun venmo gochujang, synth quinoa scenester ethical intelligentsia letterpress blue bottle poutine. Marfa ramps art party before they sold out lumbersexual cardigan man bun air plant subway tile. Sriracha direct trade portland live-edge swag.', '2017-12-29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_kegiatan`
--
ALTER TABLE `tb_kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tb_kegiatan_tb_kelas` (`id_kelas`),
  ADD KEY `FK_tb_kegiatan_tb_guru` (`nip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_kegiatan`
--
ALTER TABLE `tb_kegiatan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_kegiatan`
--
ALTER TABLE `tb_kegiatan`
  ADD CONSTRAINT `FK_tb_kegiatan_tb_guru` FOREIGN KEY (`nip`) REFERENCES `tb_guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tb_kegiatan_tb_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
