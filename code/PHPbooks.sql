SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `phpbooks` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `phpbooks`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifiedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `createdAt`, `modifiedAt`) VALUES
(1, 'Luke', 'Skywalker', 'luke@email.com', '$2y$10$GTEzyHn7FY3UtKfCQnGR5OUbzQnsQajmZW3PS76bVdcC7OH7MOuc2', '2022-02-16 12:10:00', '2022-02-16 12:20:28');

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_Email` (`email`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE `writers` (
  `id` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `bornIn` varchar(100) NOT NULL,
  `bornAt` int(11) NOT NULL,
  `died` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `writers`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `writers` (`id`, `firstName`, `lastName`, `bornIn`, `bornAt`, `died`) VALUES
(1, 'James S. A.', 'Corey' , 'USA', 1992, NULL),
(2, 'Timothy', 'Zahn' , 'USA', 1951, NULL),
(3, 'J. R.', 'Tolkien' , 'South Africa', 1892, 1973),
(4, 'MR.', 'Nobody' , 'UnKnown', 1112, 2221);

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `publiched` int(11) NOT NULL,
  `writerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1,
  ADD UNIQUE KEY `IDX_Title` (`title`),
  ADD FOREIGN KEY (`writerId`) REFERENCES writers(id) ON DELETE CASCADE;

INSERT INTO `books` (`id`, `title`, `category`, `publiched`, `writerId`) VALUES
(1, 'Leviathan wakes', 'sci-fi', 2011, 1),
(2, 'Caliban s War', 'sci-fi', 2012, 1),
(3, 'Star Wars: Heir to the Empire', 'fantasy', 1991, 2),
(4, 'Star Wars: Dark Force Rising', 'fantasy', 1992, 2),
(5, 'Star Wars: The Last Command', 'fantasy', 1993, 2),
(6, 'StarCraft: Evolution', 'sci-fi', 2016, 2),
(7, 'Lord of the Rings', 'fantasy', 1954, 3),
(8, 'Lord of the Rings: The Two Towers', 'fantasy', 1954, 3),
(9, 'Lord of the Rings: The Return of the King', 'fantasy', 1955, 3);
