CREATE TABLE `indicators` (
  `indicator_id` int(11) NOT NULL AUTO_INCREMENT,
  `indicator_name` text,
  `indicator_created` timestamp NULL DEFAULT NULL,
  `indicator_creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`indicator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1