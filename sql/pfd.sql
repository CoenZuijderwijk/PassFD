-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 18 jan 2020 om 17:31
-- Serverversie: 10.4.6-MariaDB
-- PHP-versie: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pfd`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `clothing_piece`
--

CREATE TABLE `clothing_piece` (
  `id` int(11) NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `style` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `clothing_piece`
--

INSERT INTO `clothing_piece` (`id`, `size`, `color`, `style`, `image_file_name`, `name`, `user_id`) VALUES
(1, 'te groot', 'geel', 'goed', 'testcoen-5e231e30b29ad-png', 'test', 2),
(2, 'te groot', 'geel', 'goed', 'test 2coen-5e2321e09379c-png', 'test 2', 2),
(3, 'test4', 'test3', 'test3', '-test3-coen-5e232d010d702-png', 'test3', 2),
(4, 'shirt', 'shirt', 'shit', '-shirt-coen-5e232fff48192-png', 'shirt', 2),
(5, 'pants', 'pants', 'pants', '-pants-coen-5e233179481b2-jpeg', 'pants', 2),
(6, 'broek', 'broek', 'broek', '-broek-coen-5e2331d01efa4-png', 'broek', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200118122759', '2020-01-18 12:28:15'),
('20200118125145', '2020-01-18 12:51:54'),
('20200118130124', '2020-01-18 13:01:32'),
('20200118130913', '2020-01-18 13:09:21'),
('20200118134324', '2020-01-18 13:43:30'),
('20200118141242', '2020-01-18 14:19:45'),
('20200118155038', '2020-01-18 15:50:48');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `face_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `username`, `roles`, `face_image`) VALUES
(1, 'Coen', 'Zuijderwijk', 'coenschoolhgl@gmail.com', 'abc', '', '', NULL),
(2, 'coen', 'zuijderwijk', 'katlok@outlook.com', '$argon2id$v=19$m=65536,t=4,p=1$M0hlSVZSS0J1RjlEOXQ1MQ$rBcFEXaKOe2c1feB2DJiE7EuocTlXJA2I9AXhAk5zGM', 'coen', '[\"ROLE_ADMIN\"]', 'face-coen-5e232d2c71006-png'),
(3, 'abc', 'abc', 'ABC@ABC.ABC', '$argon2id$v=19$m=65536,t=4,p=1$bzdWOUZhU21kSExqTnlSMA$EZ3SqZ6nBqQ/l6jDbfBAxjGsRbcZ781BA5Ue10z86zU', 'abc', '[]', NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `clothing_piece`
--
ALTER TABLE `clothing_piece`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_67C3971DA76ED395` (`user_id`);

--
-- Indexen voor tabel `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `clothing_piece`
--
ALTER TABLE `clothing_piece`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `clothing_piece`
--
ALTER TABLE `clothing_piece`
  ADD CONSTRAINT `FK_67C3971DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
