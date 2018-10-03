DROP TABLE IF EXISTS `login_agenda`;

CREATE TABLE IF NOT EXISTS `login_agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `data` date NOT NULL,
  `ora` int(11) NOT NULL,
  `subiect` varchar(250) NOT NULL,
  `descriere` text NOT NULL,
  `durata` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

TRUNCATE TABLE `login_agenda`;

DROP TABLE IF EXISTS `login_chat`;

CREATE TABLE IF NOT EXISTS `login_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_from` int(11) NOT NULL,
  `mesaj` varchar(255) NOT NULL,
  `citit` varchar(1) NOT NULL DEFAULT 'N',
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_from` (`id_from`),
  KEY `data` (`data`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

TRUNCATE TABLE `login_chat`;

DROP TABLE IF EXISTS `login_dashboard`;

CREATE TABLE IF NOT EXISTS `login_dashboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `ordine` int(11) NOT NULL,
  `rand` int(11) NOT NULL DEFAULT '1',
  `marimesm` int(11) NOT NULL,
  `marimelg` int(11) NOT NULL,
  `denumire` varchar(250) NOT NULL,
  `fisier` varchar(100) NOT NULL,
  `deschis` varchar(1) NOT NULL DEFAULT 'Y',
  `vizibil` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

TRUNCATE TABLE `login_dashboard`;

INSERT INTO `login_dashboard` (`id`, `id_user`, `ordine`, `rand`, `marimesm`, `marimelg`, `denumire`, `fisier`, `deschis`, `vizibil`) VALUES
(1, 1, 1, 1, 6, 5, 'Calendar', 'calendar', 'Y', 'Y'),
(2, 1, 2, 1, 6, 7, 'Bookmarks', 'shortcuts', 'Y', 'Y');

DROP TABLE IF EXISTS `login_help`;

CREATE TABLE IF NOT EXISTS `login_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titlu` varchar(250) CHARACTER SET utf8 NOT NULL,
  `continut` longtext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

TRUNCATE TABLE `login_help`;

DROP TABLE IF EXISTS `login_menu`;

CREATE TABLE IF NOT EXISTS `login_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tata` int(11) NOT NULL,
  `denum` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `ordine` int(11) NOT NULL,
  `right` varchar(1) NOT NULL DEFAULT 'N',
  `icon` varchar(100) NOT NULL DEFAULT 'empty',
  PRIMARY KEY (`id`),
  KEY `id_tata` (`id_tata`),
  KEY `ordine` (`ordine`),
  KEY `right` (`right`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

TRUNCATE TABLE `login_menu`;

INSERT INTO `login_menu` (`id`, `id_tata`, `denum`, `link`, `ordine`, `right`, `icon`) VALUES
(0, 0, 'ROOT', '#', 0, 'Y', '');

UPDATE `login_menu` SET `id` = '0' WHERE `login_menu`.`id` = 1;

INSERT INTO `login_menu` (`id`, `id_tata`, `denum`, `link`, `ordine`, `right`, `icon`) VALUES
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
  `id_menu` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `view_right` varchar(1) NOT NULL DEFAULT 'N',
  `add_right` varchar(1) NOT NULL DEFAULT 'N',
  `modify_right` varchar(1) NOT NULL DEFAULT 'N',
  `delete_right` varchar(1) NOT NULL DEFAULT 'N',
  `details_v` varchar(200) NOT NULL DEFAULT '',
  `details_a` varchar(250) NOT NULL DEFAULT '',
  `details_m` varchar(250) NOT NULL DEFAULT '',
  `details_d` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id_menu` (`id_menu`),
  KEY `id_role` (`id_role`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

TRUNCATE TABLE `login_rights`;

INSERT INTO `login_rights` (`id`, `id_menu`, `id_role`, `view_right`, `add_right`, `modify_right`, `delete_right`, `details_v`, `details_a`, `details_m`, `details_d`) VALUES
(1, 2, 1, 'Y', 'Y', 'Y', 'Y', 'rights', 'rights', 'rights', 'rights'),
(2, 3, 1, 'Y', 'Y', 'Y', 'Y', 'key', 'key', 'key', 'key'),
(3, 3, 1, 'Y', 'N', 'N', 'N', 'key', 'key', 'key', 'key'),
(4, 3, 1, 'Y', 'Y', 'N', 'N', 'key', 'key', 'key', 'key'),
(5, 4, 1, 'Y', 'Y', 'Y', 'Y', '', '', '', ''),
(6, 5, 1, 'Y', 'Y', 'Y', 'Y', '', '', '', ''),
(7, 7, 1, 'Y', 'Y', 'Y', 'Y', 'details', 'details', 'details', 'details');

DROP TABLE IF EXISTS `login_roles`;

CREATE TABLE IF NOT EXISTS `login_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

TRUNCATE TABLE `login_roles`;

INSERT INTO `login_roles` (`id`, `rolename`) VALUES
(1, 'Developer - Full access');

DROP TABLE IF EXISTS `login_shortcuts`;

CREATE TABLE IF NOT EXISTS `login_shortcuts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `denumire` varchar(100) NOT NULL,
  `fontawesome` varchar(50) NOT NULL,
  `backcolor` varchar(7) NOT NULL,
  `textcolor` varchar(7) NOT NULL,
  `bordercolor` varchar(7) NOT NULL,
  `link` varchar(100) NOT NULL,
  `ordine` int(11) NOT NULL,
  `public` varchar(1) NOT NULL DEFAULT 'Y',
  `newtab` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `login_users`;

CREATE TABLE IF NOT EXISTS `login_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(32) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `nume` varchar(200) NOT NULL,
  `role` int(11) NOT NULL,
  `cnp` varchar(20) NOT NULL,
  `ci` varchar(10) NOT NULL,
  `telefon` varchar(40) NOT NULL,
  `fax` varchar(40) NOT NULL,
  `email` varchar(150) NOT NULL,
  `functie` varchar(250) NOT NULL,
  `details` text NOT NULL,
  `mobil` varchar(30) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `yahooid` varchar(100) NOT NULL,
  `id_firma` int(11) NOT NULL,
  `logtime` datetime NOT NULL,
  `chattime` datetime NOT NULL,
  `chatroomtime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role`),
  KEY `id_firma` (`id_firma`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

TRUNCATE TABLE `login_users`;

INSERT INTO `login_users` (`id`, `user`, `pass`, `nume`, `role`, `cnp`, `ci`, `telefon`, `fax`, `email`, `functie`, `details`, `mobil`, `sex`, `yahooid`, `id_firma`, `logtime`, `chattime`, `chatroomtime`) VALUES
(1, '[[USER]]', '[[PASS]]', '[[USER]]', 1, '', '', '', '', '', '', '', '', 'M', '', 2, now(), now(), now());

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