CREATE TABLE `speaker` (
  `id` int(11) NOT NULL auto_increment,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `title` varchar(255) default NULL,
  `biography` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
