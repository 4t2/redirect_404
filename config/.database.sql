-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


-- --------------------------------------------------------


-- 
-- Table `tl_content`
-- 

CREATE TABLE `tl_page_history` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `alias` varbinary(128) NOT NULL default '',
  `language` varchar(5) NOT NULL default '',
  `dns` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `alias` (`alias`),
  KEY `all` (`alias`, `language`, `dns`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
