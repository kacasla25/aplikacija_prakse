-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2026 at 03:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikacija_prakse`
--

-- --------------------------------------------------------

--
-- Table structure for table `firma`
--

CREATE TABLE `firma` (
  `maticni_broj` varchar(20) NOT NULL,
  `id_korisnik` int(11) NOT NULL,
  `ime_firme` varchar(150) NOT NULL,
  `email_kontakt` varchar(100) DEFAULT NULL,
  `br_preostalih_oglasa` int(11) DEFAULT 0,
  `br_preostalih_vip` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `firma`
--

INSERT INTO `firma` (`maticni_broj`, `id_korisnik`, `ime_firme`, `email_kontakt`, `br_preostalih_oglasa`, `br_preostalih_vip`) VALUES
('123456789', 1, 'GOWI', 'gowi@gmail.com', 14, 2);

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id_korisnik` int(11) NOT NULL,
  `tip_korisnika` enum('admin','firma','kandidat') NOT NULL,
  `ime_prezime` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `datum_registracije` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id_korisnik`, `tip_korisnika`, `ime_prezime`, `email`, `lozinka`, `datum_registracije`) VALUES
(1, 'firma', 'kacaslavnic', 'kacaslavnic@gmail.com', 'kacaslavnic', '2026-01-14 18:40:10'),
(2, 'kandidat', 'damjanpopovic', 'damjanpopovic@gmail.com', 'damjanpopovic', '2026-01-14 18:46:00');

-- --------------------------------------------------------

--
-- Table structure for table `oglasi`
--

CREATE TABLE `oglasi` (
  `id_oglas` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL,
  `opis` text NOT NULL,
  `lokacija` varchar(255) NOT NULL,
  `model_rada` varchar(50) NOT NULL,
  `datum_objave` date DEFAULT curdate(),
  `datum_isteka` date DEFAULT NULL,
  `datum_pocetka_prakse` date DEFAULT NULL,
  `trajanje_prakse` varchar(50) DEFAULT NULL,
  `vestine` text DEFAULT NULL,
  `maticni_broj` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oglasi`
--

