CREATE TABLE `news` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `create_date` int(11) NOT NULL,
  `excerpt` text,
  `article` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `photo_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1
