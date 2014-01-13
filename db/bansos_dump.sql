--
-- Dumping data for table `tbl_bansos`
--

INSERT INTO `tbl_bansos` (`ban_kode`, `ban_tanggal`, `ban_jenis`, `jh_kode`, `ban_judul_kegiatan`, `ban_lokasi_kegiatan`, `id_tb`, `ban_nama`, `ban_ktp`, `pimpinan`, `ban_jalan`, `ban_rt`, `ban_rw`, `kd_propinsi`, `kd_dati2`, `kd_kecamatan`, `kd_kelurahan`, `ban_kodepos`, `ban_tlp`, `ban_hp`, `bank_kode`, `ban_norek`, `ban_ren_guna`, `ban_besaran_bansos`, `opd_kode`, `ban_eval_opd`, `ban_eval_tapd`, `ban_status`, `ban_cair`, `ctime`, `mtime`, `user`) VALUES
(1, '2014-01-01', 'Terencana', 1, 'Khitanan Massal', 'Lapangan Sempur', 1, 'Masjid Baiturrahman', '1234567890123456', 'H. Slamet', 'Jl. Cikalong No. 9', '1', '2', '32', '3271', '3271010', '3271010004', 12343, '021-7439626', '08151028323', 8, '64002214', 'Khitanan Massal', 100000000, 21, '1', '0', 'Proses', 0, '2014-01-07 10:51:05', '2014-01-10 08:18:14', 'Administrator');


--
-- Dumping data for table `tbl_berita_acara`
--

INSERT INTO `tbl_berita_acara` (`id`, `ba_no`, `ba_tgl`, `opd_kode`, `tipe`, `sk_no`, `sk_tgl`, `sk_tentang`, `kode`, `ctime`, `mtime`) VALUES
(1, 'BA/HIBAH/I/001/Dindik Bogor', '2013-12-09', 4, 'HIBAH', '001', '2013-12-01', 'Pembentukan Tim Evaluasi', '1-HIBAH-QmBcfjC5bE', '2014-01-06 14:23:43', '2014-01-06 14:23:43'),
(2, 'BA/HIBAH/I/001/Kessbang', '2014-01-31', 2, 'HIBAH', '002', '2014-01-01', 'Pembentukan Tim Evaluasi', '1-HIBAH-4MRMM8VJkP', '2014-01-07 10:09:02', '2014-01-09 07:55:48'),
(3, 'BA/BANSOS/I/001/Kesmas', '2014-01-02', 21, 'BANSOS', '003', '2014-01-01', 'Pembentukan Tim Evaluasi', '1-BANSOS-VW789R02TC', '2014-01-07 10:54:44', '2014-01-07 10:54:44');

-- Dumping data for table `tbl_berita_acara_detail`
--

INSERT INTO `tbl_berita_acara_detail` (`id`, `kode`, `besaran_opd`, `keterangan`, `hib_kode`, `status`, `ctime`, `mtime`) VALUES
(1, '1-HIBAH-QmBcfjC5bE', 40000000, '', 1, 1, '2014-01-06 14:23:43', '2014-01-06 14:23:43'),
(2, '1-HIBAH-QmBcfjC5bE', 70000000, '', 3, 1, '2014-01-06 14:23:43', '2014-01-06 14:23:43'),
(3, '1-HIBAH-QmBcfjC5bE', 30000000, '', 2, 1, '2014-01-06 14:23:43', '2014-01-06 14:23:43'),
(5, '1-BANSOS-VW789R02TC', 75000000, '', 1, 1, '2014-01-07 10:54:44', '2014-01-07 10:54:44'),
(6, '1-HIBAH-4MRMM8VJkP', 200000000, '', 4, 1, '2014-01-09 07:55:48', '2014-01-09 07:55:48'),
(7, '1-HIBAH-4MRMM8VJkP', 30000000, '', 6, 1, '2014-01-09 07:55:48', '2014-01-09 07:55:48');

--
-- Dumping data for table `tbl_cair_hibah`
--

INSERT INTO `tbl_cair_hibah` (`id_cair`, `tgl_cair`, `spph_no`, `spph_tgl`, `nphd_no`, `nphd_tgl`, `nphd_tentang`, `sp2d_no`, `sp2d_tgl`, `hib_kode`, `ctime`, `mtime`, `user`) VALUES
(1, '2014-01-31', 'SPPH/3', '2014-01-01', 'NPHD', '2014-01-02', 'Perjanjian Hibah Antara X dan Y', 'SP2D', '2014-01-31', 4, '2014-01-07 10:17:38', '2014-01-07 10:17:38', 'Administrator');