INSERT INTO `oglasi` (`id_oglas`, `naziv`, `opis`, `lokacija`, `model_rada`, `datum_objave`, `datum_isteka`, `datum_pocetka_prakse`, `trajanje_prakse`, `vestine`, `maticni_broj`) VALUES
(1, 'Customer Support', 'Tražimo komunikativnu i odgovornu osobu za poziciju Customer Support-a. Kandidat će biti zadužen za pružanje podrške korisnicima putem telefona, e-maila i četa, rešavanje upita i problema, kao i održavanje pozitivnog odnosa sa klijentima. Poželjne su dobre komunikacione veštine, strpljenje i spremnost za rad u timu. Prethodno iskustvo na sličnim pozicijama je prednost, ali nije obavezno.', 'Beograd', 'remote', '2026-01-14', '2026-01-30', '2026-01-31', '3 meseca', 'Dobre komunikacione veštine, strpljenje i ljubaznost u radu sa korisnicima, sposobnost rešavanja problema, rad na računaru (e-mail, chat, CRM sistemi), timski rad i odgovornost', '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `paketi`
--

CREATE TABLE `paketi` (
  `id_paket` int(11) NOT NULL,
  `naziv` varchar(100) DEFAULT NULL,
  `broj_oglasa` int(11) DEFAULT NULL,
  `broj_vip` int(11) DEFAULT NULL,
  `opis` text DEFAULT NULL,
  `cena` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paketi`
--

INSERT INTO `paketi` (`id_paket`, `naziv`, `broj_oglasa`, `broj_vip`, `opis`, `cena`) VALUES
(1, 'Start', 5, 0, 'Osnovni paket namenjen firmama koje prvi put objavljuju oglase i žele da testiraju platformu.', 20.00),
(2, 'Biznis', 15, 2, 'Paket za rastuće firme kojima je potrebna veća vidljivost i mogućnost isticanja oglasa.', 50.00),
(3, 'Pro', 30, 5, 'Napredni paket za firme koje aktivno zapošljavaju i žele maksimalnu prisutnost na platformi.', 150.00),
(4, 'Premium', 50, 10, 'Premium paket za kompanije koje žele potpunu dominaciju i prioritetno isticanje oglasa.', 250.00);

-- --------------------------------------------------------

--
-- Table structure for table `prijava`
--

CREATE TABLE `prijava` (
  `id_prijava` int(11) NOT NULL,
  `id_korisnik` int(11) NOT NULL,
  `id_oglas` int(11) NOT NULL,
  `datum_prijave` date NOT NULL DEFAULT curdate(),
  `status` varchar(50) NOT NULL DEFAULT 'Na čekanju',
  `cv` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prijava`
--

INSERT INTO `prijava` (`id_prijava`, `id_korisnik`, `id_oglas`, `datum_prijave`, `status`, `cv`) VALUES
(1, 2, 1, '2026-01-14', 'Na čekanju', '');

-- --------------------------------------------------------

--
-- Table structure for table `proces`
--

CREATE TABLE `proces` (
  `id_proces` int(11) NOT NULL,
  `id_prijava` int(11) NOT NULL,
  `proces` varchar(50) NOT NULL,
  `opis` text DEFAULT NULL,
  `datum_procesa` date NOT NULL,
  `rezultat` varchar(50) DEFAULT 'Čeka se'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proces`
--

INSERT INTO `proces` (`id_proces`, `id_prijava`, `proces`, `opis`, `datum_procesa`, `rezultat`) VALUES
(1, 1, 'HR intervju', '', '2026-01-14', 'U toku');

-- --------------------------------------------------------

--
-- Table structure for table `uplata`
--

CREATE TABLE `uplata` (
  `id_uplata` int(11) NOT NULL,
  `maticni_broj` varchar(20) DEFAULT NULL,
  `id_paket` int(11) DEFAULT NULL,
  `datum_uplate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uplata`
--

INSERT INTO `uplata` (`id_uplata`, `maticni_broj`, `id_paket`, `datum_uplate`) VALUES
(1, '123456789', 2, '2026-01-14 18:43:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `firma`
--
ALTER TABLE `firma`
  ADD PRIMARY KEY (`maticni_broj`),
  ADD KEY `id_korisnik` (`id_korisnik`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id_korisnik`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `oglasi`
--
ALTER TABLE `oglasi`
  ADD PRIMARY KEY (`id_oglas`),
  ADD KEY `maticni_broj` (`maticni_broj`);

--
-- Indexes for table `paketi`
--
ALTER TABLE `paketi`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `prijava`
--
ALTER TABLE `prijava`
  ADD PRIMARY KEY (`id_prijava`),
  ADD KEY `id_korisnik` (`id_korisnik`),
  ADD KEY `id_oglas` (`id_oglas`);

--
-- Indexes for table `proces`
--
ALTER TABLE `proces`
  ADD PRIMARY KEY (`id_proces`),
  ADD KEY `id_prijava` (`id_prijava`);

--
-- Indexes for table `uplata`
--
ALTER TABLE `uplata`
  ADD PRIMARY KEY (`id_uplata`),
  ADD KEY `maticni_broj` (`maticni_broj`),
  ADD KEY `id_paket` (`id_paket`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id_korisnik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oglasi`
--
ALTER TABLE `oglasi`
  MODIFY `id_oglas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paketi`
--
ALTER TABLE `paketi`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `prijava`
--
ALTER TABLE `prijava`
  MODIFY `id_prijava` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `proces`
--
ALTER TABLE `proces`
  MODIFY `id_proces` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uplata`
--
ALTER TABLE `uplata`
  MODIFY `id_uplata` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `firma`
--
ALTER TABLE `firma`
  ADD CONSTRAINT `firma_ibfk_1` FOREIGN KEY (`id_korisnik`) REFERENCES `korisnici` (`id_korisnik`);

--
-- Constraints for table `oglasi`
--
ALTER TABLE `oglasi`
  ADD CONSTRAINT `oglasi_ibfk_1` FOREIGN KEY (`maticni_broj`) REFERENCES `firma` (`maticni_broj`);

--
-- Constraints for table `prijava`
--
ALTER TABLE `prijava`
  ADD CONSTRAINT `prijava_ibfk_1` FOREIGN KEY (`id_korisnik`) REFERENCES `korisnici` (`id_korisnik`) ON DELETE CASCADE,
  ADD CONSTRAINT `prijava_ibfk_2` FOREIGN KEY (`id_oglas`) REFERENCES `oglasi` (`id_oglas`) ON DELETE CASCADE;

--
-- Constraints for table `proces`
--
ALTER TABLE `proces`
  ADD CONSTRAINT `proces_ibfk_1` FOREIGN KEY (`id_prijava`) REFERENCES `prijava` (`id_prijava`) ON DELETE CASCADE;

--
-- Constraints for table `uplata`
--
ALTER TABLE `uplata`
  ADD CONSTRAINT `uplata_ibfk_1` FOREIGN KEY (`maticni_broj`) REFERENCES `firma` (`maticni_broj`),
  ADD CONSTRAINT `uplata_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `paketi` (`id_paket`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
