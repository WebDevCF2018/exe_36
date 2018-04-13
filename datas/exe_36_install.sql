-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 13 avr. 2018 à 09:34
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données :  `exe_36`
--
CREATE DATABASE IF NOT EXISTS `exe_36` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `exe_36`;

-- --------------------------------------------------------

--
-- Structure de la table `categ`
--

DROP TABLE IF EXISTS `categ`;
CREATE TABLE IF NOT EXISTS `categ` (
  `idcateg` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `desc` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`idcateg`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categ`
--

INSERT INTO `categ` (`idcateg`, `name`, `desc`) VALUES
(1, 'International', 'L\'adjectif international décrit les rapports existants entre plusieurs nations.'),
(2, 'France', 'Fruit d\'une histoire politique longue et mouvementée, la France est une république constitutionnelle unitaire ayant un régime semi-présidentiel. '),
(3, 'Culture', 'En philosophie, le mot culture désigne ce qui est différent de la nature, c\'est-à-dire ce qui est de l\'ordre de l\'acquis et non de l\'inné.'),
(4, 'Economie', 'L\'économie est une discipline qui étudie l\'économie en tant qu\'activité humaine qui consiste en la production, la distribution, l\'échange et la consommation de biens et de services.'),
(5, 'Sport', 'Le sport est un ensemble d\'exercices physiques.');

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `idnews` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `publication` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `visible` tinyint(3) UNSIGNED DEFAULT '0',
  `user_iduser` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`idnews`),
  KEY `fk_news_user1_idx` (`user_iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Structure de la table `news_has_categ`
--

DROP TABLE IF EXISTS `news_has_categ`;
CREATE TABLE IF NOT EXISTS `news_has_categ` (
  `news_idnews` int(10) UNSIGNED NOT NULL,
  `categ_idcateg` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`news_idnews`,`categ_idcateg`),
  KEY `fk_news_has_categ_categ1_idx` (`categ_idcateg`),
  KEY `fk_news_has_categ_news1_idx` (`news_idnews`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `idpermission` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `level` smallint(5) UNSIGNED NOT NULL DEFAULT '3' COMMENT '0 => admin\n1 => moderator\n2 => editor\n3 => user',
  PRIMARY KEY (`idpermission`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`idpermission`, `name`, `level`) VALUES
(1, 'Admin', 0),
(2, 'Moderator', 1),
(3, 'Editor', 2),
(4, 'User', 3);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `iduser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` varchar(60) NOT NULL,
  `pwd` varchar(64) NOT NULL,
  `name` varchar(120) NOT NULL,
  `permission_idpermission` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  KEY `fk_user_permission_idx` (`permission_idpermission`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;



--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_user1` FOREIGN KEY (`user_iduser`) REFERENCES `user` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `news_has_categ`
--
ALTER TABLE `news_has_categ`
  ADD CONSTRAINT `fk_news_has_categ_categ1` FOREIGN KEY (`categ_idcateg`) REFERENCES `categ` (`idcateg`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_news_has_categ_news1` FOREIGN KEY (`news_idnews`) REFERENCES `news` (`idnews`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_permission` FOREIGN KEY (`permission_idpermission`) REFERENCES `permission` (`idpermission`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`iduser`, `login`, `pwd`, `name`, `permission_idpermission`) VALUES
(1, 'admin', 'admin', 'Pitz Michaël', 1),
(2, 'modo', 'modo', 'Sandron Pierre', 2),
(3, 'edit', 'edit', 'VandeTruc Benjamin', 3),
(4, 'user1', 'user1', 'Ben Ali Hamza', 4),
(5, 'user2', 'user2', 'Boumezough Nabil', 4);
--
-- Déchargement des données de la table `news`
--

INSERT INTO `news` (`idnews`, `title`, `content`, `publication`, `visible`, `user_iduser`) VALUES
(1, 'Clément Cogitore: Raconter une histoire, c’est prendre le pouvoir', 'Rencontre avec Clément Cogitore, jeune star française de l’art contemporain, cinéaste et vidéaste, nommé pour le prix Marcel-Duchamp 2018, qui travaille à nous raconter des histoires : où en est l’art du récit aujourd’hui ? « On s’est dit, en histoire de l’art, comme en littérature, que puisque c’était la fin des grands récits, on pouvait s’en débarrasser : mais non. »\r\n\r\nClément Cogitore est un passeur, son art est celui de passer les frontières. Il travaille au croisement des arts plastiques et du cinéma : son dernier film, Braguino (2017), est sorti en salles en même temps qu’il a donné lieu à une installation dans un musée. Le film, qui évoque la vie d’une famille installée en pleine taïga sibérienne, fait se rencontrer des images du Far East avec une mythologie du Far West. \r\n\r\nPas de frontière entre les hommes, entre les histoires, pas de solution de continuité entre fiction et documentaire.', '2018-03-21 10:35:14', 1, 1);

--
-- Déchargement des données de la table `news_has_categ`
--

INSERT INTO `news_has_categ` (`news_idnews`, `categ_idcateg`) VALUES
(1, 2),
(1, 3);



COMMIT;

# \\Web_form_pc\web2018