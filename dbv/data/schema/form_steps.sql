CREATE TABLE `form_steps` (
  `fs_id` int(11) NOT NULL AUTO_INCREMENT,
  `fs_name` varchar(45) NOT NULL,
  PRIMARY KEY (`fs_id`),
  UNIQUE KEY `stepName_2` (`fs_name`),
  KEY `stepName` (`fs_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1