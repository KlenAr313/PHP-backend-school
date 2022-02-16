SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `PHPbooks` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `PHPbooks`;

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
(1, 'Mark', 'Dow', 'mark@email.com', '$2y$10$GTEzyHn7FY3UtKfCQnGR5OUbzQnsQajmZW3PS76bVdcC7OH7MOuc2', '2022-02-16 12:10:00', '2022-02-16 12:20:28');

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
  `died` varchar(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `writers`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `writers` (`id`, `firstName`, `lastName`, `bornIn`, `bornAt`, `died`) VALUES
(1, 'James S. A.', 'Corey' , 'USA', 1992, NULL);

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
  ADD FOREIGN KEY (`writerId`) REFERENCES writers(id);

INSERT INTO `books` (`id`, `title`, `category`, `publiched`, `writerId`) VALUES
(1, 'Leviathan wakes', 'sci-fi', 2011, 1),
(2, 'Caliban s War', 'sci-fi', 2012, 1);
