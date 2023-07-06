-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 06 juil. 2023 à 19:16
-- Version du serveur : 5.7.33
-- Version de PHP : 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vfpm`
--

-- --------------------------------------------------------

--
-- Structure de la table `fleet`
--

CREATE TABLE `fleet` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `r_fleet_vehicle`
--

CREATE TABLE `r_fleet_vehicle` (
  `fleet_id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plate_number` char(9) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `fleet`
--
ALTER TABLE `fleet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Index pour la table `r_fleet_vehicle`
--
ALTER TABLE `r_fleet_vehicle`
  ADD PRIMARY KEY (`fleet_id`,`vehicle_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Index pour la table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plate-number` (`plate_number`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `r_fleet_vehicle`
--
ALTER TABLE `r_fleet_vehicle`
  ADD CONSTRAINT `r_fleet_vehicle_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `r_fleet_vehicle_ibfk_2` FOREIGN KEY (`fleet_id`) REFERENCES `fleet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
