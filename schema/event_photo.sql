CREATE TABLE `event_photo` (
  `event_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  PRIMARY KEY  (`event_id`,`photo_id`),
  KEY `photo_id` (`photo_id`),
  CONSTRAINT `event_photo_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_photo_ibfk_2` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8
