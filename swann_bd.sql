-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Jeu 20 Juin 2013 à 23:02
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`client_id`, `nomClient`, `adresse`, `ville`, `telephone`, `dateNaissance`, `tag`, `codePostal`, `sexe`) VALUES
(7, 'jonathan rainville', '273 cantinf', 'Terrebonnef', '4509642062', '1993-09-19', 'fllo@bob.com', 'J6w 5r8', 'Femme'),
(8, 'Caroline la po fine', '273 cantin', 'Terrebonne', '4509642061', '2013-06-04', 'allo@bob.com', 'J6w 5r9', 'Femme'),
(9, 'ccewf', '273 cantin', 'Terrebonne', '4509642061', '2013-06-04', 'allo@bob.com', 'J6w 5r9', 'Femme');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `contrats`
--

INSERT INTO `contrats` (`contrat_id`, `client_id`, `numeroContrat`, `duree`, `dateDebut`, `dateFin`, `fraisAdministration`, `cout`, `TPS`, `TVQ`, `total`, `numeroCarteCredit`, `expirationCarteCredit`, `numSecuriteCarteCredit`, `typeContrat`, `dateResiliation`, `dateSuspension`) VALUES
(7, 7, 2, 12, '2012-10-30', '2013-06-20', 0, 1000, 50, 99.75, 1149.75, '34224', '12/14', 3122, 'NORMAL', '2013-06-20', '2013-06-20'),
(8, 8, 95976, 12, '2013-06-01', '2014-06-01', 0, 1000, 50, 99.75, 1149.75, '', '', 0, 'NORMAL', '0000-00-00', '2013-06-20'),
(9, 9, 123123, 12, '2013-06-07', '2014-06-07', 100, 199, 14.95, 29.8253, 343.775, '', '', 0, 'Magique', '0000-00-00', NULL);

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
(1, 'Description des services et des personnes<br />\r\n-ewfew<br />\r\n-efwef salut l''ami<br />\r\n-rffer-(),,..''''''''<br />\r\nDescription des <br />\r\nDescription des services et des personnes<br />\r\n-ewfew<br />\r\n-efwef salut l''ami<br />\r\n-rffer-(),,..''''''''<br />\r\nDescription des services et des personnes<br />\r\n-ewfew<br />\r\n-efwef salut l''ami<br />\r\n-rffer-(),,..''''''''services et des personnes<br />\r\n-ewfew<br />\r\n-efwef salut l''ami<br />\r\n-rffer-(),,..''''''''<br />\r\nDescription des services et des personnes<br />\r\n-ewfew<br />\r\n-efwef salut l''ami<br />\r\n-rffer-(),,..''''''''v<br />\r\nDescription des services et des personnes<br />\r\n-ewfew<br />\r\n-efwef salut l''ami<br />\r\n-rffer-(),,..''''''''', 'Réglements généraux.cnew  oiwerew j rpwer allo...<br />\r\n-les gens,,,<br />\r\ngrgreg<br />\r\nDescription des services et des personnes<br />\r\n-ewfew<br />\r\n-efwef salut l''ami<br />\r\n-rffer-(),,..''''''''<br />\r\nDescription des services et des personnes<br />\r\n-ewfew<br />\r\n-efwef salut l''ami<br />\r\n-rffer-(),,..''''''''<br />\r\nDescription des services et des personnes<br />\r\n-ewfew<br />\r\n-efwef salut l''ami<br />\r\n-rffer-(),,..''''''''<br />\r\ngergerg<br />\r\ngegre<br />\r\nRéglements généraux.cnew  oiwerew j rpwer allo...<br />\r\n-les gens,,,<br />\r\ngrgreg<br />\r\ngergerg<br />\r\nRéglements généraux.cnew  oiwerew j rpwer allo...<br />\r\n-les gens,,,<br />\r\ngrgreg<br />\r\ngergergv<br />\r\n-dewdeéefrérà;;;<br />\r\n-dkefoe:::<br />\r\n-regerg<br />\r\n-lew<br />\r\n-ewf');

-- --------------------------------------------------------

--
-- Structure de la table `modespaiements`
--

CREATE TABLE IF NOT EXISTS `modespaiements` (
  `modePaiement_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `modePaiement` varchar(255) NOT NULL,
  PRIMARY KEY (`modePaiement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `modespaiements`
--

INSERT INTO `modespaiements` (`modePaiement_id`, `modePaiement`) VALUES
(7, 'Comptant');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=354 ;

--
-- Contenu de la table `paiements`
--

INSERT INTO `paiements` (`paiement_id`, `montant`, `datePaiement`, `modePaiement_id`, `conc`, `contrat_id`) VALUES
(241, 95.8125, '2013-06-01', 7, 1, 8),
(242, 95.8125, '2013-07-01', 7, 1, 8),
(243, 95.8125, '2013-07-31', 7, 1, 8),
(244, 95.8125, '2013-08-30', 7, 1, 8),
(245, 95.8125, '2013-09-29', 7, 1, 8),
(246, 95.8125, '2013-10-29', 7, 1, 8),
(247, 95.8125, '2013-11-28', 7, 1, 8),
(248, 95.8125, '2013-12-28', 7, 1, 8),
(249, 95.8125, '2014-01-27', 7, 1, 8),
(250, 95.8125, '2014-02-26', 7, 1, 8),
(251, 95.8125, '2014-03-28', 7, 1, 8),
(252, 95.8125, '2014-04-27', 7, 1, 8),
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
(353, 95.8125, '2014-05-30', 7, 0, 7);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
