-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 19 avr. 2024 à 09:07
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tifosi`
--

-- --------------------------------------------------------

--
-- Structure de la table `focaccia_ingredient`
--

CREATE TABLE `focaccia_ingredient` (
  `id_focaccia` int(11) NOT NULL,
  `id_ingredient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `focaccia_ingredient`
--

INSERT INTO `focaccia_ingredient` (`id_focaccia`, `id_ingredient`) VALUES
(1, 1),
(1, 3),
(1, 5),
(1, 7),
(1, 9),
(1, 13),
(1, 14),
(1, 17),
(1, 19),
(1, 21),
(2, 1),
(2, 5),
(2, 7),
(2, 9),
(2, 11),
(2, 17),
(2, 19),
(2, 21),
(3, 1),
(3, 5),
(3, 7),
(3, 9),
(3, 19),
(3, 21),
(3, 23),
(4, 6),
(4, 7),
(4, 9),
(4, 10),
(4, 16),
(4, 19),
(4, 21),
(5, 5),
(5, 7),
(5, 9),
(5, 12),
(5, 14),
(5, 17),
(5, 18),
(5, 19),
(5, 21),
(6, 2),
(6, 4),
(6, 5),
(6, 9),
(6, 14),
(6, 17),
(6, 19),
(6, 20),
(6, 21),
(7, 4),
(7, 5),
(7, 9),
(7, 14),
(7, 17),
(7, 19),
(7, 21),
(7, 22),
(8, 1),
(8, 3),
(8, 6),
(8, 7),
(8, 8),
(8, 9),
(8, 13),
(8, 15),
(8, 17),
(8, 19),
(8, 21),
(8, 22);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `focaccia_ingredient`
--
ALTER TABLE `focaccia_ingredient`
  ADD PRIMARY KEY (`id_focaccia`,`id_ingredient`),
  ADD KEY `fk_ingredient` (`id_ingredient`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `focaccia_ingredient`
--
ALTER TABLE `focaccia_ingredient`
  ADD CONSTRAINT `fk_focaccia` FOREIGN KEY (`id_focaccia`) REFERENCES `focaccia` (`id_focaccia`),
  ADD CONSTRAINT `fk_ingredient` FOREIGN KEY (`id_ingredient`) REFERENCES `ingredient` (`id_ingredient`),
  ADD CONSTRAINT `focaccia_ingredient_ibfk_1` FOREIGN KEY (`id_focaccia`) REFERENCES `focaccia` (`id_focaccia`),
  ADD CONSTRAINT `focaccia_ingredient_ibfk_2` FOREIGN KEY (`id_ingredient`) REFERENCES `ingredient` (`id_ingredient`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
