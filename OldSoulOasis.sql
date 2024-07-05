-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2024 at 02:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oldsouloasis`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`) VALUES
(8, 'Dire Straits: Making Movies', 21.11, '1. Tunnel of Love\\n\r\n2. Romeo and Juliet\\n\r\n3. Skateaway\\n\r\n4. Expresso Love\\n\r\n5. Hand in Hand\\n\r\n6. Solid Rock\\n\r\n7. Les Boys', 'images/making_movies.jpg'),
(18, 'Dire Straits: Alchemy - Dire Straits Live', 69.99, '1. Once Upon a Time in the West\\n2. Romeo and Juliet\\n3. Expresso Love\\n4. Private Investigations\\n5. Sultans of Swing\\n6. Two Young Lovers\\n7. Tunnel of Love \\n8. Telegraph Road\\n9. Solid Rock\\n10. Going Home – Theme from \'Local Hero\'', 'images/alchemy.jpg'),
(19, 'Dire Straits: Love Over Gold', 24.99, '1. Telegraph Road\\n2. Private Investigations\\n3. Industrial Disease\\n4. Love Over Gold\\n5. It Never Rains', 'images/love_over_gold.jpg'),
(20, 'Tom Petty and the Heartbreakers: Greatest Hits', 31.99, '1. American Girl\\n2. Breakdown\\n3. Anything That\'s Rock \'N\' Roll\\n4. Listen To Her Heart\\n5. I Need To Know\\n6. Refugee\\n7. Don\'t Do Me Like That\\n8. Even The Losers (Album Version)\\n9. Here Comes My Girl\\n10. The Waiting\\n11. You Got Lucky\\n12. Don\'t Come Around Here No More\\n13. I Won\'t Back Down\\n14. Runnin\' Down A Dream\\n15. Free Fallin\' - Petty, Tom\\n16. Learning To Fly\\n17. Into The Great Wide Open\\n18. Mary Jane\'s Last Dance (Greatest Hits Edited Version)\\n19. Something In The Air (1993 Greatest Hits Version)', 'images/tom_petty_greatest_hits.jpg'),
(22, 'Tom Petty: Full Moon Fever', 29.99, '1. Free Fallin\' (Album Version)\\n2. I Won\'t Back Down (Album Version)\\n3. Love Is A Long Road (Album Version)\\n4. A Face In The Crowd (Album Version)\\n5. Runnin\' Down A Dream (Album Version)\\n6. Feel A Whole Lot Better (Album Version)\\n7. Yer So Bad (Album Version)\\n8. Depending On You (Album Version)\\n9. The Apartment Song (Album Version)\\n10. Alright For Now (Album Version)\\n11. A Mind With A Heart Of Its Own (Album Version)\\n12. Zombie Zoo (Album Version)\\n', 'images/full_moon_fever.jpg'),
(23, 'Red Hot Chili Peppers: Stadium Arcadium', 65.79, '1. Dani California\\n2. Snow (Hey Oh)\\n3. Charlie\\n4. Stadium Arcadium\\n5. Hump de Bump\\n6. She\'s Only 18\\n7. Slow Cheetah\\n8. Torture Me\\n9. Strip My Mind\\n10. Especially in Michigan\\n11. Warlocks\\n12. C\'mon Girl\\n13. Wet Sand\\n14. Hey\\n15. Desecration Smile\\n16. Tell Me Baby\\n17. Hard to Concentrate\\n18. 21st Century\\n19. She Looks to Me\\n20. Readymade\\n21. If\\n22. Make You Feel Better\\n23. Animal Bar\\n24. So Much I\\n25. Storm in a Teacup\\n26. We Believe\\n27. Turn It Again\\n28. Death of a Martian', 'images/stadium_arcadium.jpg'),
(24, 'Red Hot Chili Peppers: Californication', 31.99, '1. Around the World\\n2. Parallel Universe\\n3. Scar Tissue\\n4. Otherside\\n5. Get on Top\\n6. Californication\\n7. Easily\\n8. Porcelain\\n9. Emit Remmus\\n10. I Like Dirt\\n11. This Velvet Glove\\n12. Savior\\n13. Purple Stain\\n14. Right on Time\\n15. Road Trippin\'\\n', 'images/californication.jpg'),
(25, 'Red Hot Chili Peppers: By the Way', 31.95, '1. By the Way\\n2. Universally Speaking\\n3. This Is the Place\\n4. Dosed\\n5. Don\'t Forget Me\\n6. The Zephyr Song\\n7. Can\'t Stop\\n8. I Could Die for You\\n9. Midnight\\n10. Throw Away Your Television\\n11. Cabron\\n12. Tear\\n13. On Mercury\\n14. Minor Thing\\n15. Warm Tape\\n16. Venice Queen\\n', 'images/by_the_way.jpg'),
(27, 'Nirvana: Nevermind', 26.97, '1. Smells Like Teen Spirit\\n2. In Bloom\\n3. Come As You Are\\n4. Breed\\n5. Lithium\\n6. Polly\\n7. Territorial Pissings\\n8. Drain You\\n9. Lounge Act\\n10. Stay Away\\n11. On a Plain\\n12. Something in the Way\\n', 'images/nevermind.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `products_archive`
--

CREATE TABLE `products_archive` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products_archive`
--

INSERT INTO `products_archive` (`id`, `name`, `price`, `description`, `image`) VALUES
(1, 'Apple', 1.99, 'A juicy red apple.', 'images/apple.jpg'),
(2, 'Banana', 10.00, 'A ripe yellow banana.', 'images/banana.jpg'),
(3, 'Tomato', 2.00, 'Fresh and organic tomatoes.', 'images/tomato.jpg'),
(5, 'Carrot', 5.00, 'Fresh carrots.', 'images/carrot.jpg'),
(6, 'Cucumber', 6.00, 'Organic cucumbers.', 'images/cucumber.jpg'),
(7, 'Cabbage', 6.00, 'Fresh cabbage.', 'images/cabbage.jpg'),
(8, 'Dire Straits: Making Movies', 21.11, '1. Tunnel of Love\\n\r\n2. Romeo and Juliet\\n\r\n3. Skateaway\\n\r\n4. Expresso Love\\n\r\n5. Hand in Hand\\n\r\n6. Solid Rock\\n\r\n7. Les Boys', 'images/making_movies.jpg'),
(10, '1', 1.00, '1', 'images/blank.jpg'),
(11, '2', 2.00, '2', 'images/blank.jpg'),
(12, '11', 11.00, '1.Test\r\n2.test\\n3,asddas', 'images/blank.jpg'),
(13, '123', 213.00, '123132', 'images/blank.jpg'),
(14, '1111', 1111.00, '1\r\n2\r\n3\r\n4', 'images/blank.jpg'),
(15, '222', 222.00, '2\r\n2\r\n2\r\n2', 'images/blank.jpg'),
(16, '11', 11.00, '11\\n12\\n32\\n32', 'images/blank.jpg'),
(17, 'Dire Straits: Love Over Gold', 24.99, 'Telegraph Road\\nPrivate Investigations\\nIndustrial Disease\\nLove Over Gold\\It Never Rains', 'images/love_over_gold.jpg'),
(18, 'Dire Straits: Alchemy - Dire Straits Live', 69.99, '1. Once Upon a Time in the West\\n2. Romeo and Juliet\\n3. Expresso Love\\n4. Private Investigations\\n5. Sultans of Swing\\n6. Two Young Lovers\\n7. Tunnel of Love \\n8. Telegraph Road\\n9. Solid Rock\\n10. Going Home – Theme from \'Local Hero\'', 'images/alchemy.jpg'),
(19, 'Dire Straits: Love Over Gold', 24.99, '1. Telegraph Road\\n2. Private Investigations\\n3. Industrial Disease\\n4. Love Over Gold\\n5. It Never Rains', 'images/love_over_gold.jpg'),
(20, 'Tom Petty and the Heartbreakers: Greatest Hits', 31.99, '1. American Girl\\n2. Breakdown\\n3. Anything That\'s Rock \'N\' Roll\\n4. Listen To Her Heart\\n5. I Need To Know\\n6. Refugee\\n7. Don\'t Do Me Like That\\n8. Even The Losers (Album Version)\\n9. Here Comes My Girl\\n10. The Waiting\\n11. You Got Lucky\\n12. Don\'t Come Around Here No More\\n13. I Won\'t Back Down - Petty, Tom\\n14. Runnin\' Down A Dream - Petty, Tom\\n15. Free Fallin\' - Petty, Tom\\n16. Learning To Fly\\n17. Into The Great Wide Open\\n18. Mary Jane\'s Last Dance (Greatest Hits Edited Version)\\n19. Something In The Air (1993 Greatest Hits Version)', 'images/tom_petty_greatest_hits.jpg'),
(21, 'Tom Petty - Full Moon Fever', 29.99, '1. Free Fallin\' (Album Version)\\n2. I Won\'t Back Down (Album Version)\\n3. Love Is A Long Road (Album Version)\\n4. A Face In The Crowd (Album Version)\\n5. Runnin\' Down A Dream (Album Version)\\n6. Feel A Whole Lot Better (Album Version)\\n7. Yer So Bad (Album Version)\\n8. Depending On You (Album Version)\\n9. The Apartment Song (Album Version)\\n10. Alright For Now (Album Version)\\n11. A Mind With A Heart Of Its Own (Album Version)\\n12. Zombie Zoo (Album Version)\\n', 'images/full_moon_fever.jpg'),
(22, 'Tom Petty: Full Moon Fever', 29.99, '1. Free Fallin\' (Album Version)\\n2. I Won\'t Back Down (Album Version)\\n3. Love Is A Long Road (Album Version)\\n4. A Face In The Crowd (Album Version)\\n5. Runnin\' Down A Dream (Album Version)\\n6. Feel A Whole Lot Better (Album Version)\\n7. Yer So Bad (Album Version)\\n8. Depending On You (Album Version)\\n9. The Apartment Song (Album Version)\\n10. Alright For Now (Album Version)\\n11. A Mind With A Heart Of Its Own (Album Version)\\n12. Zombie Zoo (Album Version)\\n', 'images/full_moon_fever.jpg'),
(23, 'Red Hot Chili Peppers: Stadium Arcadium', 65.79, '1. Dani California\\n2. Snow (Hey Oh)\\n3. Charlie\\n4. Stadium Arcadium\\n5. Hump de Bump\\n6. She\'s Only 18\\n7. Slow Cheetah\\n8. Torture Me\\n9. Strip My Mind\\n10. Especially in Michigan\\n11. Warlocks\\n12. C\'mon Girl\\n13. Wet Sand\\n14. Hey\\n15. Desecration Smile\\n16. Tell Me Baby\\n17. Hard to Concentrate\\n18. 21st Century\\n19. She Looks to Me\\n20. Readymade\\n21. If\\n22. Make You Feel Better\\n23. Animal Bar\\n24. So Much I\\n25. Storm in a Teacup\\n26. We Believe\\n27. Turn It Again\\n28. Death of a Martian', 'images/stadium_arcadium.jpg'),
(24, 'Red Hot Chili Peppers: Californication', 31.99, '1. Around the World\\n2. Parallel Universe\\n3. Scar Tissue\\n4. Otherside\\n5. Get on Top\\n6. Californication\\n7. Easily\\n8. Porcelain\\n9. Emit Remmus\\n10. I Like Dirt\\n11. This Velvet Glove\\n12. Savior\\n13. Purple Stain\\n14. Right on Time\\n15. Road Trippin\'\\n', 'images/californication.jpg'),
(25, 'Red Hot Chili Peppers: By the Way', 31.95, '1. By the Way\\n2. Universally Speaking\\n3. This Is the Place\\n4. Dosed\\n5. Don\'t Forget Me\\n6. The Zephyr Song\\n7. Can\'t Stop\\n8. I Could Die for You\\n9. Midnight\\n10. Throw Away Your Television\\n11. Cabron\\n12. Tear\\n13. On Mercury\\n14. Minor Thing\\n15. Warm Tape\\n16. Venice Queen\\n', 'images/by_the_way.jpg'),
(26, 'asddas', 121.00, 'asda', 'images/logo.png'),
(27, 'Nirvana: Nevermind', 26.97, '1. Smells Like Teen Spirit\\n2. In Bloom\\n3. Come As You Are\\n4. Breed\\n5. Lithium\\n6. Polly\\n7. Territorial Pissings\\n8. Drain You\\n9. Lounge Act\\n10. Stay Away\\n11. On a Plain\\n12. Something in the Way\\n', 'images/nevermind.jpg'),
(28, 'aaa', 2.00, 'aa', 'images/nevermind.jpg'),
(29, '11', 11.00, '11', 'images/making_movies.jpg'),
(30, '11', 11.00, '11', 'images/making_movies.jpg'),
(31, '11', 11.00, '11', 'images/making_movies.jpg'),
(32, '11', 11.00, '11', 'images/making_movies.jpg'),
(33, '11', 11.00, '11', 'images/making_movies.jpg'),
(34, '11', 11.00, '11', 'images/making_movies.jpg'),
(35, '11', 11.00, '11', 'images/making_movies.jpg'),
(36, '11', 11.00, '11', 'images/making_movies.jpg'),
(37, '11', 11.00, '11', 'images/making_movies.jpg'),
(38, '1', 1.00, '1', 'images/making_movies.jpg'),
(39, '1', 1.00, '1', 'images/love_over_gold.jpg'),
(40, '1', 1.00, '1', 'images/making_movies.jpg'),
(41, '1', 1.00, '1', 'images/making_movies.jpg'),
(42, '1', 1.00, '11', 'images/love_over_gold.jpg'),
(43, '1111', 1111.00, '1111', 'images/love_over_gold.jpg'),
(44, '123312', 123.00, '123', 'images/by_the_way.jpg'),
(45, '1233', 1233.00, '31231', 'images/alchemy.jpg'),
(46, '123312', 123312.00, '132', 'images/by_the_way.jpg'),
(47, '123', 123312.00, '123312', 'images/tom_petty_greatest_hits.jpg'),
(48, '132123', 123213.00, '123123', 'images/making_movies.jpg'),
(49, 'dasads', 2.00, 'ads', 'images/making_movies.jpg'),
(50, '123123', 123321.00, 'dasds\r\na\r\n', 'images/alchemy.jpg'),
(51, '123132', 123321.00, 'dasads', 'images/nevermind.jpg'),
(52, 'dasdas', 2.00, '1\\n2\\n3\\n4\\n', 'images/blank.jpg'),
(53, '12312', 31321.00, 'adsasd', 'images/blank.jpg'),
(54, '21331', 32123.00, '321321', 'images/blank.jpg'),
(55, '123', 213312.00, '123', 'images/blank.jpg'),
(56, '213231', 123.00, '123', 'images/blank.jpg'),
(57, 'test', 11.00, 'testtest\\ntesttest', 'images/making_movies.jpg'),
(58, 'testtesttest', 1234.00, 'testt\\nteste\\net\\nte\\nt\\neet', 'images/stadium_arcadium.jpg'),
(59, 'tesstt', 3.00, 'test', 'images/making_movies.jpg'),
(60, 'test', 3.00, 'test\\nt\\nt\\nt\\nt\\nt\\nts\\ns', 'images/alchemy.jpg'),
(61, 'tet', 1312.00, 'teasdda', 'images/alchemy.jpg'),
(62, 'asd', 1.00, 'asd', 'images/making_movies.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`transaction_id`, `user_id`, `product_id`, `quantity`, `transaction_date`) VALUES
(1, 16, 1, 1, '2024-07-01 19:34:02'),
(1, 16, 2, 14, '2024-07-01 19:34:02'),
(2, 16, 1, 2, '2024-07-01 19:34:30'),
(3, 16, 1, 2, '2024-07-01 19:34:46'),
(4, 16, 1, 2, '2024-07-01 19:55:07'),
(4, 16, 2, 1, '2024-07-01 19:55:07'),
(5, 16, 1, 2, '2024-07-01 20:43:59'),
(5, 16, 2, 9, '2024-07-01 20:43:59'),
(6, 16, 1, 4, '2024-07-01 21:25:26'),
(7, 16, 1, 3, '2024-07-01 21:39:26'),
(7, 16, 2, 1, '2024-07-01 21:39:26'),
(8, 19, 1, 8, '2024-07-01 22:30:34'),
(9, 19, 2, 1, '2024-07-01 22:31:04'),
(9, 19, 1, 1, '2024-07-01 22:31:04'),
(10, 16, 1, 8, '2024-07-01 23:14:32'),
(11, 16, 1, 8, '2024-07-01 23:14:33'),
(12, 16, 1, 2, '2024-07-01 23:35:52'),
(12, 16, 2, 2, '2024-07-01 23:35:52'),
(13, 16, 1, 2, '2024-07-01 23:35:54'),
(13, 16, 2, 2, '2024-07-01 23:35:54'),
(14, 24, 2, 5, '2024-07-02 00:26:31'),
(15, 24, 2, 2, '2024-07-02 00:30:45'),
(15, 24, 1, 1, '2024-07-02 00:30:45'),
(16, 24, 7, 1, '2024-07-02 00:35:31'),
(16, 24, 1, 1, '2024-07-02 00:35:31'),
(17, 24, 1, 1, '2024-07-02 00:38:05'),
(18, 24, 1, 1, '2024-07-02 00:39:08'),
(19, 24, 1, 6, '2024-07-02 00:41:53'),
(20, 24, 1, 1, '2024-07-02 00:43:39'),
(21, 24, 1, 1, '2024-07-02 00:43:49'),
(22, 16, 1, 7, '2024-07-02 00:49:52'),
(22, 16, 2, 4, '2024-07-02 00:49:52'),
(23, 16, 1, 1, '2024-07-02 00:51:38'),
(24, 16, 1, 1, '2024-07-02 01:06:35'),
(25, 16, 1, 1, '2024-07-02 01:07:13'),
(26, 16, 1, 1, '2024-07-02 01:07:30'),
(27, 16, 1, 1, '2024-07-02 01:08:39'),
(28, 16, 1, 1, '2024-07-02 01:08:52'),
(29, 16, 1, 1, '2024-07-02 01:09:05'),
(30, 16, 1, 1, '2024-07-02 01:10:01'),
(31, 16, 1, 1, '2024-07-02 01:10:32'),
(32, 16, 2, 1, '2024-07-02 01:11:50'),
(33, 16, 2, 1, '2024-07-02 01:11:59'),
(34, 16, 1, 1, '2024-07-02 13:59:54'),
(35, 16, 1, 1, '2024-07-02 14:00:11'),
(36, 16, 1, 1, '2024-07-02 14:26:43'),
(37, 16, 1, 1, '2024-07-02 14:32:00'),
(38, 16, 1, 1, '2024-07-02 14:34:16'),
(39, 16, 1, 1, '2024-07-02 14:38:07'),
(40, 16, 1, 1, '2024-07-02 14:42:31'),
(41, 16, 1, 1, '2024-07-02 14:43:02'),
(42, 16, 1, 1, '2024-07-02 14:47:35'),
(43, 16, 1, 1, '2024-07-02 14:49:06'),
(44, 16, 1, 1, '2024-07-02 14:49:57'),
(45, 16, 1, 1, '2024-07-02 14:51:14'),
(46, 16, 1, 1, '2024-07-02 14:51:23'),
(47, 16, 1, 1, '2024-07-02 14:51:57'),
(48, 16, 8, 1, '2024-07-02 14:52:57'),
(49, 16, 18, 2, '2024-07-02 17:03:46'),
(49, 16, 8, 4, '2024-07-02 17:03:46'),
(50, 16, 8, 1, '2024-07-02 17:29:47'),
(51, 16, 8, 1, '2024-07-02 17:30:10'),
(52, 16, 8, 1, '2024-07-02 17:31:19'),
(53, 16, 8, 1, '2024-07-02 17:31:30'),
(54, 16, 8, 1, '2024-07-02 17:31:57'),
(55, 16, 8, 1, '2024-07-02 17:32:29'),
(56, 16, 8, 1, '2024-07-02 17:44:13'),
(57, 16, 8, 1, '2024-07-02 17:44:23'),
(58, 16, 8, 9, '2024-07-02 17:49:55'),
(59, 16, 8, 1, '2024-07-02 17:51:32'),
(60, 16, 8, 1, '2024-07-02 17:52:07'),
(61, 16, 8, 1, '2024-07-02 17:52:57'),
(62, 16, 8, 1, '2024-07-02 17:53:21'),
(63, 16, 8, 1, '2024-07-02 17:53:35'),
(64, 16, 8, 1, '2024-07-02 17:55:18'),
(65, 16, 8, 2, '2024-07-02 17:55:52'),
(66, 16, 8, 1, '2024-07-02 17:57:24'),
(67, 16, 8, 2, '2024-07-02 18:34:31'),
(67, 16, 18, 2, '2024-07-02 18:34:31'),
(68, 16, 8, 1, '2024-07-02 18:39:18'),
(69, 16, 8, 1, '2024-07-02 18:41:05'),
(70, 16, 8, 1, '2024-07-02 18:41:35'),
(71, 16, 19, 2, '2024-07-02 18:48:35'),
(71, 16, 23, 2, '2024-07-02 18:48:35'),
(72, 29, 8, 4, '2024-07-02 18:52:35'),
(73, 16, 8, 4, '2024-07-02 18:53:31'),
(74, 16, 8, 1, '2024-07-02 18:57:50'),
(75, 16, 23, 1, '2024-07-02 19:16:33'),
(76, 16, 18, 1, '2024-07-02 21:36:20'),
(76, 16, 27, 1, '2024-07-02 21:36:20'),
(77, 16, 8, 1, '2024-07-02 22:17:54'),
(78, 16, 8, 1, '2024-07-02 22:20:40'),
(79, 16, 8, 1, '2024-07-02 22:27:17'),
(80, 16, 8, 1, '2024-07-02 23:01:21'),
(81, 16, 8, 1, '2024-07-02 23:04:38'),
(82, 16, 8, 1, '2024-07-02 23:17:41'),
(83, 16, 8, 5, '2024-07-02 23:24:22'),
(83, 16, 18, 1, '2024-07-02 23:24:22'),
(84, 16, 8, 2, '2024-07-05 00:17:59'),
(84, 16, 20, 2, '2024-07-05 00:17:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `wallet` decimal(10,2) DEFAULT 100.00,
  `admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `wallet`, `admin`) VALUES
