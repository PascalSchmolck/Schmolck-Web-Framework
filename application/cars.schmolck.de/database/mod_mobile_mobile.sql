-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 12. Jul 2013 um 00:22
-- Server Version: 5.5.27
-- PHP-Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `pascal_cars.schmolck.de`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mod_mobile_mobile`
--

CREATE TABLE IF NOT EXISTS `mod_mobile_mobile` (
  `A` int(11) NOT NULL COMMENT 'satz_nummer',
  `B` int(11) NOT NULL COMMENT 'interne_nummer',
  `C` text COLLATE utf8_bin NOT NULL COMMENT 'kategorie',
  `D` text COLLATE utf8_bin NOT NULL COMMENT 'marke',
  PRIMARY KEY (`A`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='mobile.de';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
