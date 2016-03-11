/*
Navicat MySQL Data Transfer

Source Server         : helix
Source Server Version : 50617
Source Host           : 185.24.69.201:3306
Source Database       : readconta

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-06-21 20:09:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tacqua_dichiarazione_mobile
-- ----------------------------
DROP TABLE IF EXISTS `tacqua_dichiarazione_mobile`;
CREATE TABLE `tacqua_dichiarazione_mobile` (
  `idtacqua_dichiarazione` int(10) unsigned NOT NULL DEFAULT '0',
  `idsic_ente` int(10) unsigned DEFAULT NULL,
  `numero_contratto` int(11) DEFAULT NULL,
  `data_inizio_contratto` date DEFAULT '0001-01-01',
  `data_fine_contratto` date DEFAULT '0001-01-01',
  `codice_giro` int(11) DEFAULT NULL,
  `marca` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `matricola` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero_unita` int(11) DEFAULT NULL,
  `numero_allacci` int(11) DEFAULT NULL,
  `messaggio` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `contribuente` varchar(131) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contribuente_data_nascita` date DEFAULT NULL,
  `contribuente_cf` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contribuente_piva` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contribuente_tipo_utente` int(11) DEFAULT NULL,
  `contribuente_indirizzo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contribuente_civico` varchar(18) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contribuente_scala` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contribuente_interno` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contribuente_piano` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contribuente_citta` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contribuente_provincia` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contribuente_cap` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `proprietario` varchar(131) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `proprietario_cf` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `proprietario_piva` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ubicazione_indirizzo` varchar(101) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ubicazione_civico` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ubicazione_esponente` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ubicazione_scala` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ubicazione_piano` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ubicazione_interno` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
