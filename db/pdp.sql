-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 03, 2018 at 11:22 AM
-- Server version: 10.1.34-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pdp`
--

-- --------------------------------------------------------

--
-- Table structure for table `Chat`
--

CREATE TABLE `Chat` (
  `tgl_chat` datetime NOT NULL,
  `ip_address` varchar(25) NOT NULL,
  `host` varchar(25) NOT NULL,
  `id_mhs1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ChatDetail`
--

CREATE TABLE `ChatDetail` (
  `id_pesan` int(11) NOT NULL,
  `id_chat` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `comment` varchar(200) NOT NULL,
  `like` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `ID` int(11) NOT NULL,
  `OldID` varchar(10) DEFAULT NULL,
  `Login` varchar(20) DEFAULT NULL,
  `Password` varchar(10) NOT NULL DEFAULT '',
  `Description` varchar(255) NOT NULL DEFAULT '',
  `Name` varchar(50) NOT NULL DEFAULT '',
  `Email` varchar(50) DEFAULT NULL,
  `Phone` varchar(30) DEFAULT NULL,
  `photo` varchar(60) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `path` varchar(60) NOT NULL DEFAULT 'N',
  `NotActive` enum('Y','N') NOT NULL DEFAULT 'N',
  `Gelar` varchar(100) DEFAULT NULL,
  `KodeFakultas` varchar(10) DEFAULT NULL,
  `KodeJurusan` varchar(10) DEFAULT NULL,
  `KodeGolongan` varchar(10) DEFAULT NULL,
  `TglMasuk` date DEFAULT '0000-00-00',
  `TglKeluar` date DEFAULT '0000-00-00',
  `KodeStatus` varchar(10) DEFAULT NULL,
  `InstansiInduk` varchar(10) DEFAULT NULL,
  `KodeDosen` varchar(10) DEFAULT NULL,
  `Alamat1` varchar(100) DEFAULT NULL,
  `Alamat2` varchar(100) DEFAULT NULL,
  `Kota` varchar(50) DEFAULT NULL,
  `Propinsi` varchar(50) DEFAULT NULL,
  `Negara` varchar(50) DEFAULT NULL,
  `KodePos` varchar(20) DEFAULT NULL,
  `TempatLahir` varchar(100) DEFAULT NULL,
  `TglLahir` date DEFAULT NULL,
  `Sex` char(1) DEFAULT NULL,
  `AgamaID` int(11) DEFAULT NULL,
  `JabatanOrganisasi` varchar(10) DEFAULT NULL,
  `JabatanAkademik` char(1) DEFAULT NULL,
  `JabatanDikti` char(1) DEFAULT NULL,
  `KTP` varchar(50) DEFAULT NULL,
  `JenjangDosen` char(1) DEFAULT NULL,
  `LulusanPT` varchar(100) DEFAULT NULL,
  `Ilmu` varchar(100) DEFAULT NULL,
  `Akta` enum('Y','N') NOT NULL DEFAULT 'N',
  `Ijin` enum('Y','N') NOT NULL DEFAULT 'N',
  `Bank` varchar(100) DEFAULT NULL,
  `AccountName` varchar(100) DEFAULT NULL,
  `AccountNumber` varchar(100) DEFAULT NULL,
  `lastactivity` int(11) DEFAULT '0',
  `NIDN` varchar(15) NOT NULL,
  `NIK` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jenjangps`
--

