DROP TABLE IF EXISTS `login_agenda`;
CREATE TABLE IF NOT EXISTS `login_agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `data` date NOT NULL DEFAULT current_timestamp(),
  `ora` int(11) NOT NULL DEFAULT 0,
  `subiect` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `descriere` text CHARACTER SET utf8 NOT NULL DEFAULT '',
  `durata` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE TABLE `login_menu`;
INSERT INTO `login_menu` (`id`, `id_tata`, `denum`, `link`, `ordine`, `right`, `icon`) VALUES
(10, 0, 'ROOT', '#', 0, 'Y', ''),
(1, 0, 'Setari', '', 1, 'N', 'setari'),
(2, 1, 'Profiluri', 'roluri', 20, 'N', 'pofile'),
(3, 1, 'Utilizatori', 'utilizatori', 10, 'N', 'user'),
(4, 1, 'Dashboard', 'dashboard', 30, 'N', 'empty'),
(5, 1, 'Scurtaturi', 'shortcuts', 40, 'N', 'empty'),
(6, 1, '-', '', 25, 'Y', 'empty'),
(7, 1, 'Agenda', 'agenda', 50, 'N', 'empty');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

UPDATE `login_menu` SET id=0 WHERE id=10;
ALTER TABLE `login_menu` auto_increment = 1;

CREATE TABLE `login_pages` (
  `id` int(11) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `ordine` int(11) NOT NULL,
  `public` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `login_pages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `login_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


INSERT INTO `login_pages` (`id`, `slug`, `title`, `content`, `ordine`, `public`) VALUES
(1, 'index', '&nbsp;', '<div class=\"container\">\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n  <tbody><tr>\r\n	<td width=\"212\"><a href=\"./\"><img src=\"images/auto1.jpg\"></a></td>\r\n    \r\n    <td style=\"background-image:url(images/auto2.jpg); background-repeat:no-repeat; background-position:right\">\r\n    	<h1>IAdmin - Interfata pentu Soft complet</h1>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n[[content]]\r\n</div>\r\n', 1, 'B'),
(2, 'login', '&nbsp;', '<div class=\"row\">\r\n<div class=\"col col-8\">\r\n<p data-start=\"33\" data-end=\"69\"><strong data-start=\"33\" data-end=\"67\">Welcome to the Admin Interface</strong></p>\r\n<p data-start=\"71\" data-end=\"334\">Take full control with ease! This admin interface is designed to help you manage, monitor, and optimize every aspect of your system. Whether you\'re overseeing user accounts, content, settings, or performance data — everything you need is just a few clicks away.</p>\r\n<p data-start=\"336\" data-end=\"359\">Key features include:</p>\r\n<ul data-start=\"360\" data-end=\"701\">\r\n<li data-start=\"360\" data-end=\"428\"><strong data-start=\"362\" data-end=\"387\">Intuitive Navigation:</strong> Easily access and adjust key settings.</li>\r\n<li data-start=\"429\" data-end=\"522\"><strong data-start=\"431\" data-end=\"453\">Powerful Controls:</strong> Manage users, content, permissions, and configurations seamlessly.</li>\r\n<li data-start=\"523\" data-end=\"615\"><strong data-start=\"525\" data-end=\"548\">Real-Time Insights:</strong> Get instant data on system performance, user activity, and more.</li>\r\n<li data-start=\"616\" data-end=\"701\"><strong data-start=\"618\" data-end=\"640\">Secure &amp; Reliable:</strong> Built-in safeguards ensure your operations stay protected.</li>\r\n</ul>\r\n<p data-start=\"703\" data-end=\"782\">Ready to dive in? Let’s make management simpler and more efficient than ever!</p>\r\n</div>\r\n<div class=\"col col-4\">\r\n<div class=\"card\">\r\n    <div class=\"card-body\">      \r\n[LOGINFORM]\r\n</div>\r\n</div>\r\n</div>', 3, 'Y'),
(3, 'loginform', '', '<form class=\"form-signin text-center\" method=\"post\" action=\"./\">\r\n        <h1 class=\"h3 mb-3 font-weight-normal\">[sign_in_title]</h1>\r\n        <label for=\"log_user\" class=\"sr-only\">[sign_in_username] ?></label>\r\n        <input type=\"text\" id=\"log_user\" name=\"log_user\" class=\"form-control\" placeholder=\"[sign_in_username]\" required autofocus>\r\n        <br>\r\n        <label for=\"inputPassword\" class=\"sr-only\">[sign_in_password]</label>\r\n        <input type=\"password\" id=\"log_pass\" name=\"log_pass\" class=\"form-control\" placeholder=\"[sign_in_password]\" required>\r\n        <br>\r\n        [sign_in_message]\r\n        <button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">[sign_in_button]</button>\r\n<a href=\"./recover.htm\">[sign_in_recover]</a>\r\n</form>', 0, 'B'),
(4, 'recover', 'recover', '<div class=\"row\">\r\n<div class=\"col col-2\">&nbsp;</div>\r\n<div class=\"col col-8\">\r\n<p data-start=\"52\" data-end=\"341\"><strong data-start=\"52\" data-end=\"77\">Forgot your password?</strong> No problem! Enter your email address below, and we’ll send you a link to reset your password — but make sure you use the email associated with your account. If your email isn’t recognized or you’re having trouble, please contact an administrator for assistance.</p>\r\n\r\n<form class=\"form-signin text-center\" method=\"post\" action=\"./\">\r\n<div class=\"input-group mb-3\">\r\n        <input type=\"text\" id=\"recover_email\" name=\"recover_email\" class=\"form-control\" placeholder=\"[recover_email]\" required autofocus>\r\n<div class=\"input-group-append\">\r\n        <button class=\"btn btn-lg btn-primary btn-block btn-sm\" type=\"submit\">[recover_button]</button>\r\n</div></div>\r\n</form>\r\n</div></div>', 0, 'Y');
