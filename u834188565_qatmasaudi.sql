-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 28, 2026 at 12:52 PM
-- Server version: 11.8.9-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u834188565_qatmasaudi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$Q7h79XyIrFP8WT0BcVulB.KH2A/h4b6KknI6LRFVYxxC2K3hVNGvi');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `weight` varchar(100) NOT NULL,
  `badge` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `image`, `weight`, `badge`, `created_at`) VALUES
(1, 'قطميتوس - فلفل حار وحلو', 'رقائق التورتيلا المقرمشة بنكهة الفلفل الحلو والحار، الخيار المثالي لعشاق الإثارة.', 'images/WhatsApp Image 2026-05-09 at 2.43.43 PM.jpeg', '30 جرام & 12 جرام', 'صنع في السعودية', '2026-09-28 12:13:23'),
(2, 'قطمة - Burning Hot', 'حرارة تشعل الجو! منتفخات ذرة مقرمشة بنكهة الفلفل الحار جداً، صممت خصيصاً لمحبي التحدي والإثارة.', 'images/WhatsApp Image 2026-05-09 at 2.43.10 PM.jpeg', '30 جرام & 15 جرام', 'جودة فاخرة', '2026-09-28 12:13:23'),
(3, 'فشار قطمة - نكهة الزبدة', 'فشار طبيعي 100% بنكهة الزبدة الغنية، خفيف ومقرمش في كل حبة.', 'images/1790598377_1000178442.jpg', '15 جرام', 'جودة فاخرة', '2026-09-28 12:13:23'),
(4, 'فشار قطمة - نكهة الجبنة', 'نكهة الجبنة الفرنسية الأصلية مع حبات الفشار الذهبية المحضرة بعناية.', 'images/1790598353_1000178439.jpg', '15 جرام', 'جودة فاخرة', '2026-09-28 12:13:23'),
(5, 'ويفر إيفانو - كريمة الشوكولاتة', 'ويفر فاخر محشو بكريمة الشوكولاتة الغنية، يذوب في الفم ويغير مودك.', 'images/1790598854_1000178057.jpg', '24 قطعة', 'جودة فاخرة', '2026-09-28 12:13:23'),
(6, 'ويفر إيفانو - كريمة البندق', 'ويفر مقرمش محشو بأجود أنواع كريمة البندق، مذاق غني في كل قضمة.', 'images/1790598832_1000178063.jpg', '24 قطعة', 'جودة فاخرة', '2026-09-28 12:13:23'),
(7, 'ويفر إيفانو - كريمة الفانيليا', 'لعشاق النعومة، ويفر مقرمش محشو بكريمة الفانيليا الصافية.', 'images/1790598794_1000178057.jpg', '24 قطعة', 'جودة فاخرة', '2026-09-28 12:13:23'),
(8, 'ماو ويفر - شوكولاتة غنية', 'استمتع بتجربة ماو الفريدة، أصابع ويفر هشة ومقرمشة محشوة بكريمة الشوكولاتة الكثيفة التي تذوب في الفم لتعطيك طاقة وسعادة في كل وقت.', 'images/1790598333_1000178065.jpg', '24 قطعة', 'جودة فاخرة', '2026-09-28 12:13:23'),
(10, 'ماو ويفر - بندق', 'ويفر ماو محشو بالبندق', 'images/1790598625_1000178059.jpg', '24 قطعة', 'جوده فاخرة ', '2026-09-28 12:30:25'),
(11, 'ماو ويفر - فانيليا ', 'مذاق لايقاوم في كل قطمه', 'images/1790598753_1000178061.jpg', '24 قطعة', 'جوده فاخرة ', '2026-09-28 12:32:33');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `video` varchar(500) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `description`, `video`, `sort_order`, `created_at`) VALUES
(1, 'نكهة تشعل الحواس', 'تجربة قطميتوس الجديدة.. حيث تلتقي القرمشة بالفلفل المشتعل.', 'videos/vid1.mp4', 1, '2026-09-28 12:47:36'),
(2, 'أوقات السعادة مع قطمة', 'فشار قطمة الطبيعي.. الرفيق المثالي لجمعات العائلة والأصدقاء.', 'videos/vid2.mp4', 2, '2026-09-28 12:47:36'),
(3, 'إيفانو.. فخامة الويفر', 'دلل نفسك مع ويفر إيفانو المحشو بأغنى أنواع الكريمة.', 'videos/vid3.mp4', 3, '2026-09-28 12:47:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
