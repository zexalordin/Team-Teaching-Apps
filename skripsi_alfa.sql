-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2019 at 03:52 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi_alfa`
--

-- --------------------------------------------------------

--
-- Table structure for table `cetak_soal`
--

CREATE TABLE `cetak_soal` (
  `id_cetak` int(11) NOT NULL,
  `id_matkul` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL,
  `tanggal_cetak` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kode_soal` int(11) NOT NULL,
  `nama_file_cetak` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cetak_soal`
--

INSERT INTO `cetak_soal` (`id_cetak`, `id_matkul`, `id_dosen`, `tanggal_cetak`, `kode_soal`, `nama_file_cetak`) VALUES
(22, 25, 11, '2018-12-12 10:33:36', 1, '22-Analisis dan Perancangan Sistem-12.12.2018-A'),
(23, 25, 11, '2018-12-12 10:34:27', 1, '23-Analisis dan Perancangan Sistem-12.12.2018-A'),
(24, 25, 11, '2018-12-12 10:35:39', 1, '24-Analisis dan Perancangan Sistem-12.12.2018-A'),
(25, 25, 11, '2018-12-12 13:26:16', 1, '25-Analisis dan Perancangan Sistem-12.12.2018-A'),
(26, 25, 11, '2018-12-12 13:26:55', 3, '26-Analisis dan Perancangan Sistem-12.12.2018-A'),
(27, 25, 11, '2018-12-12 13:26:55', 3, '27-Analisis dan Perancangan Sistem-12.12.2018-B'),
(28, 25, 11, '2018-12-12 13:26:55', 3, '28-Analisis dan Perancangan Sistem-12.12.2018-C'),
(29, 25, 11, '2018-12-15 17:14:10', 2, '29-Analisis dan Perancangan Sistem-16.12.2018-A'),
(30, 25, 11, '2018-12-15 17:14:16', 2, '30-Analisis dan Perancangan Sistem-16.12.2018-B'),
(31, 25, 11, '2018-12-15 17:43:52', 2, '31-Analisis dan Perancangan Sistem-16.12.2018-A'),
(32, 25, 11, '2018-12-15 17:43:53', 2, '32-Analisis dan Perancangan Sistem-16.12.2018-B'),
(33, 25, 11, '2018-12-15 17:45:26', 2, '33-Analisis dan Perancangan Sistem-16.12.2018-A'),
(34, 25, 11, '2018-12-15 17:45:27', 2, '34-Analisis dan Perancangan Sistem-16.12.2018-B'),
(35, 25, 11, '2018-12-16 14:40:32', 2, '35-Analisis dan Perancangan Sistem-16.12.2018-A'),
(36, 25, 11, '2018-12-16 14:40:37', 2, '36-Analisis dan Perancangan Sistem-16.12.2018-B'),
(37, 25, 11, '2018-12-17 01:35:13', 2, '37-Analisis dan Perancangan Sistem-17.12.2018-A'),
(38, 25, 11, '2018-12-17 01:35:14', 2, '38-Analisis dan Perancangan Sistem-17.12.2018-B'),
(39, 25, 11, '2018-12-18 22:05:21', 2, '39-Analisis dan Perancangan Sistem-19.12.2018-A'),
(40, 25, 11, '2018-12-18 22:05:26', 2, '40-Analisis dan Perancangan Sistem-19.12.2018-B'),
(41, 25, 11, '2018-12-19 03:50:14', 2, '41-Analisis dan Perancangan Sistem-19.12.2018-A'),
(42, 25, 11, '2018-12-19 03:50:18', 2, '42-Analisis dan Perancangan Sistem-19.12.2018-B');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` int(11) NOT NULL,
  `nip_dosen` varchar(20) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `email_dosen` varchar(100) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  `keminatan_mayor` int(11) NOT NULL,
  `keminatan_minor` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `nip_dosen`, `nama_dosen`, `email_dosen`, `username`, `password`, `keminatan_mayor`, `keminatan_minor`, `role`) VALUES
