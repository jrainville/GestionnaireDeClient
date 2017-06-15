-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Client: localhost:3306
-- Généré le: Mer 14 Juin 2017 à 20:23
-- Version du serveur: 5.6.35-cll-lve
-- Version de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `swann_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nomClient` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `dateNaissance` date NOT NULL,
  `tag` varchar(255) NOT NULL,
  `codePostal` varchar(10) NOT NULL,
  `sexe` varchar(255) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`client_id`, `nomClient`, `adresse`, `ville`, `telephone`, `dateNaissance`, `tag`, `codePostal`, `sexe`) VALUES
(9, 'ccewf', '273 cantin', 'Terrebonne', '4509642061', '2013-12-06', 'allo@bob.com', 'J6w 5r9', 'Femme'),
(11, 'Pas de contrat', '123 test', 'Montréal', '4550126262', '1997-11-16', 'wqdwq@cwq.com', 'regewwe', 'Femme'),
(12, 'Sans courriel', '123 test', 'Montréal', '1234567890', '1995-11-13', '', 'H2A2N6', 'Femme'),
(13, 'mm', 'mm', 'mm', '000', '1978-08-02', 'aucun', '00', 'Femme'),
(14, 'jj', 'jj', 'jj', 'jj', '1978-02-02', 'jrobi61@hotmail.com', 'jj', 'Femme'),
(15, '11', '11', '11', '11', '1986-02-02', '', '11', 'Femme'),
(16, '55', '55', '55', '55', '1986-01-01', '58belisle@hotmail.com', '55', 'Femme');

-- --------------------------------------------------------

--
-- Structure de la table `contrats`
--

