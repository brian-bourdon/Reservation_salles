-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 09 mai 2019 à 13:53
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
  `HeureDebut` time NOT NULL,
  `HeureFin` time NOT NULL,
  `Salle` varchar(50) NOT NULL,
  PRIMARY KEY (`idRdv`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rendez_vous`
--

INSERT INTO `rendez_vous` (`idRdv`, `idDemandeur`, `idInterlocuteur`, `HeureDebut`, `HeureFin`, `Salle`) VALUES
(1, 9, 9999, '15:00:00', '16:00:00', 'A13');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

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
(16, 'fbve@fze.com', 'gvbeyqv', 'fbz', 'professeur', '098f6bcd4621d373cade4e832627b4f6');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
