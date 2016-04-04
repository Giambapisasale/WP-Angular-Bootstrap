-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2016 alle 13:30
-- Versione del server: 5.7.9
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `portale`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `tacqua_dichiarazione_lettura`
--

CREATE TABLE IF NOT EXISTS `tacqua_dichiarazione_lettura` (
  `idtacqua_dichiarazione_lettura` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idtacqua_dichiarazione` int(11) DEFAULT NULL,
  `anno` int(11) DEFAULT NULL,
  `periodo` int(11) DEFAULT '1',
  `data_lettura` date DEFAULT NULL,
  `lettura` double(10,0) DEFAULT NULL,
  `consumo` double(10,0) DEFAULT NULL,
  `idtacqua_tbl_tipo_lettura` int(11) DEFAULT NULL,
  `fatturata` int(11) NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idtacqua_flusso_lettura` int(11) DEFAULT NULL,
  `idtco_preavviso` int(11) DEFAULT NULL,
  `verifica` tinyint(1) NOT NULL DEFAULT '0',
  `url_foto` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idtacqua_dichiarazione_lettura`),
  KEY `dich` (`idtacqua_dichiarazione`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35771 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