(1, '145150200111112', 'Abul A\'la Alghifari', 'tes@gmail.com', 'ablaala', '202cb962ac59075b964b07152d234b70', 6, 'N;', 'a:2:{i:0;i:4;i:1;i:1;}'),
(10, '198209092008121004', 'Bayu Priyambadha', 'abul.alghifari@gmail.com', 'bayu', '202cb962ac59075b964b07152d234b70', 6, 'N;', 'a:3:{i:0;i:4;i:1;i:2;i:2;i:3;}'),
(11, '198711212015041004', 'Fajar Pradana', 'hnewbies@gmail.com', 'fajar', '202cb962ac59075b964b07152d234b70', 6, 'N;', 'a:2:{i:0;i:4;i:1;i:3;}'),
(12, '198209302008011004', 'Muhammad Tanzil Furqon', 'tanzil@gmail.com', 'tanzil', '202cb962ac59075b964b07152d234b70', 7, 'N;', 'a:1:{i:0;i:4;}'),
(13, '197404142003121004', 'Edy Santoso', 'edy@gmail.com', 'edy', '202cb962ac59075b964b07152d234b70', 7, 'N;', 'a:1:{i:0;i:4;}'),
(14, '197408052001121001', 'Agus Wahyu Widodo', 'wiwid@gmail.com', 'wiwid', '202cb962ac59075b964b07152d234b70', 7, 'N;', 'a:3:{i:0;i:4;i:1;i:2;i:2;i:3;}'),
(15, '85112406110250', 'Denny Sagita Rusdianto', 'denny@gmail.com', 'denny', '202cb962ac59075b964b07152d234b70', 6, 'N;', 'a:1:{i:0;i:4;}'),
(16, '197306192002122001', 'Dian Eka Ratnawati', 'dian@gmail.com', 'dian', '202cb962ac59075b964b07152d234b70', 0, '', 'a:1:{i:0;i:0;}'),
(17, '12456', 'rini', 'rini@gmail.com', 'rini', '202cb962ac59075b964b07152d234b70', 0, '', 'a:1:{i:0;i:0;}');

-- --------------------------------------------------------

--
-- Table structure for table `kjfd`
--

