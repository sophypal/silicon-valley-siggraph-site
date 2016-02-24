CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `first_name` varchar(32) default NULL,
  `last_name` varchar(32) default NULL,
  `email` varchar(64) default NULL,
  `password` char(40) default NULL,
  `username` varchar(32) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1
