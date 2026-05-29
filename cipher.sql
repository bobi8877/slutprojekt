-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 29 maj 2026 kl 22:29
-- Serverversion: 10.4.32-MariaDB
-- PHP-version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `cipher`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_solved`
--

CREATE TABLE `tbl_solved` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cipher_name` varchar(100) NOT NULL,
  `solved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `tbl_solved`
--

INSERT INTO `tbl_solved` (`id`, `user_id`, `cipher_name`, `solved_at`) VALUES
(2, 2, 'significationes_occultae', '2026-05-08 08:09:20');

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userlevel` int(11) NOT NULL DEFAULT 10,
  `lastlogin` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `mail` varchar(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `points` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `userlevel`, `lastlogin`, `mail`, `created`, `points`) VALUES
(2, 'test', 'e99a18c428cb38d5f260853678922e03', 100, '2026-05-29 08:00:42', 'test@test', '2026-04-17 10:12:16', 823),
(3, 'DreamyBullXXX', '28748e2e98218b556893a80391855c66', 10, '2026-05-29 08:07:53', 'dreamy@mail.com', '2026-04-17 13:01:50', 10),
(4, 'Ambatubas', '0adc287d4385b4bd303684ea2cfe8bca', 10, '2026-04-20 10:54:00', 'amba@s.ok', '2026-04-20 10:54:00', 0),
(5, 'dsadsa', 'b285fdfb3de73d16dee73731945dcf69', 10, '2026-04-28 11:51:21', 'dadsa@dasdsa', '2026-04-28 11:51:21', 0),
(10, 'kljhgfds', 'd20fe5c7f3e27fa2e6c1260d5fa2cc2f', 10, '2026-04-28 11:53:33', 'mnbvfdsa@kjhgfds', '2026-04-28 11:53:33', 0),
(11, 'kljhgfds', '5912b2cb8319e1026b9da48e96bcd2d3', 10, '2026-04-28 11:53:41', 'kjhgfdsa@kjhgfds', '2026-04-28 11:53:41', 0),
(15, 'test2', '25d55ad283aa400af464c76d713c07ad', 10, '2026-05-12 10:51:30', 'tesgt@ddsa', '2026-05-12 10:51:30', 0);

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `tbl_solved`
--
ALTER TABLE `tbl_solved`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_solve` (`user_id`,`cipher_name`);

--
-- Index för tabell `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `tbl_solved`
--
ALTER TABLE `tbl_solved`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
