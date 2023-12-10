-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2023 at 09:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flower`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `code` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`code`, `name`) VALUES
(1, 'INFORMATIQUE'),
(2, 'Phone Accessories'),
(3, 'Gaming'),
(5, 'Camera Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `flower2`
--

CREATE TABLE `flower2` (
  `code` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `quantite_en_stock` int(11) NOT NULL,
  `prix_unitaire` int(11) NOT NULL,
  `promo` varchar(255) NOT NULL,
  `code_c` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flower2`
--

INSERT INTO `flower2` (`code`, `designation`, `quantite_en_stock`, `prix_unitaire`, `promo`, `code_c`, `image`) VALUES
(59, 'PC1', 3, 69420, '20', 3, 'desktop-computer-isolated-2240001.jpg'),
(65, 'test', 22, 22, '0', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `admin`) VALUES
('Mahdi', 'password', 0),
('admin', 'admin', 1),
('Tester', 'password', 0),
('Tester1', 'test', 0),
('Tester2', 'test', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD KEY `code` (`code`);

--
-- Indexes for table `flower2`
--
ALTER TABLE `flower2`
  ADD PRIMARY KEY (`code`),
  ADD KEY `code_c` (`code_c`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flower2`
--
ALTER TABLE `flower2`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flower2`
--
ALTER TABLE `flower2`
  ADD CONSTRAINT `flower2_ibfk_1` FOREIGN KEY (`code_c`) REFERENCES `categorie` (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
