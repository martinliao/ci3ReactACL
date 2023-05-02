
#
# TABLE STRUCTURE FOR: user_menu
#

DROP TABLE IF EXISTS `user_menu`;

CREATE TABLE `user_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `is_active` int(11) NOT NULL,
  `no_order` int(11) NOT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO `user_menu` (`id_menu`, `title`, `icon`, `is_active`, `no_order`) VALUES (1, 'Admin Menu', 'fa fa-laptop', 1, 2);
INSERT INTO `user_menu` (`id_menu`, `title`, `icon`, `is_active`, `no_order`) VALUES (6, 'Dashboard', 'fa fa-fw fa fa-tachometer', 1, 1);
INSERT INTO `user_menu` (`id_menu`, `title`, `icon`, `is_active`, `no_order`) VALUES (9, 'Settings', 'fa fa-fw fa fa-cogs', 1, 3);
INSERT INTO `user_menu` (`id_menu`, `title`, `icon`, `is_active`, `no_order`) VALUES (10, 'Master Data', 'fa fa-fw fa fa-database', 1, 4);
INSERT INTO `user_menu` (`id_menu`, `title`, `icon`, `is_active`, `no_order`) VALUES (11, 'Shortener Link', 'fa fa-fw fa fa-calendar-plus-o', 1, 5);

#
# TABLE STRUCTURE FOR: user_access
#

DROP TABLE IF EXISTS `user_access`;

CREATE TABLE `user_access` (
  `id_access` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id_access`),
  KEY `fk_a_role` (`id_role`),
  KEY `fk_a_menu` (`id_menu`),
  CONSTRAINT `fk_a_menu` FOREIGN KEY (`id_menu`) REFERENCES `user_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

INSERT INTO `user_access` (`id_access`, `id_menu`, `id_role`) VALUES (1, 1, 1);
INSERT INTO `user_access` (`id_access`, `id_menu`, `id_role`) VALUES (67, 6, 1);
INSERT INTO `user_access` (`id_access`, `id_menu`, `id_role`) VALUES (71, 9, 1);
INSERT INTO `user_access` (`id_access`, `id_menu`, `id_role`) VALUES (75, 10, 1);
INSERT INTO `user_access` (`id_access`, `id_menu`, `id_role`) VALUES (77, 11, 1);

#
# TABLE STRUCTURE FOR: user_submenu
#

DROP TABLE IF EXISTS `user_submenu`;

CREATE TABLE `user_submenu` (
  `id_submenu` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `url` varchar(30) NOT NULL,
  `is_active` int(11) NOT NULL,
  `no_urut` int(11) NOT NULL,
  PRIMARY KEY (`id_submenu`),
  KEY `fk_menu` (`id_menu`),
  CONSTRAINT `fk_menu` FOREIGN KEY (`id_menu`) REFERENCES `user_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

INSERT INTO `user_submenu` (`id_submenu`, `id_menu`, `title`, `icon`, `url`, `is_active`, `no_urut`) VALUES (1, 1, 'User Management', 'fa fa-fw fa-users', 'user', 1, 2);
INSERT INTO `user_submenu` (`id_submenu`, `id_menu`, `title`, `icon`, `url`, `is_active`, `no_urut`) VALUES (2, 1, 'Role management', 'fa fa-fw fa-cogs', 'role', 1, 1);
INSERT INTO `user_submenu` (`id_submenu`, `id_menu`, `title`, `icon`, `url`, `is_active`, `no_urut`) VALUES (3, 1, 'Menu Management', 'fa fa-fw fa-code', 'menu', 1, 3);
INSERT INTO `user_submenu` (`id_submenu`, `id_menu`, `title`, `icon`, `url`, `is_active`, `no_urut`) VALUES (6, 1, 'Access Management', 'fa fa-fw fa-lock', 'access', 1, 4);
INSERT INTO `user_submenu` (`id_submenu`, `id_menu`, `title`, `icon`, `url`, `is_active`, `no_urut`) VALUES (12, 6, 'Dashboard', 'fa fa-fw fa-tachometer', 'admin/dashboard', 1, 1);
INSERT INTO `user_submenu` (`id_submenu`, `id_menu`, `title`, `icon`, `url`, `is_active`, `no_urut`) VALUES (38, 9, 'Site Setting', 'fa fa-fw fa-map', 'settings', 1, 1);
INSERT INTO `user_submenu` (`id_submenu`, `id_menu`, `title`, `icon`, `url`, `is_active`, `no_urut`) VALUES (42, 10, 'Data Divisi', 'fa fa-folder', 'divisi', 1, 2);
INSERT INTO `user_submenu` (`id_submenu`, `id_menu`, `title`, `icon`, `url`, `is_active`, `no_urut`) VALUES (44, 9, 'Backup &amp; Restore', 'fa fa-database', 'database', 1, 2);
INSERT INTO `user_submenu` (`id_submenu`, `id_menu`, `title`, `icon`, `url`, `is_active`, `no_urut`) VALUES (45, 11, 'Short Link', 'fa fa-tachometer', 'url', 1, 1);