--
-- Dumping data for table `tbl_eval_tapd`
--

INSERT INTO `tbl_eval_tapd` (`id`, `ba_no`, `ba_tgl`, `opd_kode`, `tipe`, `kode`, `ctime`, `mtime`) VALUES
(1, 'BA/HIBAH/I/001/TAPD', '2014-01-06', 4, 'HIBAH', '1-HIBAH-k2O8FeYBLb', '2014-01-06 14:31:23', '2014-01-06 14:31:23'),
(2, 'BA/HIBAH/I/002/TAPD', '2014-01-30', 2, 'HIBAH', '1-HIBAH-Bd6e9Hfc2P', '2014-01-07 10:13:31', '2014-01-07 10:13:31');


INSERT INTO `tbl_eval_tapd_detail` (`id`, `kode`, `besaran_tapd`, `keterangan`, `hib_kode`, `status`, `ctime`, `mtime`) VALUES
(1, '1-HIBAH-k2O8FeYBLb', 20000000, '', 1, 1, '2014-01-06 14:31:23', '2014-01-06 14:31:23'),
(2, '1-HIBAH-k2O8FeYBLb', 30000000, '', 3, 1, '2014-01-06 14:31:23', '2014-01-06 14:31:23'),
(3, '1-HIBAH-k2O8FeYBLb', 25000000, '', 2, 1, '2014-01-06 14:31:23', '2014-01-06 14:31:23'),
(4, '1-HIBAH-Bd6e9Hfc2P', 100000000, '', 4, 1, '2014-01-07 10:13:31', '2014-01-07 10:13:31');

--
-- Dumping data for table `tbl_hibah`
--

INSERT INTO `tbl_hibah` (`hib_kode`, `hib_tanggal`, `jh_kode`, `hib_judul_kegiatan`, `hib_lokasi_kegiatan`, `hib_nphd`, `hib_nphd_tgl`, `id_jp`, `hib_nama`, `pimpinan`, `hib_jalan`, `hib_rt`, `hib_rw`, `kd_propinsi`, `kd_dati2`, `kd_kecamatan`, `kd_kelurahan`, `hib_kodepos`, `hib_tlp`, `hib_hp`, `bank_kode`, `hib_norek`, `hib_ren_guna`, `hib_besaran_hibah`, `opd_kode`, `hib_eval_opd`, `hib_eval_tapd`, `hib_status`, `hib_cair`, `ctime`, `mtime`, `user`) VALUES
(2, '2013-11-02', 2, 'Pembelian Peralatan Lab IPA', 'Bogor', NULL, NULL, 1, 'SMA Negeri 3 Cibadak', 'Drs. Maman Suparman', 'Jl. Cijeruk No. 6', '5', '4', '32', '3271', '3271050', '3271050009', 15417, '0251-3667781', '08571600166', 1, '223221233', 'Pembelian Peralatan Lab IPA', 60000000, 4, '1', '1', 'Proses', 0, '2014-01-06 14:16:16', '2014-01-09 07:49:04', 'Administrator'),
(3, '2013-12-04', 1, 'Relokasi Sekolah', 'Bogor', NULL, NULL, 1, 'SMA Negeri 7 Bogor', 'Drs. Saipul Jamil', 'Jl. Cijeruk 8', '5', '6', '32', '3271', '3271040', '3271040007', 15418, '0251-3671221', '', 5, '554123339', 'Relokasi Sekolah', 80000000, 4, '1', '1', 'Proses', 0, '2014-01-06 14:20:49', '2014-01-09 07:49:12', 'Administrator'),
(4, '2014-01-01', 1, 'Biaya Sweeping', 'Jl. Cibadak No. 87', NULL, NULL, 5, 'FPI', 'Apoh', 'Jl. Cibadak No. 87', '2', '4', '32', '3271', '3271040', '3271040007', 15417, '0251-3667784', '08121002002', 8, '60032113', 'Pembiayaan Sweeping', 300000000, 2, '1', '1', 'Proses', 1, '2014-01-07 09:59:18', '2014-01-09 07:55:48', 'Administrator'),
(5, '2014-01-02', 2, 'Pembelian Pipa Distribusi', 'Jl. Salak Raya No.147', NULL, NULL, 3, 'PDAM', 'Pupung Wahyu Purnama', 'Jl. Salak Raya No.147', '6', '8', '32', '3271', '3271060', '3271060003', 15419, '0251-3657720', '08195002321', 8, '60032134', 'Pembelian Pipa Distribusi', 1000000000, 22, '0', '0', 'Proses', 0, '2014-01-07 10:02:43', '2014-01-09 07:48:46', 'Administrator'),
(6, '2014-01-09', 2, 'Pembelian Peralatan Perang', 'Bogor', NULL, NULL, 1, 'BMB', 'Tukul Arwana', 'Jl. Cililitan Timur 2A', '3', '4', '32', '3271', '3271040', '3271040004', 14547, '0251-4795473', '08561600166', 8, '1234567', 'Pembelian Peralatan Perang', 45000000, 2, '1', '0', 'Proses', 0, '2014-01-09 07:52:19', '2014-01-09 07:55:29', 'Administrator'),
(7, '2014-01-01', 1, 'a', 'a', NULL, NULL, 5, 'Masjid A', 'A', 'Jl. Mawar 3', '1', '1', '32', '3271', '3271010', '3271010001', 1, '1', '1', 1, '1', 'a', 30000000, 4, '0', '0', 'Proses', 0, '2014-01-13 17:32:40', '2014-01-13 17:32:40', 'Bagian Kemasyarakatan'),
(8, '2014-01-01', 1, 'b', 'b', NULL, NULL, 5, 'Masjid B', 'B', 'Jalan Mawar 3', '2', '2', '32', '3271', '3271020', '3271020001', 2, '2', '2', 1, '2', 'b', 15000000, 4, '0', '0', 'Proses', 0, '2014-01-13 17:33:49', '2014-01-13 17:33:49', 'Bagian Kemasyarakatan'),
(9, '2014-01-13', 1, 'C', 'C', NULL, NULL, 5, 'Masjid C', 'C', 'Jalan Melati 2', '3', '3', '32', '3271', '3271030', '3271030001', 3, '3', '3', 1, '3', 'C', 10000000, 18, '0', '0', 'Proses', 0, '2014-01-13 17:46:19', '2014-01-13 17:46:19', 'Administrator');


