-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 13 jan. 2018 à 14:41
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `miniprojet`
--

-- --------------------------------------------------------

--
-- Structure de la table `boutique`
--

DROP TABLE IF EXISTS `boutique`;
CREATE TABLE IF NOT EXISTS `boutique` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `nom_item` varchar(50) NOT NULL,
  `description_item` text NOT NULL,
  `stock` int(11) NOT NULL,
  `prix_unitaire` float NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `boutique`
--

INSERT INTO `boutique` (`id_item`, `nom_item`, `description_item`, `stock`, `prix_unitaire`) VALUES
(1, 'Le Grand Dictionnaire', 'Le grand dictionnaire du chaucyrio signé par le Grand Klap ! De sa célèbre main-moignon ! Oui oui oui ! c\'est gagné !', 10, 15.04),
(2, 'Chaussure gauche du Klap', 'La fameuse chaussure gauche du Klap !', 0, 14),
(3, 'Chaussure droite du Klap', 'La fameuse chaussure droite du Klap !', 6, 4),
(4, 'Yoko Ono', 'La grande Yoko Ono de Suzuki, modèle de 2013 avec un jeune V12', 12, 2),
(5, 'Serviette jaune', 'La serviette jaune utilisée par le Grand Klap le 18 décembre 2017 !', 1, 7);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
