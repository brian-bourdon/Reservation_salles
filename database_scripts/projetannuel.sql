-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 03 juil. 2019 à 16:03
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projetannuel`
--

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `idNotif` int(11) NOT NULL AUTO_INCREMENT,
  `idRdv` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idNotif`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `notification`
--

INSERT INTO `notification` (`idNotif`, `idRdv`, `idUser`) VALUES
(11, 150, 19);

-- --------------------------------------------------------

--
-- Structure de la table `rendez_vous`
--

DROP TABLE IF EXISTS `rendez_vous`;
CREATE TABLE IF NOT EXISTS `rendez_vous` (
  `idRdv` int(11) NOT NULL AUTO_INCREMENT,
  `idDemandeur` int(11) NOT NULL,
  `idInterlocuteur` int(11) NOT NULL,
  `Date` date NOT NULL DEFAULT '0001-01-01',
  `HeureDebut` time NOT NULL,
  `HeureFin` time NOT NULL,
  `idSalle` varchar(50) NOT NULL,
  `statut` enum('accepted','refused','waiting','') NOT NULL DEFAULT 'waiting',
  `titre` varchar(10) NOT NULL,
  PRIMARY KEY (`idRdv`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rendez_vous`
--

INSERT INTO `rendez_vous` (`idRdv`, `idDemandeur`, `idInterlocuteur`, `Date`, `HeureDebut`, `HeureFin`, `idSalle`, `statut`, `titre`) VALUES
(151, 18, 19, '2019-07-03', '18:00:00', '19:00:00', '1', 'accepted', 'A01'),
(152, 18, 20, '2019-07-03', '18:00:00', '19:00:00', '1', 'accepted', 'A01'),
(153, 18, 20, '2019-07-03', '18:00:00', '19:00:00', '2', 'refused', 'A02');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `idSalle` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `capacite` int(11) NOT NULL,
  `statut` varchar(255) NOT NULL,
  PRIMARY KEY (`idSalle`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`idSalle`, `titre`, `capacite`, `statut`) VALUES
(1, 'A01', 20, 'test'),
(2, 'A02', 30, 'test'),
(3, 'A03', 25, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `email`, `nom`, `prenom`, `statut`, `pwd`) VALUES
(18, 'brian78.b@gmail.com', 'Bourdon', 'Brian', 'etudiant', '098f6bcd4621d373cade4e832627b4f6'),
(19, 'kyriel@gmail.com', 'test', 'Kyriel', 'etudiant', '098f6bcd4621d373cade4e832627b4f6'),
(20, 'kevin@gmail.com', 'test', 'Kevin', 'etudiant', '098f6bcd4621d373cade4e832627b4f6');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
