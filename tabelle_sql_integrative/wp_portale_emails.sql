-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mag 02, 2016 alle 12:52
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
-- Struttura della tabella `wp_portale_emails`
--

CREATE TABLE IF NOT EXISTS `wp_portale_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `soggetto` text,
  `accettazione` text,
  `rifiuto` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `wp_portale_emails`
--

INSERT INTO `wp_portale_emails` (`id`, `soggetto`, `accettazione`, `rifiuto`) VALUES
(1, 'Portale PA', 'Gentile Utente, la informiamo che il vostro nominativo è stato accettato nel portale.\r\n\r\nCordiali Saluti', 'Gentile Utente, la informiamo che il vostro nominativo non è stato accettato nel portale. La invitiamo a riprovare il seguito o recarsi all''ufficio informativo del vostro Comune.\r\n\r\nCordiali Saluti');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
