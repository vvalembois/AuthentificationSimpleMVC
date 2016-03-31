-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 31 Mars 2016 à 02:20
-- Version du serveur :  5.6.28-0ubuntu0.15.10.1
-- Version de PHP :  5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `authentifier`
--

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`art_id`, `art_title`, `art_author`, `art_creation_date`, `art_update_date`, `art_content`, `art_image`, `art_reader_counter`) VALUES
(10, 'OpenStack', 5, '2016-03-31 01:20:03', '2016-03-31 01:57:11', 'Au-delà de l\'effet de buzz, des organisations ont concrètement mis en œuvre des projets reposant sur OpenStack. Pour des usages variés comme le montrent les retours d\'expérience de Morpho, Amadeus et du Cern.\r\n\r\nQue de chemin parcouru depuis 2010. Cette année-là, l\'hébergeur Rackspace et la Nasa plaçaient en open source une nouvelle solution d\'Infrastructure as a Service (IaaS). Avec l\'engouement que l\'on sait. Aujourd\'hui, OpenStack en est à sa douzième version, et sa communauté compte plus de 30 000 membres à travers le monde.\r\n\r\nOpenStack n\'est pas un produit d\'un seul tenant mais un ensemble de services dédiés au calcul, au stockage, au réseau, à la gestion des données ou au traitement des données. Une boîte de legos dans laquelle les utilisateurs viennent prendre les brisques dont ils ont besoin. De fait, il y a autant de configurations d\'OpenStack que de projets. On le voit d\'ailleurs dans les réalisations de Morpho (Safran), Amadeus et du Cern réunies dans ce dossier.', NULL, 27),
(11, 'Les 12 secteurs qui paient le mieux', 1, '2016-03-31 01:42:27', '2016-03-31 01:45:56', 'Dans le pétrole ou la finance, dans l\'énergie ou la pharmacie, les bulletins de paie sont bien plus généreux qu\'ailleurs. Alors que le salaire moyen en France s\'établit à 2 128 euros net, il dépasse les 2 500 euros dans une douzaine de secteurs. Et franchit même parfois la barre des 3 000 euros.\r\n\r\nGrâce aux chiffres de la Dares, le JDN vous présente les activités dans lesquels les travailleurs conservent des rémunérations particulièrement avantageuses en comparaison des autres salariés. Découvrez ces pans entiers de l\'économie qui échappent à la morosité salariale.', NULL, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
