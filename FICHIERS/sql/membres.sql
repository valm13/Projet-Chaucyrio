-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 14 jan. 2018 à 22:43
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
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id_membre` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` int(11) DEFAULT '-1',
  `date_inscription` date DEFAULT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `pays` varchar(30) NOT NULL,
  `ville` varchar(40) DEFAULT NULL,
  `code_postal` varchar(6) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `numero_telephone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id_membre`, `email`, `mot_de_passe`, `role`, `date_inscription`, `nom`, `prenom`, `pays`, `ville`, `code_postal`, `adresse`, `date_naissance`, `numero_telephone`) VALUES
(1, 'bruce@wayne.corp', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1, NULL, 'Wayne', 'Bruce', 'Belgique', 'Gotham', '74515', 'Bâtiment Nord, Wayne Corp', NULL, NULL),
(2, 'gainsbarre@serge.fr', '49897ee5656aba3cf72f2a5f2b11b4d6406e9920', -1, '2017-11-25', 'Gainsbourg', 'Serge', 'France', 'Cimeterre', '', '', '1970-01-01', ''),
(3, 'serge@serge.fr', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 0, NULL, 'Gainsbourg', 'Serge', 'France', '', '', '', '1970-01-01', ''),
(4, 'mayou.pote@test.fr', 'pote', NULL, NULL, 'Mayou', 'Marsot', 'France', 'Aix', '', '', NULL, NULL),
(5, 'pote@mayou.fr', '25ec6a59aba347031747d6724cf1a5706d0cddf6', NULL, NULL, 'Mayeul', 'Marsaut', 'France', 'Aix-en-Provence', '', '', '2017-12-21', '08 45 11 22 51 '),
(30, 'elio.bilisari@isen.yncrea.fr', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', -1, '2018-01-14', 'Bilisari', 'Elio', 'France', 'La Farlède', '', '', '2018-01-02', '0777005767');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
