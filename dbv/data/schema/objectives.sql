CREATE TABLE `objectives` (
  `objective_id` int(11) NOT NULL AUTO_INCREMENT,
  `objective_name` text,
  `objective_created` timestamp NULL DEFAULT NULL,
  `objectives_creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`objective_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1