--
-- Dumping data for table `tbl_lpj_hibah`
--

INSERT INTO `tbl_lpj_hibah` (`hib_kode`, `tgl_lpj`, `uraian`) VALUES
(4, '2014-01-10', 'Test');


--
-- Dumping data for table `tbl_monev_bansos`
--

INSERT INTO `tbl_monev_bansos` (`ban_kode`, `tgl_monev`, `hasil`, `uraian`) VALUES
(4, '2014-01-08', 'Kurang', 'Test Monitoring dan Evaluasi');

--
-- Dumping data for table `tbl_monev_hibah`
--

INSERT INTO `tbl_monev_hibah` (`hib_kode`, `tgl_monev`, `hasil`, `uraian`) VALUES
(4, '2014-01-08', 'Kurang', 'Test Monitoring dan Evaluasi');


--
-- Dumping data for table `tbl_tim_evaluasi`
--

INSERT INTO `tbl_tim_evaluasi` (`id`, `nama`, `nip`, `kode`, `ctime`, `mtime`) VALUES
(1, 'Sugiman', '12345678', '1-HIBAH-QmBcfjC5bE', '2014-01-06 14:23:43', '2014-01-06 14:23:43'),
(2, 'Wagiman', '87654321', '1-HIBAH-QmBcfjC5bE', '2014-01-06 14:23:43', '2014-01-06 14:23:43'),
(3, 'Ahmad Fauzi', '54321876', '1-HIBAH-QmBcfjC5bE', '2014-01-06 14:23:43', '2014-01-06 14:23:43'),
(7, 'Ahmad', '123434', '1-BANSOS-VW789R02TC', '2014-01-07 10:54:45', '2014-01-07 10:54:45'),
(8, 'Fauzi', '543221', '1-BANSOS-VW789R02TC', '2014-01-07 10:54:45', '2014-01-07 10:54:45'),
(9, 'Dono', '12345678', '1-HIBAH-4MRMM8VJkP', '2014-01-09 07:55:48', '2014-01-09 07:55:48'),
(10, 'Kasino', '87654321', '1-HIBAH-4MRMM8VJkP', '2014-01-09 07:55:48', '2014-01-09 07:55:48'),
(11, 'Indro', '54321678', '1-HIBAH-4MRMM8VJkP', '2014-01-09 07:55:48', '2014-01-09 07:55:48');
