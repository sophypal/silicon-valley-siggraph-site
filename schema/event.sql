CREATE TABLE `event` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `start_date` int(11) default NULL,
  `end_date` int(11) default NULL,
  `description` text NOT NULL,
  `place_id` int(11) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `photo_id` int(11) default NULL,
  `excerpt` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `place_id` (`place_id`),
  CONSTRAINT `event_ibfk_2` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1
