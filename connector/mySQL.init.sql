DROP TABLE IF EXISTS `login_agenda`;
CREATE TABLE IF NOT EXISTS `login_agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `data` date NOT NULL DEFAULT '0000-00-00',
  `ora` int(11) NOT NULL DEFAULT 0,
  `subiect` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `descriere` text CHARACTER SET utf8 NOT NULL DEFAULT '',
  `durata` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
TRUNCATE TABLE `login_agenda`;
DROP TABLE IF EXISTS `login_chat`;
CREATE TABLE IF NOT EXISTS `login_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `id_from` int(11) NOT NULL DEFAULT 0,
  `mesaj` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `citit` varchar(1) CHARACTER SET utf8 NOT NULL DEFAULT 'N',
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_from` (`id_from`),
  KEY `data` (`data`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
TRUNCATE TABLE `login_chat`;
DROP TABLE IF EXISTS `login_dashboard`;
CREATE TABLE IF NOT EXISTS `login_dashboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `ordine` int(11) NOT NULL DEFAULT 0,
  `rand` int(11) NOT NULL DEFAULT 1,
  `marimesm` int(11) NOT NULL DEFAULT 6,
  `marimelg` int(11) NOT NULL DEFAULT 6,
  `denumire` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `fisier` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `deschis` varchar(1) CHARACTER SET utf8 NOT NULL DEFAULT 'Y',
  `vizibil` varchar(1) CHARACTER SET utf8 NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `login_dashboard`;
