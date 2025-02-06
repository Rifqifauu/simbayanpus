-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 05, 2025 at 06:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simbayanpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nama_divisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kuota` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id`, `created_at`, `updated_at`, `nama_divisi`, `keterangan`, `kuota`) VALUES
(2, '2025-01-12 18:58:42', '2025-02-03 20:35:18', 'Jogja Library Center', '1.	Mempersiapkan sarana dan prasarana.\n2.	Shelving koleksi Yogyasiana, Kyoto Corner, Surat Kabar dan Majalah\n3.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu.\n4.	Memberikan informasi terkait layanan dan koleksi yang ada di Jogja Library Center\n5.	Memberikan layanan penelusuran informasi\n6.	Melaksanakan layanan penyebaran informasi terkini / Current Information Service.\n7.	Melaksanakan layanan penyebaran informasi terseleksi / Selective Dissemination Information\n8.	Membuat abstrak buku untuk display buku referensi baru atau display buku dengan tema tertentu secara berkala\n9.	Membuat content / materi publikasi tentang layanan dan koleksi yang tersedia di Jogja Library Center secara berkala\n10.	Mendownload surat kabar digital dan dilayankan di Ruang Koleksi Digital\n11.	Membuat statistik dan laporan pengunjung dan buku yang dibaca di Jogja Library Center\n12.	Mengumpulkan dan mendata buku yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n13.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan\nmelaporkan kepada Pendamping Layanan Perpustakaan.\n', 4),
(3, '2025-01-12 19:02:20', '2025-02-03 20:20:22', 'Frontdesk', '1.	Mempersiapkan sarana dan prasarana pendaftaran anggota\n2.	Melayani pembuatan kartu anggota perpustakaan\n3.	Melayani perpanjangan keanggotaan perpustakaan\n4.	Memandu pengisian form di aplikasi pendaftaran keanggotaan\n5.	Menerima, memeriksa dan memverifikasi identitas calon anggota\n6.	Memotret calon pendaftar anggota offline dan mencetak kartu anggota.\n7.	Menyerahkan kartu anggota yang telah dicetak\n8.	Membuat statistik dan laporan pendaftaran anggota\n9.	Mempersiapkan sarana dan prasarana layanan Bebas Pustaka\n10.	Melayani pembuatan kartu bebas pustaka secara online maupun offline\n11.	Menerima dan memverifikasi identitas pemohon\n12.	Menerima retribusi Bebas Pustaka\n13.	Melaporkan dan menyetorkan retribusi Bebas Pustaka ke Bendahara\n14.	Menyerahkan form atau mengirimkan form Bebas Pusaka kepada pemohon\n15.	Membuat statistik & laporan terkait kegiatan bebas pustaka\n', 2),
(4, '2025-01-12 19:27:47', '2025-02-03 20:33:28', 'Humas', '1.	Mempersiapkan sarana dan prasarana layanan informasi\n2.	Memberikan informasi kepada pengunjung terkait semua layanan di Balai Layanan Perpustakaan\n3.	Membuat content / materi publikasi mengenai berbagai layanan di Balai Layanan Perpustakaan\n4.	Mengelola media sosial Balai Layanan Perpustakaan\n5.	Meneruskan permintaan layanan daring baca di tempat ke petugas sesuai lokasi bahan pustaka\n6.	Meneruskan permintaan kunjungan, sewa tempat, maupun surat - menyurat lainnya kepada bagian Persuratan\n7.	Menerima kunjungan perpustakaan / wisata pustaka\n8.	Menerima kritik, saran, aduan masyarakat\n9.	Menindaklanjuti kritik, saran, aduan masyarakat berdasarkan SOP Layanan\n10.	Membuat statistik dan laporan layanan informasi dan aduan masyarakat', 1),
(5, '2025-01-13 01:00:32', '2025-02-03 20:34:23', 'Audio Visual', '1.	Mempersiapkan sarana dan prasarana.\n2.	Menerima pengunjung dan mengarahkan untuk mengisi buku tamu.\n3.	Memberikan layanan pemutaran film di ruang AV.\n4.	Membuat jadwal pemutaran film baru secara berkala.\n5.	Membuat statistik dan laporan pengunjung.\n6.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n', 1),
(6, '2025-01-13 01:01:00', '2025-02-03 20:40:01', 'Koleksi Umum', '1.	Mempersiapkan sarana dan prasarana di ruang koleksi umum.\n2.	Shelving koleksi umum\n3.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu\n4.	Memberikan informasi kepada pemustaka tentang koleksi umum\n5.	Memberikan pelayanan baca di tempat\n6.	Memberikan pelayanan peminjaman dan pengembalian buku\n7.	Mendampingi peminjaman mandiri\n8.	Mengirimkan informasi keterlambatan melalui aplikasi\n9.	Mencatat dan menerima retribusi denda keterlambatan pengembalian koleksi\n10.	Melaporkan dan menyetorkan retribusi denda kepada Bendahara Penerimaan\n11.	Mengambil dan mengecek ulang buku-buku yang dikembalikan\n12.	Menerima dan mendata buku penggantian koleksi yang hilang / rusak.\n13.	Membuat content / materi publikasi tentang layanan koleksi Umum\n14.	Membuat statistik dan laporan pengunjung, buku dipinjam, buku dikembalikan, denda dan buku yang dibaca di koleksi umum\n15.	Mengumpulkan dan mendata buku yang rusak dan melaporkan kepada\nPendamping Layanan Perpustakaan.\n', 1),
(7, '2025-02-03 20:45:18', '2025-02-03 20:45:18', 'Koleksi Anak', '1.	Mempersiapkan sarana dan prasarana.\n2.	Shelving koleksi anak\n3.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu\n4.	Memberikan informasi kepada pemustaka tentang koleksi anak\n5.	Memberikan pelayanan baca di tempat\n6.	Memberikan pelayanan peminjaman dan pengembalian buku\n7.	Mencatat dan menerima retribusi denda keterlambatan pengembalian koleksi\n8.	Melaporkan dan menyetorkan retribusi denda kepada Bendahara Penerimaan\n9.	Menerima dan mendata buku penggantian koleksi yang hilang / rusak.\n10.	Membuat content / materi publikasi tentang layanan Koleksi anak-anak\n11.	Membuat statistik dan laporan pengunjung, buku dipinjam, buku dikembalikan, denda dan buku yang dibaca di koleksi anak\n12.	Mengumpulkan dan mendata buku yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n13.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan\nmelaporkan kepada Pendamping Layanan Perpustakaan.\n', 1),
(8, '2025-02-03 20:47:20', '2025-02-03 20:47:20', 'Ruang Bermain', '1.	Mempersiapkan sarana dan prasarana.\n2.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu.\n3.	Memberikan informasi terkait layanan bermain anak-anak\n4.	Mengawasi dan mendampingi pemustaka\n5.	Membuat content / materi publikasi tentang layanan bermain anak-anak\n6.	Mempersiapkan dan memberikan layanan dongeng\n7.	Membuat statistik dan laporan pengunjung, buku yang dibaca di ruang bermain anak\n8.	Membantu shelving\n9.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n', 1),
(9, '2025-02-03 23:57:01', '2025-02-03 23:57:01', 'Persuratan', '1.	Mempersiapkan sarana dan prasarana.\n2.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu.\n3.	Memberikan informasi terkait layanan Kunjungan / Wisata Pustaka, Penelitian dan Magang, Pemanfaatan Ruang Pertemuan, dan Permohonan Kerjasama\n4.	Memproses surat masuk maupun surat keluar\n5.	Mengelola arsip Balai Layanan Perpustakaan\n6.	Membuat statistik dan laporan pengunjung kunjungan / wisata pustaka dan pemanfaatan ruang pertemuan\n7.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan\nmelaporkan kepada Pendamping Layanan Perpustakaan.\n', 1),
(10, '2025-02-03 23:58:20', '2025-02-03 23:58:20', 'Ruang Mendongeng', '1.	Mempersiapkan sarana dan prasarana.\n2.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu.\n3.	Memberikan informasi terkait layanan mendongeng\n4.	Mempersiapkan dan memberikan layanan dongeng luring maupun daring\n5.	Membuat content / materi publikasi tentang layanan mendongeng\n6.	Membuat statistik dan laporan pengunjung, buku yang dibaca di ruang mendongeng\n7.	Mengumpulkan dan mendata buku yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan\n8.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n', 1),
(11, '2025-02-04 23:06:36', '2025-02-04 23:06:36', 'Drive Thru', '1.	Mempersiapkan sarana dan prasarana di ruang drive thru.\n2.	Mencatat dan menerima retribusi denda keterlambatan pengembalian koleksi.\n3.	Memberikan pelayanan peminjaman dan pengembalian buku\n4.	Melaporkan dan menyetorkan retribusi denda\n5.	Menerima dan mendata buku penggantian koleksi yang hilang / rusak.\n6.	Membuat statistik\n7.	Membuat content / materi publikasi\n', 1),
(12, '2025-02-04 23:07:05', '2025-02-04 23:07:05', 'Ruang Musik Anak', '1.	Mempersiapkan sarana dan prasarana.\n2.	Shelving koleksi di ruang musik anak.\n3.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu.\n4.	Memberikan informasi terkait layanan Musik\n5.	Mempersiapkan dan memberikan layanan di ruang musik\n6.	Membuat statistik dan laporan pengunjung, buku yang dibaca di ruang musik anak\n7.	Membantu shelving koleksi umum\n8.	Membuat content / materi publikasi tentang layanan musik anak\n9.	Mengumpulkan dan mendata buku yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan\n10.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan\nmelaporkan kepada Pendamping Layanan Perpustakaan.\n', 1),
(13, '2025-02-04 23:07:23', '2025-02-04 23:07:23', 'Koleksi Budaya & Skripsi', '1.	Mempersiapkan sarana dan prasarana.\n2.	Shelving koleksi Budaya dan koleksi Skripsi\n3.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu.\n4.	Memberikan informasi terkait koleksi Budaya dan koleksi Skripsi\n5.	Memberikan layanan penelusuran informasi koleksi Budaya dan koleksi Skripsi\n6.	Membuat content / materi publikasi tentang layanan koleksi Budaya secara berkala\n7.	Membuat statistik dan laporan pengunjung dan buku yang dibaca di ruang koleksi Budaya dan koleksi Skripsi\n8.	Mengumpulkan dan mendata buku yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n9.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan\nmelaporkan kepada Pendamping Layanan Perpustakaan.\n', 1),
(14, '2025-02-04 23:07:45', '2025-02-04 23:07:45', 'Koleksi Referensi', '1.	Mempersiapkan sarana dan prasarana.\n2.	Shelving koleksi referensi\n3.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu.\n4.	Memberikan informasi terkait koleksi referensi\n5.	Memberikan layanan penelusuran informasi\n6.	Melaksanakan layanan penyebaran informasi terkini / Current Information Service.\n7.	Melaksanakan layanan penyebaran informasi terseleksi / Selective Dissemination Information\n8.	Membuat abstrak buku untuk display buku referensi baru atau dengan tema tertentu secara berkala\n9.	Membuat content / materi publikasi\n10.	Membuat statistik dan laporan pengunjung dan buku yang dibaca di koleksi referensi.\n11.	Mengumpulkan dan mendata buku yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n12.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n', 1),
(15, '2025-02-04 23:08:18', '2025-02-04 23:08:18', 'Koleksi Langka', '1.	Mempersiapkan sarana dan prasarana.\n2.	Shelving koleksi langka\n3.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu.\n4.	Memberikan informasi terkait koleksi langka.\n5.	Memberikan layanan penelusuran informasi koleksi langka\n6.	Membuat content / materi publikasi tentang layanan koleksi langka secara berkala\n7.	Membuat statistik dan laporan pengunjung dan buku yang dibaca di ruang koleksi langka.\n8.	Mengumpulkan dan mendata buku yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n9.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan\nmelaporkan kepada Pendamping Layanan Perpustakaan.\n', 1),
(16, '2025-02-04 23:08:31', '2025-02-04 23:08:31', 'Koleksi Digital', '1.	Mempersiapkan sarana dan prasarana.\n2.	Menata koleksi digital / CD dsb.\n3.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu.\n4.	Memberikan informasi terkait koleksi digital.\n5.	Mengaktifkan dan menonaktifkan komputer layanan digital kepada setiap pengunjung\n6.	Mengelola koleksi Digital Offline\n7.	Mengelola website balaiyanpus / jogjalib\n8.	Mengelola aplikasi si Yokca / iJogja\n9.	Membuat sebuah aplikasi atau web\n10.	Membuat content / materi publikasi tentang layanan koleksi digital secara berkala\n11.	Membuat statistik dan laporan pengunjung.\n12.	Mengumpulkan dan mendata koleksi yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n13.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan\nmelaporkan kepada Pendamping Layanan Perpustakaan.\n', 1),
(17, '2025-02-04 23:08:46', '2025-02-04 23:08:46', 'Koleksi Braille', '1.	Mempersiapkan sarana dan prasarana.\n2.	Shelving koleksi Braille\n3.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu\n4.	Memberikan informasi koleksi Braille\n5.	Membuat statistik dan laporan pengunjung dan buku yang dibaca di koleksi Braille\n6.	Membuat content / materi publikasi tentang layanan Braille\n7.	Mengumpulkan dan mendata buku yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n8.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan\nmelaporkan kepada Pendamping Layanan Perpustakaan.\n', 1),
(18, '2025-02-04 23:09:09', '2025-02-04 23:09:09', 'Majalah Koran', '1.	Mempersiapkan sarana dan prasarana.\n2.	Shelving koleksi Majalah Koran\n3.	Menerima dan melayani pemustaka, serta mengarahkan untuk mengisi buku tamu\n4.	Memberikan informasi koleksi Majalah Koran\n5.	Membuat statistik dan laporan pengunjung dan buku yang dibaca di koleksi Majalah Koran\n6.	Membuat content / materi publikasi tentang layanan Majalah Koran\n7.	Mengumpulkan dan mendata buku yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n8.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan\nmelaporkan kepada Pendamping Layanan Perpustakaan.\n', 1),
(19, '2025-02-04 23:09:31', '2025-02-04 23:09:31', 'Bioskop 6D', '1.	Mempersiapkan sarana dan prasarana.\n2.	Melayani pembelian tiket Bioskop 6D.\n3.	Menerima pembayaran retribusi tiket Bioskop 6D dari pemustaka\n4.	Memberikan penjelasan berkaitan dengan layanan bioskop 6D.\n5.	Memberikan layanan di ruang bioskop 6D : mempersilahkan duduk, menjelaskan tata tertib saat menonton Bioskop 6D, membagi dan menerima kembali kacamata, memastikan seatbelt terpasang, memutar film.\n6.	Mengarahkan untuk mengisi buku tamu.\n7.	Membuat statistik dan laporan pengunjung.\n8.	Melaporkan dan menyetorkan retribusi denda kepada Bendahara Penerimaan\n9.	Mengumpulkan dan mendata sarana dan prasarana yang rusak dan melaporkan kepada Pendamping Layanan Perpustakaan.\n10.	Membuat content / materi publikasi\n', 1),
(20, '2025-02-04 23:09:48', '2025-02-04 23:09:48', 'TU Balai Yanpus', '1.	Mempersiapkan sarana dan prasarana.\n2.	Membantu dalam urusan Kepegawaian\n3.	Membantu dalam urusan Keuangan\n4.	Membantu dalam urusan Aset\n5.	Membantu dalam urusan Rumah tangga\n6.	Membantu dalam urusan Program Perencanaan\n7.	Membantu dalam urusan Administrasi Pimpinan\n', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
