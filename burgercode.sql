-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2016 at 04:42 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `burgercode_fini`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Menus'),
(2, 'Burgers'),
(3, 'Snacks'),
(4, 'Salads'),
(5, 'Drinks'),
(6, 'Desserts');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `image`, `category`) VALUES
(1, 'Menu Classic', 'Sandwich: Burger, Salad, Tomat, Acar + Kentang Goreng + Minuman', 30, 'm1.png', 1),
(2, 'Menu Bacon', 'Sandwich: Burger, Keju, Daging, Salad, Tomat + Kentang + Minuman', 35, 'm2.png', 1),
(3, 'Menu Big', 'Sandwich: Burger Ganda, Keju, Acar, Salad + Kentang + Minuman', 45, 'm3.png', 1),
(4, 'Menu Chicken', 'Sandwich: Ayam Goreng, Tomat, Salad, Mayones + Kentang Goreng + Minuman', 40, 'm4.png', 1),
(5, 'Menu Fish', 'Sandwich: Ikan, Salad, Mayones, Acar + Kentang Goreng + Minuman', 43, 'm5.png', 1),
(6, 'Menu Double Steak', 'Sandwich: Burger Ganda, Keju, Daging, Salad, Tomat + Kentang + Minuman', 50, 'm6.png', 1),
(7, 'Classic', 'Sandwich: Burger, Salad, Tomat, Acar', 20, 'b1.png', 2),
(8, 'Bacon', 'Sandwich: Burger, Keju, Daging, Salad, Tomat', 25, 'b2.png', 2),
(9, 'Big', 'Sandwich: Burger Ganda, Keju, Acar, Salad', 35, 'b3.png', 2),
(10, 'Chicken', 'Sandwich: Ayam Goreng, Tomat, Salad, Mayones', 30, 'b4.png', 2),
(11, 'Fish', 'Sandwich: Ikan Tepung Roti, Salad, Mayones, Gherkin', 36, 'b5.png', 2),
(12, 'Double Steak', 'Sandwich: Burger Ganda, Fromage, Bacon, Salade, Tomate', 40, 'b6.png', 2),
(13, 'Frites', 'kentang goreng', 12, 's1.png', 3),
(14, 'Onion Rings', 'Bawang goreng, Kentang goreng', 15, 's2.png', 3),
(15, 'Nuggets', 'Nugget ayam goreng', 18, 's3.png', 3),
(16, 'Nuggets Fromage', 'Bubur Nugget Ayam', 15, 's4.png', 3),
(17, 'Ailes de Poulet', 'Barbecue Chicken Wings', 15, 's5.png', 3),
(18, 'CÃ©sar Poulet PanÃ©', 'Ayam dilapisi tepung roti, Salad, Tomate et la fameuse sauce CÃ©sar', 30, 'sa1.png', 4),
(19, 'CÃ©sar Poulet GrillÃ©', 'Ayam Bakar, Salad, Tomat dan saus Caesar yang terkenal',30, 'sa2.png', 4),
(20, 'Salade Light', 'Salad, Tomat, Mentimun, Jagung, dan Cuka Balsamic',30, 'sa3.png', 4),
(21, 'Poulet PanÃ©', 'Ayam dilapisi tepung roti, Salad, Tomat dan saus pilihan Anda', 28, 'sa4.png', 4),
(22, 'Poulet GrillÃ©', 'Ayam Bakar, Salad, Tomat dan saus pilihan Anda', 28, 'sa5.png', 4),
(23, 'Coca-Cola', 'Pilihan: Kecil, Sedang atau Besar', 10, 'bo1.png', 5),
(24, 'Coca-Cola Light', 'Pilihan: Kecil, Sedang atau Besar', 10, 'bo2.png', 5),
(25, 'Coca-Cola Zero', 'Pilihan: Kecil, Sedang atau Besar', 10, 'bo3.png', 5),
(26, 'Fanta', 'Pilihan: Kecil, Sedang atau Besar', 10, 'bo4.png', 5),
(27, 'Sprite', 'Pilihan: Kecil, Sedang atau Besar', 10, 'bo5.png', 5),
(28, 'Nestea', 'Pilihan: Kecil, Sedang atau Besar', 10, 'bo6.png', 5),
(29, 'Fondant au chocolat', 'Pilihan: Coklat putih atau susu', 19, 'd1.png', 6),
(30, 'Muffin', 'Pilihan: Buah atau cokelat', 14, 'd2.png', 6),
(31, 'Beignet', 'Pilihan: Cokelat atau vanila', 13, 'd3.png', 6),
(32, 'Milkshake', 'Pilihan: Stroberi, Vanilla, atau Cokelat', 18, 'd4.png', 6),
(33, 'Sundae', 'Pilihan: Stroberi, Karamel, atau Cokelat', 20, 'd5.png', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
