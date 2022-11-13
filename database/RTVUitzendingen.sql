

-- 
-- Table structure for table `rtvuitzendingen_admin_menu`
-- 

CREATE TABLE `rtvuitzendingen_admin_menu` (
  `module` varchar(100) default '',
  `position` smallint(3) unsigned NOT NULL default '0',
  `name` varchar(30) default NULL,
  `uri` varchar(100) default NULL,
  `description` varchar(100) default NULL,
  `showItem` tinyint(1) NOT NULL default '1'
);

-- 
-- Dumping data for table `rtvuitzendingen_admin_menu`
-- 

INSERT INTO `rtvuitzendingen_admin_menu` VALUES ('programmering', 10, 'Programmering', NULL, NULL, 1);
INSERT INTO `rtvuitzendingen_admin_menu` VALUES ('programmering', 12, 'Aanpassen', '/programs/programming.php', 'Aanpassen van de programmering', 1);
INSERT INTO `rtvuitzendingen_admin_menu` VALUES ('categorys', 14, 'Categorien', '/categorys/programcategorys.php', 'Beheren categorien', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `rtvuitzendingen_admin_users`
-- 

CREATE TABLE `rtvuitzendingen_admin_users` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `lastIP` varchar(16) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `lastLogin` datetime NULL,
  `lockout` int(11) NOT NULL default '0',
  `modules` tinytext NOT NULL,
  `name` varchar(30) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `isadmin` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);

-- 
-- Dumping data for table `rtvuitzendingen_admin_users`
-- 

INSERT INTO `rtvuitzendingen_admin_users` (`id`, `lastIP`, `username`, `password`,  `lockout`, `modules`, `name`, `email`, `isadmin`) VALUES (1, '127.0.0.1', 'admin', '5136b96817648b5b81008f6a984284a7',  0, 'programmering\r\ncategorys', 'admin', 'mijnmailadres@aaaaa.nl', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `rtvuitzendingen_categorys`
-- 

CREATE TABLE `rtvuitzendingen_categorys` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category` varchar(100) NOT NULL default '',
  `color` varchar(10) NOT NULL default '',
  `shortname` varchar(6) NOT NULL default '',
  PRIMARY KEY  (`id`)
);

-- 
-- Dumping data for table `rtvuitzendingen_categorys`
-- 

INSERT INTO `rtvuitzendingen_categorys` (`id`, `category`, `color`, `shortname`) VALUES (1, 'Muziek', '#FFE6C2', 'muziek');
INSERT INTO `rtvuitzendingen_categorys` (`id`, `category`, `color`, `shortname`) VALUES (2, 'Nieuws en informatie', '#FFE6C2', 'nieuws');
INSERT INTO `rtvuitzendingen_categorys` (`id`, `category`, `color`, `shortname`) VALUES (4, 'Sport', '#FFE6C2', 'sport');
INSERT INTO `rtvuitzendingen_categorys` (`id`, `category`, `color`, `shortname`) VALUES (5, 'Kerk', '#FFE6C2', 'kerk');
INSERT INTO `rtvuitzendingen_categorys` (`id`, `category`, `color`, `shortname`) VALUES (6, 'Info', '#FFE6C2', 'info');
INSERT INTO `rtvuitzendingen_categorys` (`id`, `category`, `color`, `shortname`) VALUES (7, 'Kinderen en jeugd', '#FFE6C2', 'jeugd');
INSERT INTO `rtvuitzendingen_categorys` (`id`, `category`, `color`, `shortname`) VALUES (8, 'Algemeen', 'black', 'alg');

-- --------------------------------------------------------

-- 
-- Table structure for table `rtvuitzendingen_main`
-- 

CREATE TABLE `rtvuitzendingen_main` (
  `name` varchar(25) NOT NULL default '',
  `value` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`name`)
) ;

-- 
-- Dumping data for table `rtvuitzendingen_main`
-- 

INSERT INTO `rtvuitzendingen_main` (`name`, `value`) VALUES ('broadcaster', 'Anonymous');
INSERT INTO `rtvuitzendingen_main` (`name`, `value`) VALUES ('copyright', 'RTV Uitzendingen');
INSERT INTO `rtvuitzendingen_main` (`name`, `value`) VALUES ('installDate', '');
INSERT INTO `rtvuitzendingen_main` (`name`, `value`) VALUES ('password_length', '6');
INSERT INTO `rtvuitzendingen_main` (`name`, `value`) VALUES ('url', 'http://localhost/rtvuitzendingen');
INSERT INTO `rtvuitzendingen_main` (`name`, `value`) VALUES ('urlprograms', 'http://');
INSERT INTO `rtvuitzendingen_main` (`name`, `value`) VALUES ('useCategorys', '1');
INSERT INTO `rtvuitzendingen_main` (`name`, `value`) VALUES ('version', '3.7');
INSERT INTO `rtvuitzendingen_main` (`name`, `value`) VALUES ('waitminutes', '30');
INSERT INTO `rtvuitzendingen_main` (`name`, `value`) VALUES ('defaultdistribution', 'html5');
INSERT INTO `rtvuitzendingen_main` (`name`, `value`) VALUES ('mustconfig', '1');
INSERT INTO `rtvuitzendingen_main` (`name`, `value`) VALUES ('updateprogram', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `rtvuitzendingen_programs`
-- 

CREATE TABLE `rtvuitzendingen_programs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `programname` varchar(100) NOT NULL default '',
  `day` tinyint(4) default NULL,
  `starttime` time NOT NULL default '00:00:00',
  `information` text,
  `email` varchar(30) default '',
  `website` varchar(100) default '',
  `adminby_id` int(11) NOT NULL default '0',
  `adminby_when` datetime NULL,
  `category` int(11) NOT NULL default '0',
  `ondemand` int(11) NOT NULL default '0',
  `ondemand_weeks` int(11) NOT NULL default '2',
  `ondemand_startdate` datetime default NULL,
  PRIMARY KEY  (`id`)
) ;

