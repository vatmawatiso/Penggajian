-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jun 2024 pada 13.30
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gajian`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id_user` int(5) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `telp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id_user`, `username`, `email`, `password`, `photo`, `telp`) VALUES
(1, 'lili', 'lili@gmail.com', '$2y$10$8Bqc7HNhe23xPsy6dL.BPuezfWsKPpmS2L29Ec9ghlcJ.vavS2dUq', 'karyawan.png', '089111222556'),
(2, 'vatma', 'vatma@gmail.com', '$2y$10$/7Ofhvszkglq.DZybWfvOeskz33CGTvS2KX1JH22qqOJCHnMlH/9q', '', ''),
(3, 'intan', 'intan@gmail.com', '$2y$10$iLgjegRHN3xFcjntXO0uO.WlT1hm.8FdlLegtK1mLdcYjYJVam6bG', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bagian`
--

CREATE TABLE `bagian` (
  `id_bagian` int(11) NOT NULL,
  `nama_bagian` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bagian`
--

INSERT INTO `bagian` (`id_bagian`, `nama_bagian`) VALUES
(1, 'Rangka'),
(2, 'Dekor'),
(3, 'Ikat'),
(4, 'Setim'),
(5, 'Harian'),
(6, 'Mingguan'),
(10, 'Selang seling');

-- --------------------------------------------------------

--
-- Struktur dari tabel `harga`
--

CREATE TABLE `harga` (
  `id_harga` int(11) NOT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `id_bagian` int(11) DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `harga`
--

INSERT INTO `harga` (`id_harga`, `id_produk`, `id_bagian`, `harga`) VALUES
(2, 1, 2, '2100.00'),
(3, 1, 3, '2200.00'),
(4, 1, 4, '2300.00'),
(5, 1, 5, '2400.00'),
(7, 2, 2, '3100.00'),
(8, 2, 3, '3200.00'),
(9, 2, 4, '3300.00'),
(10, 2, 5, '3400.00'),
(11, 3, 1, '4000.00'),
(12, 3, 2, '4100.00'),
(13, 3, 3, '4200.00'),
(14, 3, 4, '4300.00'),
(15, 3, 5, '4400.00'),
(20, 5, 2, '4700.00'),
(21, 1, 1, '2000.00'),
(22, 2, 1, '3000.00'),
(23, 10, 1, '2000.00'),
(24, 1, 1, '2000.00'),
(25, 1, 1, '2000.00'),
(26, 1, 1, '2000.00'),
(27, 1, 1, '2000.00'),
(28, 10, 2, '2000.00'),
(29, 10, 3, '2000.00'),
(30, 1, 6, '2000.00'),
(31, 2, 6, '2000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(5) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `NIK` varchar(25) NOT NULL,
  `jenis_kelamin` varchar(30) NOT NULL,
  `nomer_hp` varchar(13) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `jabatan` varchar(25) NOT NULL,
  `thn_masuk` date NOT NULL,
  `no_rek` varchar(50) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama_karyawan`, `NIK`, `jenis_kelamin`, `nomer_hp`, `alamat`, `jabatan`, `thn_masuk`, `no_rek`, `bank`, `status`) VALUES
(1, 'Farid Hamdan', '21001', 'laki laki', '089122876445', 'Desa Pamijahan ', 'Staff', '2021-01-01', '', '', 0),
(2, 'Ramdani Putra Adi', '24002', 'laki laki', '83456612', 'Desa Megecilik', 'Staff', '2024-06-14', '076333878666', 'Bank Mandiri', 1),
(3, 'Adi Wijaya', '24003', 'Laki Laki', '2147483647', 'Desa Babakan ', 'Staff', '2024-06-14', '076333878666', 'Bank Mandiri', 1),
(4, 'Mirdad Ramadhan', '24004', 'Laki Laki', '2147483647', 'Desa Kaliwulu', 'Staff', '2024-06-14', '076333878666', 'Bank BJB', 1),
(5, 'Yuda Darmawan', '24007', 'Laki Laki', '394793652', 'Desa Tengahtani', 'Staff', '0000-00-00', '', '', 0),
(6, 'Angga Yunanda', '24008', 'Laki Laki', '2147483647', 'Desa Bode Lor', 'Staff', '0000-00-00', '', '', 0),
(7, 'Firza Zahrudin Nurul', '24009', 'Laki Laki', '73984729', 'Desa Keduanan', 'Staff', '0000-00-00', '', '', 0),
(8, 'Fahrudin Diar', '24010', 'Laki Laki', '2147483647', 'Desa Krucuk', 'Staff', '2024-06-13', '076333878666', 'Bank BSI Syariah', 1),
(9, 'Fahmi Azmi Alamsyah', '24011', 'Laki Laki', '0897655543123', 'Desa Kaliwulu', 'Staff', '2024-06-02', '076333878666', 'Bank Mandiri', 1),
(10, 'Firman Utina M', '24012', 'Laki Laki', '087332456123', 'Desa Plered', 'Staff', '2024-06-02', '076333878666', 'Bank BRI', 1),
(11, 'Yudistira ', '24013', 'Laki Laki', '089324521776', 'Bandung', 'Staff', '2024-06-03', '076333878666', 'Bank Muamalat', 1),
(13, 'Miftah Alam M', '24015', 'Laki Laki', '089324521776', 'Bandung', 'Staff', '2024-06-03', '076333878666', 'Bank Muamalat', 0),
(14, 'Muhammad Albian Yusri', '24018', 'Laki Laki', '089324521776', 'Bandung', 'Staff', '2024-06-06', '076333878666', 'Bank BSI', 0),
(15, 'Wildan Perdana', '24019', 'Laki Laki', '089324521776', 'Bandung', 'Staff', '2024-06-06', '076333878666', 'Bank Mandiri', 1),
(16, 'Ahmad Zuhri Zauhari', '24020', 'Laki Laki', '089324521776', 'Bandung', 'Staff', '2024-06-12', '076333878666', 'BSI', 1),
(18, 'Yudistira ', '24024', 'Laki Laki', '089324521776', 'Bandung', 'Staff', '2024-06-03', '076333878666', 'Bank BPR', 1),
(19, 'aku', '24030', 'Laki Laki', '089324521776', 'Bandung', 'Staff', '2024-06-13', '076333878666', 'Bank BSI', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `konsumen`
--

CREATE TABLE `konsumen` (
  `id_konsumen` int(10) NOT NULL,
  `nama_konsumen` varchar(255) NOT NULL,
  `perusahaan` varchar(255) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `proses` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `konsumen`
--

INSERT INTO `konsumen` (`id_konsumen`, `nama_konsumen`, `perusahaan`, `telepon`, `alamat`, `proses`) VALUES
(1, 'Pak Riyandi', 'CV. Abadi Rotan Furniture', '082342111222', 'Cirebon', 1),
(2, 'Pak Sugeng', 'CV. Sumber Rotan Furniture', '089555432111', 'Jakarta', 0),
(3, 'Pak Rauf Ma\'aruf', 'pt. furnitre bahari', '089776453221', 'jakarta', 1),
(4, 'Pak Rauf', 'PT. Indah Furniture', '089776453221', 'Bandung', 1),
(5, 'Pak Jaya', 'CV. Furniture Jaya', '089776453221', 'Kalimantan Timur', 0),
(6, 'Pak Mardi M', 'CV. Seraya Furniture', '089776453221', 'Cianjur', 1),
(7, 'Pak Wildan ', 'PT. Indonesia Furniture', '089776453221', 'Bandung', 1),
(8, 'Pak Aja', 'PT. Serius ', '089776453221', 'Bandung', 0),
(9, 'Pak Haji Is', 'PT. Permata furniture', '089776453221', 'Bandung', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `nm_karyawan` varchar(100) NOT NULL,
  `nik_karyawan` varchar(50) NOT NULL,
  `jabatan_karyawan` varchar(15) NOT NULL,
  `alamat_karyawan` varchar(255) NOT NULL,
  `produk` varchar(30) NOT NULL,
  `bagian` varchar(30) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `jumlah` varchar(10) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `tanggal_gajian` date NOT NULL,
  `nota_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `nm_karyawan`, `nik_karyawan`, `jabatan_karyawan`, `alamat_karyawan`, `produk`, `bagian`, `harga`, `jumlah`, `total`, `tanggal_gajian`, `nota_number`) VALUES
(18, 'Farid Hamdan', '21001', 'Staff', 'Desa Pamijahan ', 'Kursi', 'Dekor', '3100', '2', '6200', '2024-06-10', ''),
(19, 'Farid Hamdan', '21001', 'Staff', 'Desa Pamijahan ', 'Kursi', 'Harian', '3400', '3', '10200', '2024-06-10', ''),
(21, 'Firza Zahrudin Nurul', '21001', 'Staff', 'Desa Pamijahan ', 'Meja', 'Rangka', '2000', '3', '6000', '2024-06-10', ''),
(22, 'Firza Zahrudin Nurul', '21001', 'Staff', 'Desa Pamijahan ', 'Meja', 'Ikat', '2200', '2', '4400', '2024-06-10', ''),
(23, 'Firza Zahrudin Nurul', '21001', 'Staff', 'Desa Pamijahan ', 'Kursi Gantung', 'Setim', '4300', '4', '17200', '2024-06-10', ''),
(24, 'Farid Hamdan', '21001', 'Staff', 'Desa Pamijahan ', 'Kursi', 'Harian', '3400', '4', '13600', '2024-07-10', ''),
(26, 'Mirdad Ramadhan', '21001', 'Staff', 'Desa Pamijahan ', 'Kursi Gantung', 'Dekor', '4100', '5', '20500', '2024-06-11', ''),
(29, 'Miftah Alam M', '24015', 'Staff', 'Desa Pamijahan ', 'Kursi Gantung', 'Rangka', '4000', '2', '8000', '2024-06-11', ''),
(30, 'Yuda Darmawan', '24007', 'Staff', 'Desa Tengahtani', 'Kursi Gantung', 'Dekor', '4100', '5', '20500', '2024-06-11', ''),
(31, 'Muhammad Albian Yusri', '24018', 'Staff', 'Bandung', 'Kursi', 'Ikat', '3200', '6', '19200', '2024-06-11', ''),
(32, 'Muhammad Albian Yusri', '24018', 'Staff', 'Bandung', 'Kursi Gantung', 'Dekor', '4100', '2', '8200', '2024-06-12', ''),
(33, 'Muhammad Albian Yusri', '24018', 'Staff', 'Bandung', 'Kursi Gantung', 'Ikat', '4200', '5', '21000', '2024-06-12', ''),
(34, 'Ahmad Zuhri Zauhari', '24020', 'Staff', 'Bandung', 'Meja', 'Rangka', '2000', '3', '6000', '2024-06-12', ''),
(35, 'Masukkan nama karyawan', '', 'Staff', '', 'Kursi Gantung', 'Rangka', '4000', '6', '24000', '2024-06-12', ''),
(36, 'Ramdani Putra Adi', '22001', 'Staff', 'Desa Megecilik', 'Kursi', 'Dekor', '3100', '2', '6200', '2024-06-12', ''),
(37, 'Mirdad Ramadhan', '24006', 'Staff', 'Desa Kaliwulu', 'Kursi Gantung', 'Harian', '4400', '3', '13200', '2024-06-12', ''),
(38, 'Adi Wijaya', '24005', 'Staff', 'Desa Babakan ', 'Kursi', 'Dekor', '3100', '2', '6200', '2024-06-12', ''),
(39, 'Wildan Perdana', '24019', 'Staff', 'Bandung', 'Kursi', 'Rangka', '3000', '4', '12000', '2024-06-13', '0014'),
(40, 'Wildan Perdana', '24019', 'Staff', 'Bandung', 'Kursi Gantung', 'Rangka', '4000', '3', '12000', '2024-06-13', '0014');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `foto_produk` varchar(100) NOT NULL,
  `deskripsi_produk` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `foto_produk`, `deskripsi_produk`) VALUES
(1, 'Meja', '', 'Meja bulat'),
(2, 'Kursi', '', 'Kursi single'),
(3, 'Kursi Gantung', '', 'Kursi bulat yang digantung'),
(4, 'Meja Bulat', '', 'Meja yang berbentuk bulat'),
(5, 'Kursi Kuda', '', 'Kursi Berbentuk kuda untuk anak-anak'),
(10, 'kursi tidur', '', 'kursi yang digunakan ketika dipantai'),
(11, 'Gantungan', '', 'gantungan kamar'),
(12, 'plakat ', '666d7a4be4cec.png', 'bingkisan'),
(13, 'kayu', '666d7aece4f63.png', 'kayu panjang');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `bagian`
--
ALTER TABLE `bagian`
  ADD PRIMARY KEY (`id_bagian`);

--
-- Indeks untuk tabel `harga`
--
ALTER TABLE `harga`
  ADD PRIMARY KEY (`id_harga`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_bagian` (`id_bagian`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `konsumen`
--
ALTER TABLE `konsumen`
  ADD PRIMARY KEY (`id_konsumen`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `bagian`
--
ALTER TABLE `bagian`
  MODIFY `id_bagian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `harga`
--
ALTER TABLE `harga`
  MODIFY `id_harga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `konsumen`
--
ALTER TABLE `konsumen`
  MODIFY `id_konsumen` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