INSERT INTO `login_dashboard` (`id`, `id_user`, `ordine`, `rand`, `marimesm`, `marimelg`, `denumire`, `fisier`, `deschis`, `vizibil`) VALUES
(1, 1, 1, 1, 6, 5, 'Calendar', 'calendar', 'Y', 'Y'),
(2, 1, 2, 1, 6, 7, 'Bookmarks', 'shortcuts', 'Y', 'Y');
DROP TABLE IF EXISTS `login_help`;
CREATE TABLE IF NOT EXISTS `login_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titlu` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `continut` longtext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
TRUNCATE TABLE `login_help`;
DROP TABLE IF EXISTS `login_menu`;
CREATE TABLE IF NOT EXISTS `login_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tata` int(11) NOT NULL DEFAULT 0,
  `denum` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `link` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `ordine` int(11) NOT NULL DEFAULT 0,
  `right` varchar(1) CHARACTER SET utf8 NOT NULL DEFAULT 'N',
  `icon` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT 'empty',
  PRIMARY KEY (`id`),
  KEY `id_tata` (`id_tata`),
  KEY `ordine` (`ordine`),
  KEY `right` (`right`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `login_menu`;
INSERT INTO `login_menu` (`id`, `id_tata`, `denum`, `link`, `ordine`, `right`, `icon`) VALUES
(0, 0, 'ROOT', '#', 0, 'Y', ''),
(1, 0, 'Setari', '', 1, 'N', 'setari'),
(2, 1, 'Profiluri', 'tabel-roluri', 20, 'N', 'pofile'),
(3, 1, 'Utilizatori', 'tabel-utilizatori', 10, 'N', 'user'),
(4, 1, 'Dashboard', 'tabel-dashboard', 30, 'N', 'empty'),
(5, 1, 'Scurtaturi', 'tabel-shortcuts', 40, 'N', 'empty'),
(6, 1, '-', '', 25, 'Y', 'empty'),
(7, 1, 'Agenda', 'tabel-agenda', 50, 'N', 'empty');
DROP TABLE IF EXISTS `login_rights`;
CREATE TABLE IF NOT EXISTS `login_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL DEFAULT 0,
  `id_role` int(11) NOT NULL DEFAULT 0,
  `view_right` varchar(1) CHARACTER SET utf8 NOT NULL DEFAULT 'N',
  `add_right` varchar(1) NOT NULL DEFAULT 'N',
  `modify_right` varchar(1) CHARACTER SET utf8 NOT NULL DEFAULT 'N',
  `delete_right` varchar(1) CHARACTER SET utf8 NOT NULL DEFAULT 'N',
  `details_v` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `details_a` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `details_m` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `details_d` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `details_e` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id_menu` (`id_menu`),
  KEY `id_role` (`id_role`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `login_rights`;
INSERT INTO `login_rights` (`id`, `id_menu`, `id_role`, `view_right`, `add_right`, `modify_right`, `delete_right`, `details_v`, `details_a`, `details_m`, `details_d`, `details_e`) VALUES
(1, 2, 1, 'Y', 'Y', 'Y', 'Y', 'rights', 'rights', 'rights', 'rights', ''),
(2, 3, 1, 'Y', 'Y', 'Y', 'Y', 'key', 'key', 'key', 'key', ''),
(3, 3, 1, 'Y', 'N', 'N', 'N', 'key', 'key', 'key', 'key', ''),
(4, 3, 1, 'Y', 'Y', 'N', 'N', 'key', 'key', 'key', 'key', ''),
(5, 4, 1, 'Y', 'Y', 'Y', 'Y', '', '', '', '', ''),
(6, 5, 1, 'Y', 'Y', 'Y', 'Y', '', '', '', '', ''),
(7, 7, 1, 'Y', 'Y', 'Y', 'Y', 'details', 'details', 'details', 'details', '');
DROP TABLE IF EXISTS `login_roles`;
CREATE TABLE IF NOT EXISTS `login_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `login_roles`;
INSERT INTO `login_roles` (`id`, `rolename`) VALUES
(1, 'Developer - Full access');
DROP TABLE IF EXISTS `login_shortcuts`;
CREATE TABLE IF NOT EXISTS `login_shortcuts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `id_role` int(11) NOT NULL DEFAULT 0,
  `denumire` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `fontawesome` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `backcolor` varchar(7) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `textcolor` varchar(7) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `bordercolor` varchar(7) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `link` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `ordine` int(11) NOT NULL DEFAULT 0,
  `public` varchar(1) CHARACTER SET utf8 NOT NULL DEFAULT 'Y',
  `newtab` varchar(1) CHARACTER SET utf8 NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
TRUNCATE TABLE `login_shortcuts`;
DROP TABLE IF EXISTS `login_users`;
CREATE TABLE IF NOT EXISTS `login_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `pass` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `nume` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `role` int(11) NOT NULL DEFAULT 0,
  `cnp` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `ci` varchar(10) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `telefon` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `fax` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `email` varchar(150) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `functie` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `details` text CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mobil` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `sex` varchar(1) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `yahooid` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `id_firma` int(11) NOT NULL DEFAULT 0,
  `logtime` datetime NOT NULL DEFAULT current_timestamp(),
  `chattime` datetime NOT NULL DEFAULT current_timestamp(),
  `chatroomtime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `role` (`role`),
  KEY `id_firma` (`id_firma`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `login_users`;
INSERT INTO `login_users` (`id`, `user`, `pass`, `nume`, `role`, `cnp`, `ci`, `telefon`, `fax`, `email`, `functie`, `details`, `mobil`, `sex`, `yahooid`, `id_firma`, `logtime`, `chattime`, `chatroomtime`) VALUES
(1, '[[USER]]', '[[PASS]]', '[[USER]]', 1, '', '', '', '', '', '', '', '', 'M', '', 2, '2022-01-25 10:07:37', '2022-01-25 12:06:01', '2022-01-25 12:06:01');
ALTER TABLE `login_rights` ADD FULLTEXT KEY `view_right` (`view_right`);
ALTER TABLE `login_rights` ADD FULLTEXT KEY `add_right` (`add_right`);
ALTER TABLE `login_rights` ADD FULLTEXT KEY `modify_right` (`modify_right`);
ALTER TABLE `login_rights` ADD FULLTEXT KEY `delete_right` (`delete_right`);
ALTER TABLE `login_rights` ADD FULLTEXT KEY `details_v` (`details_v`);
ALTER TABLE `login_rights` ADD FULLTEXT KEY `details_a` (`details_a`);
ALTER TABLE `login_rights` ADD FULLTEXT KEY `details_m` (`details_m`);
ALTER TABLE `login_rights` ADD FULLTEXT KEY `details_d` (`details_d`);
ALTER TABLE `login_roles` ADD FULLTEXT KEY `rolename` (`rolename`);
ALTER TABLE `login_users` ADD FULLTEXT KEY `user` (`user`);