-- 
-- Dumping data for table `rtvuitzendingen_programs`
-- 

INSERT INTO `rtvuitzendingen_programs` (`id`, `programname`, `day`, `starttime`, `information`, `email`, `website`, `adminby_id`, `adminby_when`, `category`, `ondemand`, `ondemand_weeks`, `ondemand_startdate`) VALUES (9, 'Start programmering dag zondag', 0, '00:00:00', '', '', '', 1, '2007-08-25 12:08:00', 1, 0, 2, NULL);
INSERT INTO `rtvuitzendingen_programs` (`id`, `programname`, `day`, `starttime`, `information`, `email`, `website`, `adminby_id`, `adminby_when`, `category`, `ondemand`, `ondemand_weeks`, `ondemand_startdate`) VALUES (12, 'Start programmering dag maandag', 1, '00:00:00', '', '', '', 1, '2007-08-25 12:08:00', 0, 0, 2, NULL);
INSERT INTO `rtvuitzendingen_programs` (`id`, `programname`, `day`, `starttime`, `information`, `email`, `website`, `adminby_id`, `adminby_when`, `category`, `ondemand`, `ondemand_weeks`, `ondemand_startdate`) VALUES (13, 'Start programmering dag dinsdag', 2, '00:00:00', '', '', '', 1, '2007-08-25 12:08:00', 0, 0, 2, NULL);
INSERT INTO `rtvuitzendingen_programs` (`id`, `programname`, `day`, `starttime`, `information`, `email`, `website`, `adminby_id`, `adminby_when`, `category`, `ondemand`, `ondemand_weeks`, `ondemand_startdate`) VALUES (14, 'Start programmering dag woensdag', 3, '00:00:00', '', '', '', 1, '2007-08-25 12:08:00', 0, 0, 2, NULL);
INSERT INTO `rtvuitzendingen_programs` (`id`, `programname`, `day`, `starttime`, `information`, `email`, `website`, `adminby_id`, `adminby_when`, `category`, `ondemand`, `ondemand_weeks`, `ondemand_startdate`) VALUES (15, 'Start programmering dag donderdag', 4, '00:00:00', '', '', '', 1, '2007-08-25 12:08:00', 0, 0, 2, NULL);
INSERT INTO `rtvuitzendingen_programs` (`id`, `programname`, `day`, `starttime`, `information`, `email`, `website`, `adminby_id`, `adminby_when`, `category`, `ondemand`, `ondemand_weeks`, `ondemand_startdate`) VALUES (16, 'Start programmering dag vrijdag', 5, '00:00:00', '', '', '', 1, '2007-08-25 12:08:00', 0, 0, 2, NULL);
INSERT INTO `rtvuitzendingen_programs` (`id`, `programname`, `day`, `starttime`, `information`, `email`, `website`, `adminby_id`, `adminby_when`, `category`, `ondemand`, `ondemand_weeks`, `ondemand_startdate`) VALUES (17, 'Start programmering dag zaterdag', 6, '00:00:00', '', '', '', 1, '2007-08-25 12:08:00', 0, 0, 2, NULL);