CREATE TABLE IF NOT EXISTS `contrats` (
  `contrat_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `numeroContrat` int(11) NOT NULL,
  `duree` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `fraisAdministration` float NOT NULL,
  `cout` float NOT NULL,
  `TPS` float NOT NULL,
  `TVQ` float NOT NULL,
  `total` float NOT NULL,
  `numeroCarteCredit` varchar(255) DEFAULT NULL,
  `expirationCarteCredit` varchar(255) DEFAULT NULL,
  `numSecuriteCarteCredit` int(11) DEFAULT NULL,
  `typeContrat` varchar(255) NOT NULL,
  `dateResiliation` date DEFAULT NULL,
  `dateSuspension` date DEFAULT NULL,
  PRIMARY KEY (`contrat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `contrats`
--

INSERT INTO `contrats` (`contrat_id`, `client_id`, `numeroContrat`, `duree`, `dateDebut`, `dateFin`, `fraisAdministration`, `cout`, `TPS`, `TVQ`, `total`, `numeroCarteCredit`, `expirationCarteCredit`, `numSecuriteCarteCredit`, `typeContrat`, `dateResiliation`, `dateSuspension`) VALUES
(8, 8, 0, 12, '2015-11-02', '2016-11-02', 12, 12, 0.6, 1.2, 13.8, '', '', 0, 'NORMAL', '2015-10-31', '2015-11-03'),
(9, 9, 123123, 12, '2013-06-07', '2014-06-07', 100, 199, 14.95, 29.8253, 343.775, '', '', 0, 'Magique', '0000-00-00', NULL),
(10, 10, 16516, 12, '2015-10-19', '2015-11-19', 12, 1200, 60, 119.7, 1379.7, '1245353453415', '09/32', 123, 'NORMAL', NULL, '2015-11-02'),
(11, 12, 16516, 12, '2015-11-02', '2016-11-02', 12, 244, 12.2, 24.34, 280.54, '', '', 0, 'Normal', NULL, NULL),
(12, 13, 0, 1, '2015-02-02', '2015-03-02', 0, 19.99, 1, 1.99, 22.98, '', '', 0, '19.99', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `infos`
--

CREATE TABLE IF NOT EXISTS `infos` (
  `info_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descriptionServices` text NOT NULL,
  `reglements` text NOT NULL,
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `infos`
--

INSERT INTO `infos` (`info_id`, `descriptionServices`, `reglements`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam et eleifend elit, ac dictum massa. In in leo eu augue venenatis molestie. Etiam tempus lectus in eros malesuada finibus. Donec non bibendum elit, vitae tincidunt ex. Fusce libero urna, tempus ac hendrerit in, ultrices et sapien.<br />\r\n<br />\r\nFusce pellentesque elit at varius vehicula. Phasellus laoreet lacus sem, id varius erat consequat eu. Donec nec arcu sit amet ante interdum bibendum eget in lacus.', 'Sed nec orci tincidunt, sodales justo id, eleifend diam. Duis vehicula et urna quis venenatis. Aliquam erat volutpat. Sed venenatis felis ut dui malesuada laoreet. Ut nec arcu ex. Nam aliquam laoreet nisl, eu dignissim urna fermentum a.<br />\r\n<br />\r\nMaecenas massa libero, consequat at iaculis non, interdum ac felis. Nunc pharetra pulvinar dapibus. Suspendisse sit amet diam metus. Suspendisse tortor nisi, consequat blandit ligula nec, vestibulum porttitor nisi.<br />\r\n<br />\r\nInteger congue, velit vitae faucibus molestie, metus nibh interdum eros, vel elementum odio libero ut nibh. Praesent et suscipit nunc. Suspendisse efficitur congue venenatis. Nunc rutrum hendrerit augue malesuada pretium. Ut nisi velit, molestie sit amet ex id, efficitur pretium metus. Suspendisse rhoncus, leo ac fringilla volutpat, ipsum justo aliquet sem, ut ullamcorper sapien odio ac massa.');

-- --------------------------------------------------------

--
-- Structure de la table `modesPaiements`
--

CREATE TABLE IF NOT EXISTS `modesPaiements` (
  `modePaiement_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `modePaiement` varchar(255) NOT NULL,
  PRIMARY KEY (`modePaiement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `modesPaiements`
--

INSERT INTO `modesPaiements` (`modePaiement_id`, `modePaiement`) VALUES
(7, 'Comptant'),
(11, 'Crédit');

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE IF NOT EXISTS `paiements` (
  `paiement_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `montant` float NOT NULL,
  `datePaiement` date NOT NULL,
  `modePaiement_id` int(11) DEFAULT NULL,
  `conc` tinyint(1) NOT NULL DEFAULT '0',
  `contrat_id` int(11) NOT NULL,
  PRIMARY KEY (`paiement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=522 ;

--
-- Contenu de la table `paiements`
--

INSERT INTO `paiements` (`paiement_id`, `montant`, `datePaiement`, `modePaiement_id`, `conc`, `contrat_id`) VALUES
(253, 28.6479, '2013-06-07', 7, 0, 9),
(254, 28.6479, '2013-07-07', 7, 0, 9),
(255, 28.6479, '2013-08-06', 7, 0, 9),
(256, 28.6479, '2013-09-05', 7, 0, 9),
(257, 28.6479, '2013-10-05', 7, 0, 9),
(258, 28.6479, '2013-11-04', 7, 0, 9),
(259, 28.6479, '2013-12-04', 7, 0, 9),
(260, 28.6479, '2014-01-03', 7, 0, 9),
(261, 28.6479, '2014-02-02', 7, 0, 9),
(262, 28.6479, '2014-03-04', 7, 0, 9),
(263, 28.6479, '2014-04-03', 7, 0, 9),
(264, 28.6479, '2014-05-03', 7, 0, 9),
(310, 95.8125, '2013-06-20', 7, 0, 7),
(311, 95.8125, '2013-06-28', 7, 0, 7),
(312, 95.8125, '2013-07-06', 7, 0, 7),
(313, 95.8125, '2013-07-14', 7, 0, 7),
(314, 95.8125, '2013-07-22', 7, 0, 7),
(315, 95.8125, '2013-07-30', 7, 0, 7),
(316, 95.8125, '2013-08-07', 7, 0, 7),
(317, 95.8125, '2013-08-15', 7, 0, 7),
(318, 95.8125, '2013-08-23', 7, 0, 7),
(319, 95.8125, '2013-08-31', 7, 0, 7),
(320, 95.8125, '2013-09-08', 7, 0, 7),
(321, 95.8125, '2013-09-16', 7, 0, 7),
(322, 95.8125, '2013-09-24', 7, 0, 7),
(323, 95.8125, '2013-10-02', 7, 0, 7),
(324, 95.8125, '2013-10-10', 7, 0, 7),
(325, 95.8125, '2013-10-18', 7, 0, 7),
(326, 95.8125, '2013-10-26', 7, 0, 7),
(327, 95.8125, '2013-11-03', 7, 0, 7),
(328, 95.8125, '2013-11-11', 7, 0, 7),
(329, 95.8125, '2013-11-19', 7, 0, 7),
(330, 95.8125, '2013-11-27', 7, 0, 7),
(331, 95.8125, '2013-12-05', 7, 0, 7),
(332, 95.8125, '2013-12-13', 7, 0, 7),
(333, 95.8125, '2013-12-21', 7, 0, 7),
(334, 95.8125, '2013-12-29', 7, 0, 7),
(335, 95.8125, '2014-01-06', 7, 0, 7),
(336, 95.8125, '2014-01-14', 7, 0, 7),
(337, 95.8125, '2014-01-22', 7, 0, 7),
(338, 95.8125, '2014-01-30', 7, 0, 7),
(339, 95.8125, '2014-02-07', 7, 0, 7),
(340, 95.8125, '2014-02-15', 7, 0, 7),
(341, 95.8125, '2014-02-23', 7, 0, 7),
(342, 95.8125, '2014-03-03', 7, 0, 7),
(343, 95.8125, '2014-03-11', 7, 0, 7),
(344, 95.8125, '2014-03-19', 7, 0, 7),
(345, 95.8125, '2014-03-27', 7, 0, 7),
(346, 95.8125, '2014-04-04', 7, 0, 7),
(347, 95.8125, '2014-04-12', 7, 0, 7),
(348, 95.8125, '2014-04-20', 7, 0, 7),
(349, 95.8125, '2014-04-28', 7, 0, 7),
(350, 95.8125, '2014-05-06', 7, 0, 7),
(351, 95.8125, '2014-05-14', 7, 0, 7),
(352, 95.8125, '2014-05-22', 7, 0, 7),
(353, 95.8125, '2014-05-30', 7, 0, 7),
(468, 114.975, '2015-10-19', 7, 1, 10),
(469, 114.975, '2015-10-21', 7, 1, 10),
(470, 114.975, '2015-10-23', 7, 1, 10),
(480, 23.3783, '2015-11-02', 7, 0, 11),
(481, 23.3783, '2015-12-02', 7, 0, 11),
(482, 23.3783, '2016-01-01', 7, 0, 11),
(483, 23.3783, '2016-01-31', 7, 0, 11),
(484, 23.3783, '2016-03-01', 7, 0, 11),
(485, 23.3783, '2016-03-31', 7, 0, 11),
(486, 23.3783, '2016-04-30', 7, 0, 11),
(487, 23.3783, '2016-05-30', 7, 0, 11),
(488, 23.3783, '2016-06-29', 7, 0, 11),
(489, 23.3783, '2016-07-29', 7, 0, 11),
(490, 23.3783, '2016-08-28', 7, 0, 11),
(491, 23.3783, '2016-09-27', 7, 0, 11),
(492, 1.15, '2015-11-02', 7, 1, 8),
(493, 1.15, '2015-12-02', 7, 1, 8),
(494, 1.15, '2016-01-01', 7, 1, 8),
(495, 1.15, '2016-01-31', 7, 1, 8),
(504, 1.15, '2015-11-19', 7, 0, 8),
(505, 1.15, '2016-01-01', 7, 0, 8),
(506, 1.15, '2016-02-13', 7, 0, 8),
(507, 1.15, '2016-03-27', 7, 0, 8),
(508, 1.15, '2016-05-09', 7, 0, 8),
(509, 1.15, '2016-06-21', 7, 0, 8),
(510, 1.15, '2016-08-03', 7, 0, 8),
(511, 1.15, '2016-09-15', 7, 0, 8),
(512, 22.98, '2015-02-02', 7, 0, 12),
(513, 114.975, '2015-01-02', 7, 0, 10),
(514, 114.975, '2015-02-06', 7, 0, 10),
(515, 114.975, '2015-03-13', 7, 0, 10),
(516, 114.975, '2015-04-17', 7, 0, 10),
(517, 114.975, '2015-05-22', 7, 0, 10),
(518, 114.975, '2015-06-26', 7, 0, 10),
(519, 114.975, '2015-07-31', 7, 0, 10),
(520, 114.975, '2015-09-04', 7, 0, 10),
(521, 114.975, '2015-10-09', 7, 0, 10);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `code`) VALUES
(1, 'testuser', 'hjZXuzhIbGn2o', 'test@gmail.com', 'Oy6CxmS9ftJqIHaCTQvw'),
(2, 'gestionnaireAdmin', 'hjZXuzhIbGn2o', 'test@gmail.com', '4Ks1e2FJje3evUgpNTRU');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