CREATE TABLE `kjfd` (
  `id_kjfd` int(11) NOT NULL,
  `nama_kjfd` varchar(30) NOT NULL,
  `id_dosen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kjfd`
--

INSERT INTO `kjfd` (`id_kjfd`, `nama_kjfd`, `id_dosen`) VALUES
(6, 'Rekayasa Perangkat Lunak', 10),
(7, 'Komputasi Cerdas', 14);

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_soal` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL,
  `kategori_komentar` varchar(20) NOT NULL,
  `isi_komentar` text NOT NULL,
  `tanggal_komentar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `id_matkul` int(11) NOT NULL,
  `kode_matkul` varchar(10) NOT NULL,
  `nama_matkul` varchar(50) NOT NULL,
  `id_kjfd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`id_matkul`, `kode_matkul`, `nama_matkul`, `id_kjfd`) VALUES
(23, 'PTI15010', 'Pemrograman Web', 6),
(24, 'CIF61255', 'Rekayasa Perangkat Lunak', 6),
(25, 'IFK15201', 'Analisis dan Perancangan Sistem', 6),
(26, 'CIF62461', 'Data Mining', 7),
(27, 'CIF62463', 'Jaringan Syaraf Tiruan', 7);

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `id_tt` int(11) NOT NULL,
  `bab_materi` int(11) NOT NULL,
  `nama_materi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id_materi`, `id_tt`, `bab_materi`, `nama_materi`) VALUES
(10, 18, 1, 'Rekayasa Kebutuhan'),
(11, 18, 2, 'Perancangan'),
(12, 18, 3, 'Implementasi'),
(13, 18, 4, 'Pengujian'),
(14, 19, 1, 'Konsep Pemodelan'),
(15, 19, 2, 'Konsep Rekayasa Kebutuhan'),
(16, 19, 3, 'Pemodelan Kebutuhan');

-- --------------------------------------------------------

--
-- Table structure for table `penugasan`
--

CREATE TABLE `penugasan` (
  `id_penugasan` int(11) NOT NULL,
  `id_tt` int(11) NOT NULL,
  `nama_penugasan` varchar(100) NOT NULL,
  `materi_penugasan` text NOT NULL,
  `tingkat_kesulitan` varchar(200) NOT NULL,
  `kuota_ambil_penugasan` text NOT NULL,
  `id_ambil_penugasan` text NOT NULL,
  `status_penugasan_anggota` text NOT NULL,
  `batas_pengambilan` date NOT NULL,
  `batas_penugasan` date NOT NULL,
  `status_penugasan` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penugasan`
--

INSERT INTO `penugasan` (`id_penugasan`, `id_tt`, `nama_penugasan`, `materi_penugasan`, `tingkat_kesulitan`, `kuota_ambil_penugasan`, `id_ambil_penugasan`, `status_penugasan_anggota`, `batas_pengambilan`, `batas_penugasan`, `status_penugasan`) VALUES
(28, 19, 'APS 1', 'a:2:{i:0;s:2:\"14\";i:1;s:2:\"15\";}', 'a:2:{i:0;a:3:{i:0;s:1:\"2\";i:1;s:1:\"1\";i:2;s:1:\"0\";}i:1;a:3:{i:0;s:1:\"0\";i:1;s:1:\"2\";i:2;s:1:\"0\";}}', 'a:2:{i:0;s:1:\"2\";i:1;s:1:\"2\";}', 'a:2:{i:0;a:2:{i:0;s:2:\"10\";i:1;s:2:\"11\";}i:1;a:2:{i:0;s:2:\"10\";i:1;s:1:\"1\";}}', 'a:2:{i:0;a:2:{i:0;i:1;i:1;i:1;}i:1;a:2:{i:0;i:1;i:1;i:0;}}', '2018-12-11', '2018-12-12', 1),
(37, 18, 'Tugas1', 'a:1:{i:0;s:2:\"12\";}', 'a:1:{i:0;a:3:{i:0;s:1:\"1\";i:1;s:1:\"0\";i:2;s:1:\"0\";}}', 'a:1:{i:0;s:1:\"2\";}', 'a:1:{i:0;a:2:{i:0;s:2:\"11\";i:1;s:2:\"10\";}}', 'a:1:{i:0;a:2:{i:0;i:0;i:1;i:0;}}', '2018-12-19', '2018-12-21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id_soal` int(11) NOT NULL,
  `id_penugasan` int(11) NOT NULL,
  `id_materi` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL,
  `tingkat_kesulitan` int(11) NOT NULL,
  `soal` text NOT NULL,
  `opsi` text NOT NULL,
  `jawaban` int(11) NOT NULL,
  `estimasi_pengerjaan_soal` int(11) NOT NULL,
  `status_soal` tinyint(4) NOT NULL DEFAULT '0',
  `tanggal_buat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id_soal`, `id_penugasan`, `id_materi`, `id_dosen`, `tingkat_kesulitan`, `soal`, `opsi`, `jawaban`, `estimasi_pengerjaan_soal`, `status_soal`, `tanggal_buat`) VALUES
(152, 28, 14, 10, 0, '<p>Sebuah usecase diagram menggambarkan:</p>\r\n', 'a:4:{i:0;s:62:\"<p>perilaku sistem dari tampak luar berdasarkan aktornya</p>\r\n\";i:1;s:39:\"<p>perilaku aktor terhadap sistem</p>\r\n\";i:2;s:64:\"<p>urutan proses yang ada pada sistem berdasarkan aktornya</p>\r\n\";i:3;s:63:\"<p>perilaku sistem berdasarkan urutan proses yang terjadi</p>\r\n\";}', 0, 60, 0, '2018-12-12 09:47:44'),
(153, 28, 14, 10, 0, '<p>Jika sebuah usecase A selalu membutuhkan usecase B dalam menyelesaikan rangkaian tugasnya maka kedua usecase tersebut digambarkan sebagai:</p>\r\n', 'a:4:{i:0;s:116:\"<p><img alt=\"\" src=\"/team_teaching/assets/ck/kcfinder/upload/images/a.png\" style=\"height:39px; width:200px\" /></p>\r\n\";i:1;s:116:\"<p><img alt=\"\" src=\"/team_teaching/assets/ck/kcfinder/upload/images/b.png\" style=\"height:35px; width:200px\" /></p>\r\n\";i:2;s:116:\"<p><img alt=\"\" src=\"/team_teaching/assets/ck/kcfinder/upload/images/c.png\" style=\"height:33px; width:200px\" /></p>\r\n\";i:3;s:116:\"<p><img alt=\"\" src=\"/team_teaching/assets/ck/kcfinder/upload/images/d.png\" style=\"height:41px; width:200px\" /></p>\r\n\";}', 0, 90, 0, '2018-12-12 09:47:44'),
(154, 28, 14, 10, 1, '<p>Dalam fase pengembangan perangkat lunak, terdapat proses untuk menemukan kebutuhan pengguna, fase apakah itu?</p>\r\n', 'a:4:{i:0;s:34:\"<p>Requirement Specification</p>\r\n\";i:1;s:33:\"<p>Requirement Optimization</p>\r\n\";i:2;s:32:\"<p>Requirement Engineering</p>\r\n\";i:3;s:31:\"<p>Requirement Generation</p>\r\n\";}', 0, 60, 0, '2018-12-12 09:47:44'),
(155, 28, 15, 10, 1, '<p>Cara yang baik untuk melakukan <em>requirements validation review</em> adalah:</p>\r\n', 'a:4:{i:0;s:63:\"<p>Mengunakan checklist untuk memeriksa setiap kebutuhan.</p>\r\n\";i:1;s:77:\"<p>Meminta costumer untuk memeriksa keseluruhan kebutuhan tanpa analis.</p>\r\n\";i:2;s:69:\"<p>Mengirimkannya ke tim perancangan untuk meminta umpan balik.</p>\r\n\";i:3;s:52:\"<p>Menguji apakah model sistem terdapat error.</p>\r\n\";}', 0, 60, 0, '2018-12-12 09:49:43'),
(156, 28, 15, 10, 1, '<p>Manakah pernyataan di bawah ini yang <strong>salah</strong>?</p>\r\n', 'a:4:{i:0;s:84:\"<p>Kebutuhan yang telah melalui proses conflict resolution masih dapat diubah.</p>\r\n\";i:1;s:91:\"<p>Kegagalan dalam menganalisis kebutuhan tidak berdampak buruk bagi perangkat lunak.</p>\r\n\";i:2;s:79:\"<p>Costumer seringkali tidak dapat dengan tepat menjelaskan kebutuhannya.</p>\r\n\";i:3;s:147:\"<p>User yang berbeda seringkali mengusulkan kebutuhan yang saling bertentangan, masing-masing dengan alasan bahwa versinya adalah yang benar.</p>\r\n\";}', 0, 60, 0, '2018-12-12 09:49:44'),
(157, 28, 14, 11, 0, '<p>Suatu proses untuk memastikan bahwa dalam setiap kebutuhan, tidak ada kebutuhan yang memiliki makna ganda merupakan bagian dari parameter pengecekan?</p>\r\n', 'a:4:{i:0;s:17:\"<p>Validasi</p>\r\n\";i:1;s:19:\"<p>Verifikasi</p>\r\n\";i:2;s:19:\"<p>Legalisasi</p>\r\n\";i:3;s:20:\"<p>Argumentasi</p>\r\n\";}', 0, 60, 0, '2018-12-12 09:56:47'),
(158, 28, 14, 11, 0, '<p>Analisis pernyataan kebutuhan berikut &quot;Sistem harus mampu mengirim tagihan/invoice pembelian melalui email secara cepat setelah pembeli melengkapi proses transaksi&quot;, Jelaskan kesalahan pernyataan kebutuhan tersebut !</p>\r\n', 'a:4:{i:0;s:45:\"<p>Kebutuhan tidak terukur kecepatannya</p>\r\n\";i:1;s:43:\"<p>Kebutuhan tidak jelas transaksinya</p>\r\n\";i:2;s:42:\"<p>Kebutuhan tidak jelas penggunanya</p>\r\n\";i:3;s:32:\"<p>Kebutuhan tidak relevan</p>\r\n\";}', 0, 60, 0, '2018-12-12 09:56:47'),
(159, 28, 14, 11, 1, '<p>Kesalahan apa yang terjadi pada diagram ini?</p>\r\n\r\n<p><img alt=\"\" src=\"/team_teaching/assets/ck/kcfinder/upload/images/diagram.png\" style=\"height:150px; width:71px\" /></p>\r\n', 'a:4:{i:0;s:27:\"<p>Kesalahan Semantik</p>\r\n\";i:1;s:28:\"<p>Kesalahan Pragmatis</p>\r\n\";i:2;s:26:\"<p>Kesalahan Sintaks</p>\r\n\";i:3;s:30:\"<p>Kesalahan Diagramatik</p>\r\n\";}', 0, 90, 0, '2018-12-12 09:56:47');

-- --------------------------------------------------------

--
-- Table structure for table `team_teaching`
--

CREATE TABLE `team_teaching` (
  `id_tt` int(11) NOT NULL,
  `id_matkul` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL,
  `anggota_tt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team_teaching`
--

INSERT INTO `team_teaching` (`id_tt`, `id_matkul`, `id_dosen`, `anggota_tt`) VALUES
(17, 23, 11, 'a:2:{i:0;s:2:\"15\";i:1;s:2:\"11\";}'),
(18, 24, 10, 'a:4:{i:0;s:1:\"1\";i:1;s:2:\"10\";i:2;s:2:\"15\";i:3;s:2:\"11\";}'),
(19, 25, 11, 'a:3:{i:0;s:1:\"1\";i:1;s:2:\"10\";i:2;s:2:\"11\";}'),
(20, 26, 14, 'a:0:{}'),
(21, 27, 14, 'a:0:{}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cetak_soal`
--
ALTER TABLE `cetak_soal`
  ADD PRIMARY KEY (`id_cetak`),
  ADD KEY `id_dosen` (`id_dosen`) USING BTREE,
  ADD KEY `id_matkul` (`id_matkul`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`);

--
-- Indexes for table `kjfd`
--
ALTER TABLE `kjfd`
  ADD PRIMARY KEY (`id_kjfd`),
  ADD KEY `id_dosen` (`id_dosen`) USING BTREE;

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_akun` (`id_dosen`),
  ADD KEY `id_soal` (`id_soal`);

--
-- Indexes for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`id_matkul`),
  ADD KEY `id_kjfd` (`id_kjfd`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `id_tt` (`id_tt`);

--
-- Indexes for table `penugasan`
--
ALTER TABLE `penugasan`
  ADD PRIMARY KEY (`id_penugasan`),
  ADD KEY `id_tt` (`id_tt`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `id_akun` (`id_dosen`),
  ADD KEY `id_penugasan` (`id_penugasan`),
  ADD KEY `id_materi` (`id_materi`);

--
-- Indexes for table `team_teaching`
--
ALTER TABLE `team_teaching`
  ADD PRIMARY KEY (`id_tt`),
  ADD KEY `id_akun` (`id_dosen`),
  ADD KEY `id_matkul` (`id_matkul`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cetak_soal`
--
ALTER TABLE `cetak_soal`
  MODIFY `id_cetak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kjfd`
--
ALTER TABLE `kjfd`
  MODIFY `id_kjfd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  MODIFY `id_matkul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `penugasan`
--
ALTER TABLE `penugasan`
  MODIFY `id_penugasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `team_teaching`
--
ALTER TABLE `team_teaching`
  MODIFY `id_tt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cetak_soal`
--
ALTER TABLE `cetak_soal`
  ADD CONSTRAINT `cetak_soal_ibfk_1` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`),
  ADD CONSTRAINT `cetak_soal_ibfk_2` FOREIGN KEY (`id_matkul`) REFERENCES `mata_kuliah` (`id_matkul`);

--
-- Constraints for table `kjfd`
--
ALTER TABLE `kjfd`
  ADD CONSTRAINT `kjfd_ibfk_1` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`);

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`),
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`id_soal`) REFERENCES `soal` (`id_soal`);

--
-- Constraints for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD CONSTRAINT `mata_kuliah_ibfk_1` FOREIGN KEY (`id_kjfd`) REFERENCES `kjfd` (`id_kjfd`);

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`id_tt`) REFERENCES `team_teaching` (`id_tt`);

--
-- Constraints for table `penugasan`
--
ALTER TABLE `penugasan`
  ADD CONSTRAINT `penugasan_ibfk_1` FOREIGN KEY (`id_tt`) REFERENCES `team_teaching` (`id_tt`);

--
-- Constraints for table `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `soal_ibfk_1` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`),
  ADD CONSTRAINT `soal_ibfk_2` FOREIGN KEY (`id_penugasan`) REFERENCES `penugasan` (`id_penugasan`),
  ADD CONSTRAINT `soal_ibfk_3` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`);

--
-- Constraints for table `team_teaching`
--
ALTER TABLE `team_teaching`
  ADD CONSTRAINT `team_teaching_ibfk_1` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`),
  ADD CONSTRAINT `team_teaching_ibfk_2` FOREIGN KEY (`id_matkul`) REFERENCES `mata_kuliah` (`id_matkul`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
