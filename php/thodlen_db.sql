-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Aug 21, 2024 at 09:21 AM
-- Server version: 8.4.0
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thodlen_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `item_id` int NOT NULL,
  `product_id` int NOT NULL,
  `amount` int NOT NULL DEFAULT '1',
  `user_id` int NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`item_id`, `product_id`, `amount`, `user_id`, `create_at`) VALUES
(1, 1, 1, 4, '2024-08-19 07:10:51');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `oders_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `status` enum('waiting','delivering','canceled','successfully') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `oders_json`, `user_id`, `status`, `create_at`) VALUES
(1, '{\"totalPrice\":\"14\",\"user_id\":3,\"carts\":[{\"item_id\":2,\"product_id\":2,\"amount\":2,\"user_id\":3,\"create_at\":\"2024-08-19 00:19:22\"}]}', 3, 'canceled', '2024-08-19 07:19:42'),
(2, '{\"totalPrice\":\"70\",\"user_id\":2,\"carts\":[{\"item_id\":3,\"product_id\":1,\"amount\":10,\"user_id\":2,\"create_at\":\"2024-08-20 22:07:59\"}]}', 2, 'canceled', '2024-08-21 05:08:12'),
(3, '{\"totalPrice\":\"70\",\"user_id\":2,\"carts\":[]}', 2, 'canceled', '2024-08-21 05:08:12');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `detail`, `price`, `product_image`, `create_at`) VALUES
(1, 'หมูทอดทอดเล่น', 'หมูทอดสูตรของทางร้าน ไม้ละ 7 บาท 3 ไม้ 20 บาท', 7, '66c2f081ae637.webp', '2024-08-19 07:09:44'),
(2, 'ไก่ทอดทอดเล่น', 'ไก่ทอดชุบแป้งสูตรของางร้าน ราคา ไม้ละ 7 บาท 3 ไม้ 20 บาท', 7, '66c2f126e8b1c.webp', '2024-08-19 07:15:51'),
(3, 'ปลาเส้นแท้มหาชัย', 'ปลาเส้นแท้ แป้งน้อย อร่อยมาก ต้องลอง* เส้นละ 25 บาท', 25, '66c2f154c2642.webp', '2024-08-19 07:16:37'),
(4, 'ปลาเส้นมหาชัย ยกแพค', 'ยกแพคถูกลง 5 บาท', 120, '66c2f1b42a1aa.jfif', '2024-08-19 07:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `firstname` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `tel`, `email`, `password`, `profile_image`, `address`, `role`, `created_at`) VALUES
(1, 'admin', 'admin', '0', 'admin@admin.com', '$2y$10$Tf.lkloVTFd7VMXP0.Ll1.GmkEvTXkH9/MuUtHnf60ZZKi7.NnALK', 'default-profile.jpg', 'admin', 'admin', '2024-07-31 09:44:12'),
(2, 'okekung', 'naja', '0988919682', 'okenathaoke@gmail.com', '$2y$10$CceOo.0sl68yBudvThnVk.wqgtvVzugUJxW44lhzJB3HibqsB3qXu', 'default-profile.jpg', '152/3 ม.3 ต.ท่างิ้ว จ.นครสวรรค์ 60180', 'user', '2024-08-19 07:07:14'),
(3, 'Ooy', 'Ly', '0660401345', 'chaimongkhol2046@gmail.com', '$2y$10$r/4W532h91i8VMn9CX1id.JaK5PibUlvcdmbGv7sJo3ckJg7JwHrW', 'default-profile.jpg', '8/2 หมู่ 10 ต.ด่านช้าง อ.บรรพตพิสัย จ.นครสวรรค์', 'user', '2024-08-19 07:07:38'),
(4, 'นางสาวกนกพร', 'แป้นต่วน', '0613351125', 'kankporn7547@gmail.com', '$2y$10$ZNKGvuu0uGpJhjrCYJpHbOq2McA.smwBBq2d7Wppy0Q4ksyzcqiBG', 'default-profile.jpg', '8/2 หมู่ 10 ต.ด่านช้าง อ.บรรพตพิสัย จ.นครสวรรค์', 'user', '2024-08-19 07:09:37'),
(5, 'ชวนากร', 'พันธุระ', '0824620173', 'bigbabao04@gmail.com', '$2y$10$MWduFsFnIDECk8eCGuQuxO7UBAkltwPkEIN.n1.WBi5D1/uWIW5U.', 'default-profile.jpg', 'คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี', 'user', '2024-08-19 07:10:57'),
(12, 'ฉัตรณรงค์', 'จินตอภิญญา', '0917418586', 'chatnarong0224@gmail.com', '$2y$10$IrmpobojgRcBKmfdyyg1LeayQAlMCrj.uFM8bLdwCV9pg.Dljtd0i', '66c2ffce52f49.jpeg', '39/5 ม.4 ต.ต้นโพธิ์ อ.เมือง จ.สิงห์บุรี', 'user', '2024-08-19 08:18:22'),
(13, 'เลิฟยู', 'จุ๊บๆๆ', '0961401292', '', '$2y$10$r.KcpzVS4k1aww/jAvKR2elPCCuZMkAJiudbm2xB9wYWLa9dfRHP.', 'default-profile.jpg', '110/1 ม.6', 'user', '2024-08-19 08:21:37'),
(14, 'ธนาเทพ', 'พรมโรง', '0841088070', 'uuuu7065@gmail.com', '$2y$10$WG5DshSncV3v3qnfSFaAmO2wE9VM0SasTHkRRfSf9Y0EqJMUgo5Ye', 'default-profile.jpg', '95/7 หมู่.1', 'user', '2024-08-19 08:37:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `users` (`user_id`),
  ADD KEY `product` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