CREATE TABLE `jenjangps` (
  `Kode` char(1) NOT NULL DEFAULT '',
  `Nama` varchar(20) NOT NULL DEFAULT '',
  `Ket` varchar(25) DEFAULT NULL,
  `NotActive` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mhsw`
--

CREATE TABLE `mhsw` (
  `ID` bigint(20) NOT NULL,
  `Login` varchar(10) DEFAULT NULL,
  `Password` varchar(10) DEFAULT NULL,
  `Level` int(11) NOT NULL DEFAULT '4',
  `Description` varchar(255) DEFAULT NULL,
  `NIM` varchar(10) NOT NULL DEFAULT '',
  `PMBID` varchar(20) DEFAULT NULL,
  `NIRM` varchar(20) DEFAULT NULL,
  `Tanggal` date DEFAULT NULL,
  `Name` varchar(50) NOT NULL DEFAULT '',
  `Email` varchar(50) DEFAULT NULL,
  `Sex` char(1) NOT NULL DEFAULT 'L',
  `TempatLahir` varchar(50) DEFAULT NULL,
  `TglLahir` date DEFAULT NULL,
  `RealTglLahir` varchar(35) NOT NULL,
  `Alamat1` varchar(100) DEFAULT NULL,
  `Alamat2` varchar(100) DEFAULT NULL,
  `RT` varchar(4) DEFAULT NULL,
  `RW` varchar(4) DEFAULT NULL,
  `Kota` varchar(50) DEFAULT NULL,
  `KodePos` varchar(10) DEFAULT NULL,
  `KodeTelp` varchar(5) DEFAULT NULL,
  `Phone` varchar(30) DEFAULT NULL,
  `photo` varchar(50) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `path` varchar(60) DEFAULT 'N',
  `Agama` varchar(20) DEFAULT NULL,
  `AgamaID` int(11) DEFAULT '0',
  `WargaNegara` varchar(30) DEFAULT NULL,
  `SudahBekerja` enum('Y','N') NOT NULL DEFAULT 'N',
  `NamaPrsh` varchar(50) DEFAULT NULL,
  `Alamat1Prsh` varchar(100) DEFAULT NULL,
  `Alamat2Prsh` varchar(100) DEFAULT NULL,
  `KotaPrsh` varchar(50) DEFAULT NULL,
  `TelpPrsh` varchar(20) DEFAULT NULL,
  `FaxPrsh` varchar(20) DEFAULT NULL,
  `NamaOT` varchar(50) DEFAULT NULL,
  `PekerjaanOT` varchar(50) DEFAULT NULL,
  `AlamatOT1` varchar(100) DEFAULT NULL,
  `AlamatOT2` varchar(100) DEFAULT NULL,
  `RTOT` varchar(4) DEFAULT NULL,
  `RWOT` varchar(4) DEFAULT NULL,
  `KotaOT` varchar(50) DEFAULT NULL,
  `KodeTelpOT` varchar(4) DEFAULT NULL,
  `TelpOT` varchar(30) DEFAULT NULL,
  `EmailOT` varchar(50) DEFAULT NULL,
  `KodePosOT` varchar(10) DEFAULT NULL,
  `AsalSekolah` varchar(50) DEFAULT NULL,
  `PropSekolah` varchar(5) DEFAULT NULL,
  `JenisSekolah` varchar(10) DEFAULT NULL,
  `LulusSekolah` varchar(5) DEFAULT NULL,
  `IjazahSekolah` varchar(50) DEFAULT NULL,
  `NilaiSekolah` decimal(5,2) DEFAULT '0.00',
  `Pilihan1` varchar(100) DEFAULT NULL,
  `Pilihan2` varchar(100) DEFAULT NULL,
  `KodeFakultas` varchar(10) DEFAULT NULL,
  `KodeJurusan` varchar(10) DEFAULT NULL,
  `Status` varchar(5) DEFAULT NULL,
  `KodeProgram` varchar(10) DEFAULT NULL,
  `StatusAwal` varchar(5) DEFAULT NULL,
  `StatusPotongan` varchar(5) DEFAULT NULL,
  `SPP_D` int(11) NOT NULL DEFAULT '0',
  `Semester` int(11) DEFAULT NULL,
  `TahunAkademik` varchar(5) DEFAULT NULL,
  `KodeBiaya` varchar(5) DEFAULT NULL,
  `Posting` char(1) DEFAULT NULL,
  `Lulus` enum('Y','N') NOT NULL DEFAULT 'N',
  `TglLulus` date DEFAULT NULL,
  `TahunLulus` varchar(5) DEFAULT NULL,
  `WaktuKuliah` varchar(10) DEFAULT NULL,
  `Keterangan` varchar(100) DEFAULT NULL,
  `Pinjaman` int(11) DEFAULT NULL,
  `KTahun` date DEFAULT NULL,
  `K_Dosen` varchar(10) DEFAULT NULL,
  `DosenID` int(11) NOT NULL DEFAULT '0',
  `Ranking` int(11) DEFAULT NULL,
  `mGroup` char(1) DEFAULT NULL,
  `Target` int(11) DEFAULT NULL,
  `Prop` varchar(10) DEFAULT NULL,
  `Masuk` date DEFAULT NULL,
  `NotActive` enum('Y','N') NOT NULL DEFAULT 'N',
  `TestScore` int(11) DEFAULT '0',
  `TA` enum('Y','N') NOT NULL DEFAULT 'N',
  `TglTA` date DEFAULT NULL,
  `TotalSKS` int(11) NOT NULL DEFAULT '0',
  `IPK` decimal(5,2) NOT NULL DEFAULT '0.00',
  `JudulTA` varchar(255) DEFAULT NULL,
  `PembimbingTA` int(11) DEFAULT NULL,
  `DosenTA2` varchar(30) DEFAULT NULL,
  `tglx` varchar(25) DEFAULT NULL,
  `CatatanTA` text,
  `PMBSyarat` varchar(100) DEFAULT NULL,
  `PMBKurang` varchar(100) DEFAULT NULL,
  `NomerIjazah` varchar(255) DEFAULT NULL,
  `MGM` enum('Y','N') NOT NULL DEFAULT 'N',
  `MGMOleh` int(11) DEFAULT NULL,
  `MGMHonor` int(11) DEFAULT NULL,
  `lastactivity` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mhsw_transfer`
--

CREATE TABLE `mhsw_transfer` (
  `id` int(11) NOT NULL,
  `nim` varchar(9) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Modul`
--

CREATE TABLE `Modul` (
  `id` int(11) NOT NULL,
  `kategori` varchar(20) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `urutan` tinyint(4) NOT NULL,
  `menu_web` enum('YES','NO') NOT NULL,
  `menu_cs` enum('YES','NO') NOT NULL,
  `link` varchar(35) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_seminar_hasil`
--

CREATE TABLE `m_seminar_hasil` (
  `Id_M_Sem_Hasil` int(11) NOT NULL,
  `Id_ta` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Tanggal` date NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `m_sempro`
--

CREATE TABLE `m_sempro` (
  `Id_M_Sempro` int(11) NOT NULL,
  `Id_ta` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Tanggal` date NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pdp_dosen`
--

CREATE TABLE `pdp_dosen` (
  `ID` int(11) NOT NULL,
  `OldID` varchar(10) DEFAULT NULL,
  `Login` varchar(20) DEFAULT NULL,
  `Password` varchar(10) NOT NULL DEFAULT '',
  `Description` varchar(255) NOT NULL DEFAULT '',
  `Name` varchar(50) NOT NULL DEFAULT '',
  `Email` varchar(50) DEFAULT NULL,
  `Phone` varchar(30) DEFAULT NULL,
  `photo` varchar(60) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `path` varchar(60) NOT NULL DEFAULT 'N',
  `NotActive` enum('Y','N') NOT NULL DEFAULT 'N',
  `Gelar` varchar(100) DEFAULT NULL,
  `KodeFakultas` varchar(10) DEFAULT NULL,
  `KodeJurusan` varchar(10) DEFAULT NULL,
  `KodeGolongan` varchar(10) DEFAULT NULL,
  `TglMasuk` date DEFAULT '0000-00-00',
  `TglKeluar` date DEFAULT '0000-00-00',
  `KodeStatus` varchar(10) DEFAULT NULL,
  `InstansiInduk` varchar(10) DEFAULT NULL,
  `KodeDosen` varchar(10) DEFAULT NULL,
  `Alamat1` varchar(100) DEFAULT NULL,
  `Alamat2` varchar(100) DEFAULT NULL,
  `Kota` varchar(50) DEFAULT NULL,
  `Propinsi` varchar(50) DEFAULT NULL,
  `Negara` varchar(50) DEFAULT NULL,
  `KodePos` varchar(20) DEFAULT NULL,
  `TempatLahir` varchar(100) DEFAULT NULL,
  `TglLahir` date DEFAULT NULL,
  `Sex` char(1) DEFAULT NULL,
  `AgamaID` int(11) DEFAULT NULL,
  `JabatanOrganisasi` varchar(10) DEFAULT NULL,
  `JabatanAkademik` char(1) DEFAULT NULL,
  `JabatanDikti` char(1) DEFAULT NULL,
  `KTP` varchar(50) DEFAULT NULL,
  `JenjangDosen` char(1) DEFAULT NULL,
  `LulusanPT` varchar(100) DEFAULT NULL,
  `Ilmu` varchar(100) DEFAULT NULL,
  `Akta` enum('Y','N') NOT NULL DEFAULT 'N',
  `Ijin` enum('Y','N') NOT NULL DEFAULT 'N',
  `Bank` varchar(100) DEFAULT NULL,
  `AccountName` varchar(100) DEFAULT NULL,
  `AccountNumber` varchar(100) DEFAULT NULL,
  `lastactivity` int(11) DEFAULT '0',
  `NIDN` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pdp_mhsw`
--

CREATE TABLE `pdp_mhsw` (
  `nim` varchar(12) NOT NULL,
  `nim_enkripsi` varchar(35) NOT NULL,
  `namalengkap` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alamat` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabel Mahasiswa';

-- --------------------------------------------------------

--
-- Table structure for table `pdp_prodi`
--

CREATE TABLE `pdp_prodi` (
  `idprodi` int(11) NOT NULL,
  `nm_prodi` varchar(100) NOT NULL,
  `singkatan` varchar(5) NOT NULL,
  `email` varchar(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  `fb` varchar(200) NOT NULL,
  `twitter` varchar(200) NOT NULL,
  `telp` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pdp_pt`
--

CREATE TABLE `pdp_pt` (
  `kdpt` int(11) NOT NULL,
  `nama_pt` varchar(250) NOT NULL,
  `alamat_pt` varchar(250) NOT NULL,
  `url` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `fb` varchar(250) NOT NULL,
  `twitter` varchar(250) NOT NULL,
  `google_drive` varchar(250) NOT NULL,
  `telp` varchar(12) NOT NULL,
  `fax` varchar(12) NOT NULL,
  `hp` varchar(12) NOT NULL,
  `status` varchar(50) NOT NULL,
  `motto` varchar(250) NOT NULL,
  `izin` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabel Perguruan Tinggi';

-- --------------------------------------------------------

--
-- Table structure for table `programstudi`
--

CREATE TABLE `programstudi` (
  `IDProdi` int(11) NOT NULL,
  `Kode` char(3) NOT NULL,
  `Fakultas` varchar(100) NOT NULL,
  `Prodi` varchar(50) NOT NULL,
  `KaProdi` varchar(50) NOT NULL,
  `NIDN` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `statistik`
--

CREATE TABLE `statistik` (
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_acc_seminar`
--

CREATE TABLE `tbl_acc_seminar` (
  `NIM` varchar(10) NOT NULL,
  `Dosen1` int(1) NOT NULL,
  `Dosen2` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_acc_sidang`
--

CREATE TABLE `tbl_acc_sidang` (
  `NIM` varchar(10) NOT NULL,
  `Dosen1` int(1) NOT NULL,
  `Dosen2` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_akademik`
--

CREATE TABLE `tbl_akademik` (
  `id_akd` int(11) NOT NULL,
  `user_akd` varchar(25) NOT NULL,
  `pwd_akd` varchar(15) NOT NULL,
  `kd_prodi` char(3) NOT NULL,
  `fullname_akd` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_aktivasi_mhs`
--

CREATE TABLE `tbl_aktivasi_mhs` (
  `NIM` varchar(10) NOT NULL,
  `Status` enum('0','1') NOT NULL,
  `TglAktif` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Tahun` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bahasa`
--

CREATE TABLE `tbl_bahasa` (
  `id` int(3) NOT NULL,
  `nama` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bayar_seminar`
--

CREATE TABLE `tbl_bayar_seminar` (
  `id_bayar` int(11) NOT NULL,
  `NIM` varchar(11) NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `jml_uang` int(8) NOT NULL,
  `uang_kembali` int(8) NOT NULL,
  `ip_user` varchar(12) NOT NULL,
  `TA` varchar(5) NOT NULL,
  `STATUS` int(1) NOT NULL,
  `USER` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_berita`
--

CREATE TABLE `tbl_berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `resume` tinytext NOT NULL,
  `isi` text NOT NULL,
  `author` varchar(35) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_biro`
--

CREATE TABLE `tbl_biro` (
  `id` int(11) NOT NULL,
  `nik` varchar(15) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `bagian` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_history_judul`
--

CREATE TABLE `tbl_history_judul` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `prodi` varchar(5) NOT NULL,
  `judul_lama` varchar(255) NOT NULL,
  `judul_baru` varchar(255) NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `op` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_judul`
--

CREATE TABLE `tbl_judul` (
  `id` int(11) NOT NULL,
  `nim` varchar(12) NOT NULL,
  `prodi` enum('SI','SK') NOT NULL,
  `judul` varchar(250) NOT NULL,
  `latar` text NOT NULL,
  `rumusan` text NOT NULL,
  `batasan` text NOT NULL,
  `tujuan` text NOT NULL,
  `manfaat` text NOT NULL,
  `instansi` varchar(100) NOT NULL,
  `bahasa` varchar(100) NOT NULL,
  `status` enum('SUDAH ACC','SUDAH DITOLAK','SEDANG DIPROSES','TIDAK ADA JUDUL') DEFAULT 'TIDAK ADA JUDUL',
  `asesor` varchar(35) NOT NULL,
  `objek` varchar(100) NOT NULL,
  `tgl_pengajuan` datetime NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `id_dosen1` varchar(15) NOT NULL,
  `id_dosen2` varchar(15) NOT NULL,
  `Mbimbingan` date NOT NULL,
  `Sbimbingan` date NOT NULL,
  `KodeSurat` varchar(3) NOT NULL,
  `NoSurat` varchar(30) NOT NULL,
  `comment` text NOT NULL,
  `dosenrekom` int(11) NOT NULL,
  `tgl_rekom` date NOT NULL,
  `comment_rekom` text NOT NULL,
  `rekomendasi` enum('YA','TIDAK','BELUM') DEFAULT NULL,
  `id_ta` int(2) NOT NULL,
  `tahun` int(5) NOT NULL,
  `IsEmpty` enum('N','Y') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_judul_lama`
--

CREATE TABLE `tbl_judul_lama` (
  `id` int(11) NOT NULL,
  `nim` varchar(12) NOT NULL,
  `prodi` enum('SI','SK') NOT NULL,
  `judul` varchar(250) NOT NULL,
  `latar` text NOT NULL,
  `rumusan` text NOT NULL,
  `batasan` text NOT NULL,
  `tujuan` text NOT NULL,
  `manfaat` text NOT NULL,
  `instansi` varchar(100) NOT NULL,
  `bahasa` varchar(100) NOT NULL,
  `status` enum('SUDAH ACC','SUDAH DITOLAK','SEDANG DIPROSES') DEFAULT 'SEDANG DIPROSES',
  `asesor` varchar(35) NOT NULL,
  `objek` varchar(100) NOT NULL,
  `tgl_pengajuan` datetime NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `id_dosen1` varchar(15) NOT NULL,
  `id_dosen2` varchar(15) NOT NULL,
  `comment` text NOT NULL,
  `id_ta` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_judul_rekomendasi`
--

CREATE TABLE `tbl_judul_rekomendasi` (
  `id_judul` int(11) NOT NULL,
  `nidn` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `id_pejabat` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_biaya`
--

CREATE TABLE `tbl_master_biaya` (
  `ID` int(11) NOT NULL,
  `JENIS` varchar(15) NOT NULL,
  `BIAYA` int(11) NOT NULL,
  `TA` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pejabat`
--

CREATE TABLE `tbl_pejabat` (
  `id` int(11) NOT NULL,
  `nidn` varchar(25) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `periode` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembayaran`
--

CREATE TABLE `tbl_pembayaran` (
  `ID` int(11) NOT NULL,
  `NIM` varchar(15) NOT NULL,
  `STATUS_BYR` enum('LUNAS','BELUM LUNAS') NOT NULL DEFAULT 'BELUM LUNAS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembimbing`
--

CREATE TABLE `tbl_pembimbing` (
  `IDPembimbing` int(11) NOT NULL,
  `NIM` varchar(10) NOT NULL,
  `Prodi` varchar(2) NOT NULL,
  `IDDosen1` int(4) NOT NULL,
  `IDDosen2` int(4) NOT NULL,
  `Mbimbingan` date NOT NULL,
  `Sbimbingan` date NOT NULL,
  `KodeSurat` varchar(3) NOT NULL,
  `NoSurat` varchar(30) NOT NULL,
  `Tahun` int(5) NOT NULL,
  `TglSet` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seleksi_judul`
--

CREATE TABLE `tbl_seleksi_judul` (
  `idjudul` int(11) NOT NULL,
  `iddosen1` varchar(25) DEFAULT NULL,
  `iddosen2` varchar(25) DEFAULT NULL,
  `iddosen3` varchar(25) DEFAULT NULL,
  `rek1` tinyint(1) DEFAULT NULL,
  `rek2` tinyint(1) DEFAULT NULL,
  `rek3` tinyint(1) DEFAULT NULL,
  `ket1` text,
  `ket2` text,
  `ket3` text,
  `tglseleksi1` varchar(100) DEFAULT NULL,
  `tglseleksi2` varchar(100) DEFAULT NULL,
  `tglseleksi3` varchar(100) DEFAULT NULL,
  `kep_prodi` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seminar`
--

CREATE TABLE `tbl_seminar` (
  `IDSeminar` int(11) NOT NULL,
  `JenisSeminar` enum('Proposal','Hasil') NOT NULL,
  `NIM` int(10) NOT NULL,
  `Prodi` varchar(2) NOT NULL,
  `IDKetua` int(4) NOT NULL,
  `IDPenguji1` int(4) NOT NULL,
  `IDPenguji2` int(4) NOT NULL,
  `Tanggal` date NOT NULL,
  `Jam` varchar(5) NOT NULL,
  `Ruang` varchar(100) NOT NULL,
  `Tahun` int(5) NOT NULL,
  `Gelombang` enum('1','2','3','4','5','6','7','8') NOT NULL,
  `Seminar` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seminar_hasil`
--

CREATE TABLE `tbl_seminar_hasil` (
  `ID_Seminar_hasil` int(11) NOT NULL,
  `ID_M_Seminar_Hasil` int(11) NOT NULL,
  `ID_judul` int(11) NOT NULL,
  `NIM` varchar(10) NOT NULL,
  `Prodi` varchar(2) NOT NULL,
  `Doping1` int(4) NOT NULL,
  `Doping2` int(4) NOT NULL,
  `Penguji` int(4) NOT NULL,
  `Penguji_Eksternal` varchar(50) NOT NULL,
  `Ka_Penguji` int(4) NOT NULL,
  `Ka_Penguji_Eksternal` varchar(50) NOT NULL,
  `Jam` varchar(20) NOT NULL,
  `Ruang` varchar(50) NOT NULL,
  `Tanggal` date NOT NULL,
  `Is_seminar` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sempro`
--

CREATE TABLE `tbl_sempro` (
  `ID_Sempro` int(11) NOT NULL,
  `ID_M_Sempro` int(11) NOT NULL,
  `ID_judul` int(11) NOT NULL,
  `NIM` varchar(10) NOT NULL,
  `Prodi` varchar(2) NOT NULL,
  `Doping1` int(4) NOT NULL,
  `Doping2` int(4) NOT NULL,
  `Penguji` int(4) NOT NULL,
  `Penguji_Eksternal` varchar(50) NOT NULL,
  `Ka_Penguji` int(4) NOT NULL,
  `Ka_Penguji_Eksternal` varchar(50) NOT NULL,
  `Jam` varchar(50) NOT NULL,
  `Ruang` varchar(50) NOT NULL,
  `Tanggal` date NOT NULL,
  `Is_sempro` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sidang`
--

CREATE TABLE `tbl_sidang` (
  `IDSidang` int(11) NOT NULL,
  `NIM` int(10) NOT NULL,
  `Prodi` varchar(2) NOT NULL,
  `IDKetua` int(4) NOT NULL,
  `IDPenguji1` int(4) NOT NULL,
  `IDPenguji2` int(4) NOT NULL,
  `Tanggal` date NOT NULL,
  `Jam` varchar(5) NOT NULL,
  `Ruang` varchar(100) NOT NULL,
  `Tahun` int(5) NOT NULL,
  `Gelombang` enum('1','2','3','4','5','6','7','8') NOT NULL,
  `Sidang` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff_prodi`
--

CREATE TABLE `tbl_staff_prodi` (
  `IDStaff` int(11) NOT NULL,
  `NIK` varchar(15) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `KodeProdi` varchar(3) NOT NULL,
  `JenisKelamin` varchar(1) NOT NULL,
  `TglLahir` date NOT NULL,
  `TempatLahir` varchar(100) NOT NULL,
  `Alamat` varchar(255) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Bagian` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_surat`
--

CREATE TABLE `tbl_surat` (
  `ID` int(11) NOT NULL,
  `Nomor` varchar(25) NOT NULL,
  `Jenis` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ta`
--

CREATE TABLE `tbl_ta` (
  `id_ta` int(2) NOT NULL,
  `kode` int(5) NOT NULL,
  `tahun` varchar(10) NOT NULL,
  `ket` varchar(25) NOT NULL,
  `aktif` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_team_seleksi_judul`
--

CREATE TABLE `tbl_team_seleksi_judul` (
  `nidn` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `gelar` varchar(255) NOT NULL,
  `bidang_ilmu` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `jf` varchar(255) NOT NULL,
  `js` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `grade` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tim_adhock`
--

CREATE TABLE `tbl_tim_adhock` (
  `id` int(11) NOT NULL,
  `iddosen` int(11) NOT NULL,
  `nama_dosen` varchar(50) NOT NULL,
  `prodi` varchar(50) NOT NULL,
  `kuota` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tim_seleksi`
--

CREATE TABLE `tbl_tim_seleksi` (
  `id` int(11) NOT NULL,
  `iddosen` int(11) NOT NULL,
  `nama_dosen` varchar(50) NOT NULL,
  `prodi` varchar(50) NOT NULL,
  `kuota` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_uang_masuk`
--

CREATE TABLE `tbl_uang_masuk` (
  `id` int(11) NOT NULL,
  `user` varchar(25) NOT NULL,
  `NIM` varchar(15) NOT NULL,
  `TA` varchar(5) NOT NULL,
  `jenis_bayar` enum('PKL','SKRIPSI') NOT NULL,
  `besar_uang` int(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `uang_kembali` int(11) NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `ip_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `password` varchar(35) NOT NULL,
  `level` enum('1','2','3','4','5','6') NOT NULL,
  `nama` varchar(35) NOT NULL,
  `prodi` char(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `posisi_dosen` int(1) NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Chat`
--
ALTER TABLE `Chat`
  ADD PRIMARY KEY (`id_mhs1`);

--
-- Indexes for table `ChatDetail`
--
ALTER TABLE `ChatDetail`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `jenjangps`
--
ALTER TABLE `jenjangps`
  ADD PRIMARY KEY (`Kode`);

--
-- Indexes for table `mhsw`
--
ALTER TABLE `mhsw`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `NIM` (`NIM`),
  ADD KEY `Login` (`Login`),
  ADD KEY `PMBID` (`PMBID`);

--
-- Indexes for table `mhsw_transfer`
--
ALTER TABLE `mhsw_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Modul`
--
ALTER TABLE `Modul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_seminar_hasil`
--
ALTER TABLE `m_seminar_hasil`
  ADD PRIMARY KEY (`Id_M_Sem_Hasil`);

--
-- Indexes for table `m_sempro`
--
ALTER TABLE `m_sempro`
  ADD PRIMARY KEY (`Id_M_Sempro`);

--
-- Indexes for table `pdp_dosen`
--
ALTER TABLE `pdp_dosen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `pdp_mhsw`
--
ALTER TABLE `pdp_mhsw`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `pdp_prodi`
--
ALTER TABLE `pdp_prodi`
  ADD PRIMARY KEY (`idprodi`);

--
-- Indexes for table `pdp_pt`
--
ALTER TABLE `pdp_pt`
  ADD PRIMARY KEY (`kdpt`);

--
-- Indexes for table `programstudi`
--
ALTER TABLE `programstudi`
  ADD PRIMARY KEY (`IDProdi`);

--
-- Indexes for table `tbl_acc_seminar`
--
ALTER TABLE `tbl_acc_seminar`
  ADD PRIMARY KEY (`NIM`);

--
-- Indexes for table `tbl_acc_sidang`
--
ALTER TABLE `tbl_acc_sidang`
  ADD PRIMARY KEY (`NIM`);

--
-- Indexes for table `tbl_akademik`
--
ALTER TABLE `tbl_akademik`
  ADD PRIMARY KEY (`id_akd`);

--
-- Indexes for table `tbl_aktivasi_mhs`
--
ALTER TABLE `tbl_aktivasi_mhs`
  ADD PRIMARY KEY (`NIM`);

--
-- Indexes for table `tbl_bahasa`
--
ALTER TABLE `tbl_bahasa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bayar_seminar`
--
ALTER TABLE `tbl_bayar_seminar`
  ADD PRIMARY KEY (`id_bayar`);

--
-- Indexes for table `tbl_berita`
--
ALTER TABLE `tbl_berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_biro`
--
ALTER TABLE `tbl_biro`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_history_judul`
--
ALTER TABLE `tbl_history_judul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_judul`
--
ALTER TABLE `tbl_judul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_judul_lama`
--
ALTER TABLE `tbl_judul_lama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_judul_rekomendasi`
--
ALTER TABLE `tbl_judul_rekomendasi`
  ADD PRIMARY KEY (`id_judul`);

--
-- Indexes for table `tbl_master_biaya`
--
ALTER TABLE `tbl_master_biaya`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_pejabat`
--
ALTER TABLE `tbl_pejabat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_pembimbing`
--
ALTER TABLE `tbl_pembimbing`
  ADD PRIMARY KEY (`IDPembimbing`);

--
-- Indexes for table `tbl_seleksi_judul`
--
ALTER TABLE `tbl_seleksi_judul`
  ADD PRIMARY KEY (`idjudul`);

--
-- Indexes for table `tbl_seminar`
--
ALTER TABLE `tbl_seminar`
  ADD PRIMARY KEY (`IDSeminar`);

--
-- Indexes for table `tbl_seminar_hasil`
--
ALTER TABLE `tbl_seminar_hasil`
  ADD PRIMARY KEY (`ID_Seminar_hasil`);

--
-- Indexes for table `tbl_sempro`
--
ALTER TABLE `tbl_sempro`
  ADD PRIMARY KEY (`ID_Sempro`);

--
-- Indexes for table `tbl_sidang`
--
ALTER TABLE `tbl_sidang`
  ADD PRIMARY KEY (`IDSidang`);

--
-- Indexes for table `tbl_staff_prodi`
--
ALTER TABLE `tbl_staff_prodi`
  ADD PRIMARY KEY (`IDStaff`);

--
-- Indexes for table `tbl_surat`
--
ALTER TABLE `tbl_surat`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_ta`
--
ALTER TABLE `tbl_ta`
  ADD PRIMARY KEY (`id_ta`);

--
-- Indexes for table `tbl_team_seleksi_judul`
--
ALTER TABLE `tbl_team_seleksi_judul`
  ADD PRIMARY KEY (`nidn`);

--
-- Indexes for table `tbl_tim_adhock`
--
ALTER TABLE `tbl_tim_adhock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tim_seleksi`
--
ALTER TABLE `tbl_tim_seleksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_uang_masuk`
--
ALTER TABLE `tbl_uang_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Chat`
--
ALTER TABLE `Chat`
  MODIFY `id_mhs1` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ChatDetail`
--
ALTER TABLE `ChatDetail`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mhsw`
--
ALTER TABLE `mhsw`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mhsw_transfer`
--
ALTER TABLE `mhsw_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Modul`
--
ALTER TABLE `Modul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_seminar_hasil`
--
ALTER TABLE `m_seminar_hasil`
  MODIFY `Id_M_Sem_Hasil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_sempro`
--
ALTER TABLE `m_sempro`
  MODIFY `Id_M_Sempro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pdp_dosen`
--
ALTER TABLE `pdp_dosen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programstudi`
--
ALTER TABLE `programstudi`
  MODIFY `IDProdi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_akademik`
--
ALTER TABLE `tbl_akademik`
  MODIFY `id_akd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_bahasa`
--
ALTER TABLE `tbl_bahasa`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_bayar_seminar`
--
ALTER TABLE `tbl_bayar_seminar`
  MODIFY `id_bayar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_berita`
--
ALTER TABLE `tbl_berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_biro`
--
ALTER TABLE `tbl_biro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_history_judul`
--
ALTER TABLE `tbl_history_judul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_judul`
--
ALTER TABLE `tbl_judul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_judul_lama`
--
ALTER TABLE `tbl_judul_lama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_master_biaya`
--
ALTER TABLE `tbl_master_biaya`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pejabat`
--
ALTER TABLE `tbl_pejabat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pembimbing`
--
ALTER TABLE `tbl_pembimbing`
  MODIFY `IDPembimbing` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_seminar`
--
ALTER TABLE `tbl_seminar`
  MODIFY `IDSeminar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_seminar_hasil`
--
ALTER TABLE `tbl_seminar_hasil`
  MODIFY `ID_Seminar_hasil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sempro`
--
ALTER TABLE `tbl_sempro`
  MODIFY `ID_Sempro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sidang`
--
ALTER TABLE `tbl_sidang`
  MODIFY `IDSidang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_staff_prodi`
--
ALTER TABLE `tbl_staff_prodi`
  MODIFY `IDStaff` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_surat`
--
ALTER TABLE `tbl_surat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_ta`
--
ALTER TABLE `tbl_ta`
  MODIFY `id_ta` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tim_adhock`
--
ALTER TABLE `tbl_tim_adhock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tim_seleksi`
--
ALTER TABLE `tbl_tim_seleksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_uang_masuk`
--
ALTER TABLE `tbl_uang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