(16, 'kokoska1@gmail.com', '$2y$10$.7AxouLRjRfHy2DZ8H.9BOZATFRZale5pxy7B1D0IupxS0oiy3NxK', 97594.57, 0),
(19, 'patrikkk@gmaul.com', '$2y$10$ewX9EKOCS4GkPOwif1omPu1ICZfdomN3pZkvtWsjhBfAcL4eooz.u', 72.09, 0),
(20, 'kodsaasdkoska1@gmail.com', '$2y$10$1UGBucCMdztnsvbmptvMQun/A3CHoXwGfVvQGlSPeetMbnFgDpRnW', 100.00, 0),
(21, 'dasasadsdas@dasads.adsda', '$2y$10$1vfKQ71R393CdhJe2urJku1RasOXXq8gFXBorc85L7WYPPanIiTqa', 100.00, 0),
(22, 'adsasdads@gmai.com', '$2y$10$hsXKzi286RyYFR3kA3mQ1OVpNC2NxmZYbCjp0sdv1jtpCHePuM3di', 100.00, 0),
(23, '132132@asdads.ads', '$2y$10$.vlJdt.IQWqCjm4KDmvp2eK/f3FImE.1SkiNM6d815P5foQrGXIJi', 100.00, 0),
(24, 'adsadsads@gmail.com', '$2y$10$5F/38234gv2xmYS1AuTX6ePgTqjjPjMltfXRflNub83eY8k/8BBnu', 0.12, 0),
(25, '123312213@gmail.com', '$2y$10$2SusY5/FPDlYuIoNR2U6HOeD46phiSrA4pqW.ockj0wBlGx4Gg.ou', 100.00, 0),
(26, 'admin123@admin.com', '$2y$10$x1j5AmQpxDSZNYIscHrfj./LlEn68mCtI8..Mi7MjgSabLaHC99..', 100.00, 1),
(27, 'adsdaasdas@gmail.co', '$2y$10$DV/pyHPqW6Fy.O1wkxlmmesAS3/uEByxYwmUN027ayjtvfl2BGipS', 100.00, 0),
(28, '1323212@gmail.com', '$2y$10$/0ZFtaazInQzalTeJqxGGe0qT.A9xq7sCa4lASXbUC9fmDImuGJDy', 100.00, 0),
(29, 'kokoska13@gmail.com', '$2y$10$xpaB3MgdQkff2C..jEcZsuJGsL/II1GG.0i0KqML5a4izv78KhHru', 15.56, 0),
(30, 'lekokoskajames@gmail.com', '$2y$10$35DHjhNvEw/Nyu77C21AV.OQEC/bOWr0U8p8D2McTZjlM9.qb2jSq', 100.00, 0),
(31, 'adsdasdas@asddas.das', '$2y$10$Hoaw/fzQ30Y98RZx4Q4zDe4YnEqnG46xHsDqG0RS/LM.lrBaVZ7C.', 100.00, 0),
(32, 'testtesttest@test.test', '$2y$10$zehYCSwcHTaQuSUriNJRjerzIG9vE0fJOyWaG0g9pAiL3NND2xSqS', 100.00, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD CONSTRAINT `transaction_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
