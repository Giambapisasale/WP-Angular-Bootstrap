-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2016 alle 10:35
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
-- Struttura della tabella `tco_contribuente`
--

CREATE TABLE IF NOT EXISTS `tco_contribuente` (
  `idtco_contribuente` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idsic_ente` int(11) DEFAULT NULL,
  `cognome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_nascita` date DEFAULT NULL,
  `data_inizio_attivita` date DEFAULT NULL,
  `data_cessazione_attivita` date DEFAULT NULL,
  `numero_protocollo_cessazione` int(11) DEFAULT NULL,
  `data_protocollo_cessazione` date DEFAULT NULL,
  `idmaps_comune_nascita` int(11) DEFAULT NULL,
  `comune_nascita` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prov_nascita` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idmaps_nazione` int(11) DEFAULT NULL,
  `sesso` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idmaps_stradario` int(10) unsigned DEFAULT NULL,
  `indirizzo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `civico` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `scala` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interno` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `piano` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idmaps_comune_residenza` int(11) DEFAULT NULL,
  `citta` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prov` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cap` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localita` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codicefiscale` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `piva` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cellulare` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `idamb_tipo_utente` int(11) DEFAULT NULL,
  `data_morte` date DEFAULT NULL,
  `numero_componenti` int(11) DEFAULT NULL,
  `numero_minori` int(11) DEFAULT NULL,
  `numero_anziani` int(11) DEFAULT NULL,
  `numero_eta_altro` int(11) DEFAULT NULL,
  `numero_fascicolo` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flag_famiglia_bloccata` tinyint(1) DEFAULT NULL,
  `identificazione_ditta` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idtco_rappresentante` int(11) DEFAULT NULL,
  `codice_famiglia` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codice_anagrafe` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_idsic_operatore` int(11) DEFAULT NULL,
  `updated_idsic_operatore` int(11) DEFAULT NULL,
  `verifica` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idtco_contribuente`),
  KEY `tco_contribuente_cognome_index` (`cognome`),
  KEY `tco_contribuente_cod_famiglia_index` (`codice_famiglia`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3139 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
