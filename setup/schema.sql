-- iAdmin database schema, imported by setup/index.php (MySQL 5.7+ / MariaDB 10.3+).
--
-- Placeholders replaced by setup with SQL-escaped values from the setup form:
--   [[USER]]  admin login name      [[PASS]]  admin password (password_hash)
--   [[NAME]]  admin full name       [[EMAIL]] admin e-mail (used for password recovery)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET NAMES utf8mb4;

CREATE TABLE `login__agenda` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL DEFAULT 0,
  `data` date DEFAULT NULL,
  `ora` int NOT NULL DEFAULT 0,
  `subiect` varchar(250) NOT NULL DEFAULT '',
  `descriere` text,
  `durata` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `data` (`data`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `login__chat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL DEFAULT 0,
  `id_from` int NOT NULL DEFAULT 0,
  `mesaj` varchar(255) NOT NULL DEFAULT '',
  `citit` varchar(1) NOT NULL DEFAULT 'N',
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_from` (`id_from`),
  KEY `data` (`data`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `login__dashboard` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL DEFAULT 0,
  `ordine` int NOT NULL DEFAULT 0,
  `rand` int NOT NULL DEFAULT 1,
  `marimesm` int NOT NULL DEFAULT 6,
  `marimelg` int NOT NULL DEFAULT 6,
  `denumire` varchar(250) NOT NULL DEFAULT '',
  `fisier` varchar(100) NOT NULL DEFAULT '',
  `deschis` varchar(1) NOT NULL DEFAULT 'Y',
  `vizibil` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- dashboard panels of the admin user (id 1)
INSERT INTO `login__dashboard` (`id`, `id_user`, `ordine`, `rand`, `marimesm`, `marimelg`, `denumire`, `fisier`, `deschis`, `vizibil`) VALUES
(1, 1, 1, 1, 6, 5, 'Calendar', 'calendar', 'Y', 'Y'),
(2, 1, 3, 2, 12, 12, 'Bookmarks', 'shortcuts', 'Y', 'Y'),
(3, 1, 2, 1, 6, 7, 'Agenda', 'agenda', 'Y', 'Y');

CREATE TABLE `login__help` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titlu` varchar(250) NOT NULL DEFAULT '',
  `continut` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `login__menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_tata` int NOT NULL DEFAULT 0,
  `denum` varchar(100) NOT NULL DEFAULT '',
  `link` varchar(100) NOT NULL DEFAULT '',
  `ordine` int NOT NULL DEFAULT 0,
  `right` varchar(1) NOT NULL DEFAULT 'N',
  `icon` varchar(100) NOT NULL DEFAULT 'empty',
  PRIMARY KEY (`id`),
  KEY `id_tata` (`id_tata`),
  KEY `ordine` (`ordine`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- id 0 is the menu ROOT (stays 0 thanks to NO_AUTO_VALUE_ON_ZERO); links are module names
INSERT INTO `login__menu` (`id`, `id_tata`, `denum`, `link`, `ordine`, `right`, `icon`) VALUES
(0, 0, 'ROOT', '#', 0, 'Y', ''),
(1, 0, 'Setari', '', 1, 'N', 'setari'),
(2, 1, 'Profiluri', 'roluri', 20, 'N', 'gg-circle'),
(3, 1, 'Utilizatori', 'utilizatori', 10, 'N', 'user-circle'),
(4, 1, 'Dashboard', 'dashboard', 30, 'N', 'clipboard-list'),
(5, 1, 'Scurtaturi', 'shortcuts', 40, 'N', 'external-link-alt'),
(6, 1, '-', '', 25, 'Y', 'empty'),
(7, 1, 'Agenda', 'agenda', 50, 'N', 'empty'),
(8, 1, 'Meniu', 'loginmenu', 60, 'N', 'sitemap');

CREATE TABLE `login__pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(250) NOT NULL DEFAULT '',
  `title` varchar(250) NOT NULL DEFAULT '',
  `content` mediumtext,
  `ordine` int NOT NULL DEFAULT 0,
  `public` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- public pages: 'index' (B) wraps every public page, 'loginform' (B) replaces [LOGINFORM]
INSERT INTO `login__pages` (`id`, `slug`, `title`, `content`, `ordine`, `public`) VALUES
(1, 'index', '&nbsp;', '<div class=\"container\">\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n  <tbody><tr>\r\n	<td width=\"440\"><a href=\"./\"><img src=\"images/logo.jpg\" style=\"margin-top:10px;\"></a></td>\r\n    \r\n    <td>\r\n    	<h1>Interfata pentu Soft complet</h1>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n[[content]]\r\n</div>\r\n', 1, 'B'),
(2, 'login', '&nbsp;', '<div class=\"row\">\r\n<div class=\"col col-8\">\r\n<p data-start=\"33\" data-end=\"69\"><strong data-start=\"33\" data-end=\"67\">Welcome to the Admin Interface</strong></p>\r\n<p data-start=\"71\" data-end=\"334\">Take full control with ease! This admin interface is designed to help you manage, monitor, and optimize every aspect of your system. Whether you\'re overseeing user accounts, content, settings, or performance data — everything you need is just a few clicks away.</p>\r\n<p data-start=\"336\" data-end=\"359\">Key features include:</p>\r\n<ul data-start=\"360\" data-end=\"701\">\r\n<li data-start=\"360\" data-end=\"428\"><strong data-start=\"362\" data-end=\"387\">Intuitive Navigation:</strong> Easily access and adjust key settings.</li>\r\n<li data-start=\"429\" data-end=\"522\"><strong data-start=\"431\" data-end=\"453\">Powerful Controls:</strong> Manage users, content, permissions, and configurations seamlessly.</li>\r\n<li data-start=\"523\" data-end=\"615\"><strong data-start=\"525\" data-end=\"548\">Real-Time Insights:</strong> Get instant data on system performance, user activity, and more.</li>\r\n<li data-start=\"616\" data-end=\"701\"><strong data-start=\"618\" data-end=\"640\">Secure &amp; Reliable:</strong> Built-in safeguards ensure your operations stay protected.</li>\r\n</ul>\r\n<p data-start=\"703\" data-end=\"782\">Ready to dive in? Let’s make management simpler and more efficient than ever!</p>\r\n</div>\r\n<div class=\"col col-4\">\r\n<div class=\"card bkg-storm-gray\">\r\n    <div class=\"card-body\">      \r\n[LOGINFORM]\r\n</div>\r\n</div>\r\n</div>', 3, 'Y'),
(3, 'loginform', '', '<form class=\"form-signin text-center\" method=\"post\" action=\"./\">\r\n        <h1 class=\"h3 mb-3 font-weight-normal\">[sign_in_title]</h1>\r\n\r\n	<div class=\"form-floating mb-3\">\r\n		<input type=\"text\" id=\"log_user\" name=\"log_user\" class=\"form-control bkg-burned-eggplant txt-river\" placeholder=\"[sign_in_username]\" required autofocus>\r\n		<label for=\"floatingInput\" class=\"txt-lilac\">[sign_in_username]</label>\r\n	</div>\r\n\r\n	<div class=\"form-floating mb-3\">\r\n		<input type=\"password\" id=\"log_pass\" name=\"log_pass\" class=\"form-control bkg-burned-eggplant txt-river\" placeholder=\"[sign_in_password]\" required>\r\n		<label for=\"floatingInput\" class=\"txt-lilac\">[sign_in_password]</label>\r\n	</div>\r\n\r\n        [sign_in_message]\r\n        <button class=\"btn btn-lg btn-primary float-end\" type=\"submit\">[sign_in_button]</button>\r\n        <a class=\"float-start txt-lilac\" href=\"./recover.htm\">[sign_in_recover]</a>\r\n</form>', 0, 'B'),
(4, 'recover', 'recover', '<div class=\"row\">\r\n<div class=\"col col-2\">&nbsp;</div>\r\n<div class=\"col col-8\">\r\n<p data-start=\"52\" data-end=\"341\"><strong data-start=\"52\" data-end=\"77\">Forgot your password?</strong> No problem! Enter your email address below, and we’ll send you a link to reset your password — but make sure you use the email associated with your account. If your email isn’t recognized or you’re having trouble, please contact an administrator for assistance.</p>\r\n\r\n<form class=\"form-signin text-center\" method=\"post\" action=\"./\">\r\n<div class=\"input-group mb-3\">\r\n        <input type=\"text\" id=\"recover_email\" name=\"recover_email\" class=\"form-control\" placeholder=\"[recover_email]\" required autofocus>\r\n<div class=\"input-group-append\">\r\n        <button class=\"btn btn-lg btn-primary btn-block btn-sm\" type=\"submit\">[recover_button]</button>\r\n</div></div>\r\n</form>\r\n</div></div>', 0, 'Y');

CREATE TABLE `login__rights` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_menu` int NOT NULL DEFAULT 0,
  `id_role` int NOT NULL DEFAULT 0,
  `view_right` varchar(1) NOT NULL DEFAULT 'N',
  `add_right` varchar(1) NOT NULL DEFAULT 'N',
  `modify_right` varchar(1) NOT NULL DEFAULT 'N',
  `delete_right` varchar(1) NOT NULL DEFAULT 'N',
  `details_v` varchar(250) NOT NULL DEFAULT '',
  `details_a` varchar(250) NOT NULL DEFAULT '',
  `details_m` varchar(250) NOT NULL DEFAULT '',
  `details_d` varchar(250) NOT NULL DEFAULT '',
  `details_e` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `menu_role` (`id_menu`, `id_role`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- full rights for role 1 (Developer) on every module of the default menu
INSERT INTO `login__rights` (`id`, `id_menu`, `id_role`, `view_right`, `add_right`, `modify_right`, `delete_right`, `details_v`, `details_a`, `details_m`, `details_d`, `details_e`) VALUES
(1, 2, 1, 'Y', 'Y', 'Y', 'Y', 'rights', 'rights', 'rights', 'rights', ''),
(2, 3, 1, 'Y', 'Y', 'Y', 'Y', 'key', 'key', 'key', 'key', ''),
(3, 4, 1, 'Y', 'Y', 'Y', 'Y', '', '', '', '', ''),
(4, 5, 1, 'Y', 'Y', 'Y', 'Y', '', '', '', '', ''),
(5, 7, 1, 'Y', 'Y', 'Y', 'Y', 'details', 'details', 'details', 'details', ''),
(6, 8, 1, 'Y', 'Y', 'Y', 'Y', '', '', '', '', '');

CREATE TABLE `login__roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rolename` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `login__roles` (`id`, `rolename`) VALUES
(1, 'Developer - Full access');

-- dashboard shortcuts: two stacked Font Awesome icons, colors are names from css/colors.css
CREATE TABLE `login__shortcuts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL DEFAULT 0,
  `id_role` int NOT NULL DEFAULT 0,
  `denumire` varchar(100) NOT NULL DEFAULT '',
  `fa1` varchar(100) NOT NULL DEFAULT '',
  `fa2` varchar(100) NOT NULL DEFAULT '',
  `fa1type` varchar(50) NOT NULL DEFAULT 's',
  `fa2type` varchar(50) NOT NULL DEFAULT 's mx-3 my-2',
  `fa1color` varchar(20) NOT NULL DEFAULT '',
  `fa2color` varchar(20) NOT NULL DEFAULT '',
  `fa1shadow` varchar(20) NOT NULL DEFAULT '',
  `fa2shadow` varchar(20) NOT NULL DEFAULT '',
  `backcolor` varchar(20) NOT NULL DEFAULT '',
  `textcolor` varchar(20) NOT NULL DEFAULT '',
  `bordercolor` varchar(20) NOT NULL DEFAULT '',
  `extraclass` varchar(200) NOT NULL DEFAULT '',
  `link` varchar(100) NOT NULL DEFAULT '',
  `ordine` int NOT NULL DEFAULT 0,
  `public` varchar(1) NOT NULL DEFAULT 'Y',
  `newtab` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `login__users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(32) NOT NULL DEFAULT '',
  `pass` varchar(255) NOT NULL DEFAULT '',
  `nume` varchar(200) NOT NULL DEFAULT '',
  `role` int NOT NULL DEFAULT 0,
  `cnp` varchar(20) NOT NULL DEFAULT '',
  `ci` varchar(10) NOT NULL DEFAULT '',
  `telefon` varchar(40) NOT NULL DEFAULT '',
  `fax` varchar(40) NOT NULL DEFAULT '',
  `email` varchar(150) NOT NULL DEFAULT '',
  `functie` varchar(250) NOT NULL DEFAULT '',
  `details` text,
  `mobil` varchar(30) NOT NULL DEFAULT '',
  `sex` varchar(1) NOT NULL DEFAULT '',
  `yahooid` varchar(100) NOT NULL DEFAULT '',
  `id_firma` int NOT NULL DEFAULT 0,
  `logtime` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `chattime` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `chatroomtime` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`),
  KEY `role` (`role`),
  KEY `id_firma` (`id_firma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- the administrator entered in the setup form (role 1 = Developer)
INSERT INTO `login__users` (`id`, `user`, `pass`, `nume`, `role`, `email`, `details`) VALUES
(1, '[[USER]]', '[[PASS]]', '[[NAME]]', 1, '[[EMAIL]]', '');
