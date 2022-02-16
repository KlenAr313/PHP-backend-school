SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `books` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `books`;

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
(5, 'Mark', 'Dow', 'mark@email.com', '$2y$10$GTEzyHn7FY3UtKfCQnGR5OUbzQnsQajmZW3PS76bVdcC7OH7MOuc2', '2022-02-04 12:00:28', '2022-02-04 12:00:28');

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_Email` (`email`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

