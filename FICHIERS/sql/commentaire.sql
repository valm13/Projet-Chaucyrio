-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 18 jan. 2018 à 15:47
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
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL COMMENT 'id du membre ayant posté',
  `date` date NOT NULL,
  `horaire` time NOT NULL,
  `texte` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_commentaire`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `id_article`, `id_membre`, `date`, `horaire`, `texte`) VALUES
(1, 1, 1, '2018-01-13', '14:15:35', 'Ce commentaire est très utile !'),
(2, 1, 1, '2018-01-13', '14:15:35', 'Ce commentaire est très utile !'),
(3, 1, 1, '2018-01-13', '14:15:35', 'Ce commentaire est très utile !'),
(4, 2, 1, '2018-01-13', '15:15:35', 'Ce commentaire est très utile !'),
(5, 2, 1, '2018-01-13', '15:15:35', 'Ce commentaire est très utile !'),
(6, 3, 1, '2018-01-13', '15:15:35', 'Ce commentaire est très utile !'),
(7, 4, 1, '2018-01-13', '15:15:35', 'AHAHAH ce commentaire est différent !!!\r\nC\'est pas pour ça qu\'il est méchant :D !');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
