-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 29 mai 2019 à 14:06
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
  `status` varchar(255) NOT NULL,
  `titre` varchar(10) NOT NULL,
  PRIMARY KEY (`idRdv`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rendez_vous`
--

INSERT INTO `rendez_vous` (`idRdv`, `idDemandeur`, `idInterlocuteur`, `Date`, `HeureDebut`, `HeureFin`, `idSalle`, `status`, `titre`) VALUES
(1, 9, 9999, '2019-05-29', '15:00:00', '16:00:00', '1', '', 'A01'),
(2, 9, 0, '2019-05-29', '12:00:00', '14:00:00', '1', '', 'A01'),
(3, 9, 0, '2019-05-29', '13:00:00', '14:00:00', '2', '', 'A02'),
(4, 1, 9, '2019-05-29', '15:00:00', '16:00:00', '2', '', 'A02'),
(6, 15, 9, '2019-05-29', '17:00:00', '19:00:00', '1', '', 'A01'),
(126, 15, 9, '2019-05-29', '15:00:00', '23:59:00', '3', '', 'A03');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `email`, `nom`, `prenom`, `statut`, `pwd`) VALUES
(1, 'k@gmail.fr', 'DOSSOU', 'KYRIEL', 'professeur', 'f23ccd066f8236c6f97a2a62d3f9f9f5'),
(5, 'kdossou1@myges.fr', 'DOSSOU', 'Kyriel', 'etudiant', 'df8fede7ff71608e24a5576326e41c75'),
(6, 'dossou1@myges.com', 'DOSSOU', 'Kyriel', 'etudiant', 'ceb8447cc4ab78d2ec34cd9f11e4bed2'),
(7, 'McDo@food.fr', 'Mc', 'Donalds', 'etudiant', '62506be34d574da4a0d158a67253ea99'),
(8, 'boobs@hot.fr', 'logic', 'Boobs', 'etudiant', 'd091fccc62e2d24ab101dbe01ce844f6'),
(9, 'zdsf@myges.com', 'Brian', 'Bourdon', 'etudiant', '098f6bcd4621d373cade4e832627b4f6'),
(10, 'fzuegfzu@myges.comfvv', 'rgzb', 'vqf', 'etudiant', '098f6bcd4621d373cade4e832627b4f6'),
(11, 'bbourdon1@myges.frfff', 'rgzbff', 've', 'professeur', '098f6bcd4621d373cade4e832627b4f6'),
(15, 'fbve@fze.com', 'gvbeyqv', 'fbz', 'etudiant', '098f6bcd4621d373cade4e832627b4f6'),
(17, 'test1@test.com', 'Hugo', 'FRY', 'etudiant', '5fa8fd8b170efb73d331d89c549f80dd');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
