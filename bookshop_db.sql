-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2025 at 02:55 PM
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
-- Database: `bookshop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `ISBN` varchar(13) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `genre`, `ISBN`, `price`, `stock_quantity`, `cover_image`) VALUES
(1, 'Calculus - Early Transcendentals (10th Edition)', 'Irl Bivens, Stephen F. Davis, Howard Anton', 'Mathematics Textbook', '978-047064769', 700.00, 3, 'Calculus.jpg'),
(2, 'Introduction to Algorithms', 'Thomas H. Cormen, Charles E. Leiserson, Ronald L. Rivest, Clifford Stein', 'Textbook', '978-026203384', 85.00, 25, 'introduction_to_algorithms.jpg'),
(3, 'The Elements of Style', 'William Strunk Jr., E.B. White', 'Textbook', '978-020530902', 10.95, 150, 'the_elements_of_style.jpg'),
(4, 'Calculus: Early Transcendentals', 'James Stewart', 'Textbook', '978-128574155', 125.50, 30, 'calculus.jpg'),
(5, 'Organic Chemistry', 'Paula Yurkanis Bruice', 'Textbook', '978-032180322', 99.99, 40, 'organic_chemistry.jpg'),
(6, 'Principles of Economics', 'N. Gregory Mankiw', 'Textbook', '978-130558512', 78.25, 55, 'principles_of_economics.jpg'),
(7, 'Moby Dick', 'Herman Melville', 'Classic', '978-014243724', 14.99, 80, 'moby_dick.jpg'),
(8, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Classic', '978-074327356', 11.50, 90, 'the_great_gatsby.jpg'),
(9, 'War and Peace', 'Leo Tolstoy', 'Classic', '978-140007998', 22.00, 35, 'war_and_peace.jpg'),
(10, 'Crime and Punishment', 'Fyodor Dostoevsky', 'Classic', '978-048641587', 9.95, 70, 'crime_and_punishment.jpg'),
(11, 'The Odyssey', 'Homer', 'Classic', '978-014026886', 13.75, 110, 'the_odyssey.jpg'),
(12, 'Dune', 'Frank Herbert', 'Fiction', '978-044117271', 15.99, 120, 'dune.jpg'),
(13, 'The Martian', 'Andy Weir', 'Fiction', '978-055341802', 14.25, 95, '0881218_the-martian-paperback-import-book.jpeg'),
(14, 'Ready Player One', 'Ernest Cline', 'Fiction', '978-030788744', 13.50, 88, 'ready_player_one.jpg'),
(15, 'Project Hail Mary', 'Andy Weir', 'Fiction', '978-059313520', 16.75, 105, 'project_hail_mary.jpg'),
(16, 'The Alchemist', 'Paulo Coelho', 'Fiction', '978-006112241', 10.50, 128, 'the_alchemist.jpg'),
(17, 'The Lord of the Rings', 'J.R.R. Tolkien', 'Novel', '978-061851765', 25.00, 65, 'the_lord_of_the_rings.jpg'),
(18, 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', 'Novel', '978-059035342', 18.99, 200, 'harry_potter_and_the_sorcerers_stone.jpg'),
(19, 'A Game of Thrones', 'George R.R. Martin', 'Novel', '978-055359371', 17.50, 75, 'a_game_of_thrones.jpg'),
(20, 'The Chronicles of Narnia', 'C.S. Lewis', 'Novel', '978-006447119', 20.00, 90, 'the_chronicles_of_narnia.jpg'),
(21, 'The Hitchhiker\'s Guide to the Galaxy', 'Douglas Adams', 'Novel', '978-034539180', 12.00, 115, '13.jpg'),
(22, 'Death of a Salesman', 'Arthur Miller', 'Drama', '978-014242637', 10.99, 60, 'images.jpg'),
(23, 'Hamlet', 'William Shakespeare', 'Drama', '978-074347712', 8.50, 100, 'hamlet.jpg'),
(24, 'A Streetcar Named Desire', 'Tennessee Williams', 'Drama', '978-081121601', 11.25, 50, 'A_Streetcar_Named_Desire.jpg'),
(25, 'Waiting for Godot', 'Samuel Beckett', 'Drama', '978-080214442', 9.75, 45, 'waiting_godot.jpg'),
(26, 'The Importance of Being Earnest', 'Oscar Wilde', 'Drama', '978-048626478', 7.50, 70, '9781784871529.jpg'),
(27, 'The Girl with the Dragon Tattoo', 'Stieg Larsson', 'Thriller', '978-030796030', 14.00, 85, 'dragon_tattoo.jpg'),
(28, 'Gone Girl', 'Gillian Flynn', 'Thriller', '978-030758837', 13.00, 95, 'Gone_Girl-Gillian_Flynn-2fbe1-336602.jpg'),
(29, 'The Silent Patient', 'Alex Michaelides', 'Thriller', '978-125030169', 15.50, 110, '9781409181651.jpg'),
(30, 'The Da Vinci Code', 'Dan Brown', 'Thriller', '978-030747427', 12.99, 100, 'images (2).jpg'),
(31, 'The Prizoner of Azkaban', 'J.K. Rowling', 'Thriller', '978-043965542', 16.00, 125, '5.jpg'),
(32, 'The Nightingale', 'Kristin Hannah', 'Historical Fiction', '978-125005619', 14.50, 80, 'the_nightingale.jpg'),
(33, 'Where the Crawdads Sing', 'Delia Owens', 'Mystery', '978-073521909', 15.00, 150, '36809135.jpg'),
(34, 'The Midnight Library', 'Matt Haig', 'Fantasy', '978-052555947', 13.99, 130, '9780525559498.jpg'),
(35, 'Educated', 'Tara Westover', 'Memoir', '978-039959050', 16.99, 90, 'educated.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','shipped','delivered') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `status`) VALUES
(1, 8, '2025-08-16 12:52:59', 'delivered'),
(2, 8, '2025-08-22 21:12:29', 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `book_id`, `quantity`, `price`) VALUES
(1, 1, 1, 2, 700.00),
(2, 2, 16, 2, 10.50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('customer','admin') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `user_type`) VALUES
(1, 'Zawed', 'zawedrohan@yahoo.com', '$2y$10$xsJfmUatPyMGW1XCtfzhDOWR2LTN83AuD/Cjbp9tzVKem/rlPcQDa', 'customer'),
(7, 'admin', 'admin@yahoo.com', '$2y$10$mKhSx5TiroP51IjENzLJWOc2To3NMSTUOIflM1H419B8ciorLSV26', 'admin'),
(8, 'User', 'user@yahoo.com', '$2y$10$tWVQGaJZrnHfVcXRPhGeKukmMNMN4ftiT7ybTn7FpjaCykfi73WzC', 'customer'),
(9, 'user2', 'user2@yahoo.com', '$2y$10$PSmFgCy/IsxezjUrGviuKepfqrWGlEvVX8sgoVWZ05CX3x8pHLNp2', 'customer'),
(10, 'admin2', 'admin2@yahoo.com', '$2y$10$s15hRh215g8B0g1BVYZchuYmn0ucmp47riiyGCQqj/NtWyuysCk8W', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `ISBN` (`ISBN`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

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
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
