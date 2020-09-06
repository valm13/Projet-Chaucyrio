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
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `id_membre` int(11) NOT NULL,
  `date` date NOT NULL,
  `horaire` time NOT NULL,
  `sujet` varchar(50) NOT NULL,
  `texte` varchar(10000) NOT NULL,
  `valide` int(11) NOT NULL,
  PRIMARY KEY (`id_article`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `id_membre`, `date`, `horaire`, `sujet`, `texte`, `valide`) VALUES
(1, 1, '2018-01-13', '13:24:37', 'Test', 'Les bananes sont cuites', 1),
(2, 30, '2018-01-14', '14:19:51', 'les chaucyriens', 'sdqfdsq', 1),
(3, 30, '2018-01-14', '14:21:07', 'les patates', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam dui augue, sodales euismod scelerisque et, placerat id quam. Aenean rhoncus ultrices nibh, vel lobortis ligula semper at. Duis molestie tortor urna, et tempus nunc commodo at. Sed feugiat eros orci, a tempus neque hendrerit nec. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In vel urna eu magna pretium aliquet. Suspendisse scelerisque tincidunt libero, sit amet egestas tellus tincidunt id. Praesent congue convallis sodales. Etiam blandit imperdiet dolor. Praesent aliquam ullamcorper mi quis sollicitudin. Proin ac mollis lectus. Integer massa mauris, bibendum quis aliquet in, gravida ac quam. Pellentesque blandit tristique ligula, convallis fringilla nulla vestibulum quis.\r\n\r\nNulla feugiat magna nibh, quis placerat ante rhoncus non. Curabitur pretium imperdiet mauris, non aliquet ligula finibus ut. Duis fermentum est luctus elit porttitor, id euismod nulla euismod. Donec venenatis, sapien eget consequat accumsan, nunc nulla euismod orci, quis congue sapien libero a nibh. Vivamus scelerisque magna sed tortor volutpat consectetur. Ut a feugiat augue, at convallis neque. Donec aliquam nisl tortor. Pellentesque lacinia fringilla sapien. Morbi ex sem, tempus quis hendrerit vel, convallis in mauris.', 1),
(4, 30, '2018-01-15', '07:10:03', 'Les', 'Patates', 1),
(18, 1, '2018-01-18', '12:09:17', 'Max Boublil', 'J\'aime pas les parisiennes \r\nJ\'aime pas les filles qui s\'aiment \r\nCelles qui se regardent dans la vitre du métro \r\n\r\nJ\'aime pas les commédiennes \r\nJ\'aime pas les filles mondaines \r\nJ\'aime pas celles qui se laissent inviter au resto \r\n\r\nJ\'aime pas les filles trop belles \r\nLes petites filles modèles \r\nT\'as peur qu\'on te les vole dès que tu tournes le dos \r\n\r\nJ\'aime pas les filles fashion \r\nLes fausses Paris Hilton \r\nCelles qui se maquillent même pour aller au Mac Do \r\n\r\nMoi j\'aime les moches \r\nParce qu\'on se les fait pas piquer \r\nJ\'aime les moches \r\nOn se sent plus beau à côté \r\n\r\n\r\nMoi j\'aime les moches \r\nEt j\'ai du mal à m\'en passer \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nMoi j\'aime les moches \r\nFini la haute gastronomie \r\nJ\'aime les moches \r\nMoi j\'veux une boîte de ravioli \r\nMoi j\'aime les moches \r\nParce qu\'elles veulent bien v\'nir dans mon lit. \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nJ\'aime pas les p\'tites bourgeoises, \r\nQui te rangent dans une case \r\nT\'as toujours l\'impression de pas être au niveau \r\n\r\nJ\'aime pas le genre de fille \r\nQui traîne en boîte de nuit \r\nEt qui te refile toujours un faux numéro \r\n\r\nMoi j\'aime les moches \r\nCa m\'donne un côté tolérant \r\nJ\'aime les moches \r\nCa me rend plus intelligent \r\nMoi j\'aime les moches \r\nEt les moyennes de temps en temps \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nMoi j\'aime les moches \r\nJ\'m\'en fou des manequins à talons \r\nJ\'aime les moches \r\nJ\'veux qu\'elles s\'habillent chez Decathlon \r\nMoi j\'aime les moches \r\nMoi j\'aime le boudin j\'aime le thon \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na \r\n\r\nMoi j\'aime les moches \r\nMême si la déco est banale \r\nJ\'aime les moches \r\nIl fait chaud dans un deux étoiles. \r\nMoi j\'aime les moches \r\nFaut soigner le mal par le mal \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nMoi j\'aime les moches \r\nY\'en a qui aiment les Picasso \r\nJ\'aime les moches \r\nJ\'les aime en vrai pas en tableau \r\nMoi j\'aime les moches \r\nJ\'aime les laidrons j\'aime les cajots \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na', 1),
(19, 31, '2018-01-15', '07:10:03', 'Les', 'Patates', 1),
(20, 1, '2018-01-18', '12:09:17', 'Max Boublil', 'J\'aime pas les parisiennes \r\nJ\'aime pas les filles qui s\'aiment \r\nCelles qui se regardent dans la vitre du métro \r\n\r\nJ\'aime pas les commédiennes \r\nJ\'aime pas les filles mondaines \r\nJ\'aime pas celles qui se laissent inviter au resto \r\n\r\nJ\'aime pas les filles trop belles \r\nLes petites filles modèles \r\nT\'as peur qu\'on te les vole dès que tu tournes le dos \r\n\r\nJ\'aime pas les filles fashion \r\nLes fausses Paris Hilton \r\nCelles qui se maquillent même pour aller au Mac Do \r\n\r\nMoi j\'aime les moches \r\nParce qu\'on se les fait pas piquer \r\nJ\'aime les moches \r\nOn se sent plus beau à côté \r\n\r\n\r\nMoi j\'aime les moches \r\nEt j\'ai du mal à m\'en passer \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nMoi j\'aime les moches \r\nFini la haute gastronomie \r\nJ\'aime les moches \r\nMoi j\'veux une boîte de ravioli \r\nMoi j\'aime les moches \r\nParce qu\'elles veulent bien v\'nir dans mon lit. \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nJ\'aime pas les p\'tites bourgeoises, \r\nQui te rangent dans une case \r\nT\'as toujours l\'impression de pas être au niveau \r\n\r\nJ\'aime pas le genre de fille \r\nQui traîne en boîte de nuit \r\nEt qui te refile toujours un faux numéro \r\n\r\nMoi j\'aime les moches \r\nCa m\'donne un côté tolérant \r\nJ\'aime les moches \r\nCa me rend plus intelligent \r\nMoi j\'aime les moches \r\nEt les moyennes de temps en temps \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nMoi j\'aime les moches \r\nJ\'m\'en fou des manequins à talons \r\nJ\'aime les moches \r\nJ\'veux qu\'elles s\'habillent chez Decathlon \r\nMoi j\'aime les moches \r\nMoi j\'aime le boudin j\'aime le thon \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na \r\n\r\nMoi j\'aime les moches \r\nMême si la déco est banale \r\nJ\'aime les moches \r\nIl fait chaud dans un deux étoiles. \r\nMoi j\'aime les moches \r\nFaut soigner le mal par le mal \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nMoi j\'aime les moches \r\nY\'en a qui aiment les Picasso \r\nJ\'aime les moches \r\nJ\'les aime en vrai pas en tableau \r\nMoi j\'aime les moches \r\nJ\'aime les laidrons j\'aime les cajots \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na', 1),
(21, 1, '2018-01-18', '14:00:21', 'les hiboux', 'J\'aime pas les parisiennes \r\nJ\'aime pas les filles qui s\'aiment \r\nCelles qui se regardent dans la vitre du métro \r\n\r\nJ\'aime pas les commédiennes \r\nJ\'aime pas les filles mondaines \r\nJ\'aime pas celles qui se laissent inviter au resto \r\n\r\nJ\'aime pas les filles trop belles \r\nLes petites filles modèles \r\nT\'as peur qu\'on te les vole dès que tu tournes le dos \r\n\r\nJ\'aime pas les filles fashion \r\nLes fausses Paris Hilton \r\nCelles qui se maquillent même pour aller au Mac Do \r\n\r\nMoi j\'aime les moches \r\nParce qu\'on se les fait pas piquer \r\nJ\'aime les moches \r\nOn se sent plus beau à côté \r\n\r\n\r\nMoi j\'aime les moches \r\nEt j\'ai du mal à m\'en passer \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nMoi j\'aime les moches \r\nFini la haute gastronomie \r\nJ\'aime les moches \r\nMoi j\'veux une boîte de ravioli \r\nMoi j\'aime les moches \r\nParce qu\'elles veulent bien v\'nir dans mon lit. \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nJ\'aime pas les p\'tites bourgeoises, \r\nQui te rangent dans une case \r\nT\'as toujours l\'impression de pas être au niveau \r\n\r\nJ\'aime pas le genre de fille \r\nQui traîne en boîte de nuit \r\nEt qui te refile toujours un faux numéro \r\n\r\nMoi j\'aime les moches \r\nCa m\'donne un côté tolérant \r\nJ\'aime les moches \r\nCa me rend plus intelligent \r\nMoi j\'aime les moches \r\nEt les moyennes de temps en temps \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nMoi j\'aime les moches \r\nJ\'m\'en fou des manequins à talons \r\nJ\'aime les moches \r\nJ\'veux qu\'elles s\'habillent chez Decathlon \r\nMoi j\'aime les moches \r\nMoi j\'aime le boudin j\'aime le thon \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na \r\n\r\nMoi j\'aime les moches \r\nMême si la déco est banale \r\nJ\'aime les moches \r\nIl fait chaud dans un deux étoiles. \r\nMoi j\'aime les moches \r\nFaut soigner le mal par le mal \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nMoi j\'aime les moches \r\nY\'en a qui aiment les Picasso \r\nJ\'aime les moches \r\nJ\'les aime en vrai pas en tableau \r\nMoi j\'aime les moches \r\nJ\'aime les laidrons j\'aime les cajots \r\nJ\'aime les moches \r\nOho, oho \r\n\r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na na na na na \r\nNa na na, na na na, na na na', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
