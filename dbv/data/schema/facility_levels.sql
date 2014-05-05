CREATE TABLE `facility_levels` (
  `fl_id` int(11) NOT NULL AUTO_INCREMENT,
  `fl_name` varchar(45) NOT NULL,
  PRIMARY KEY (`fl_id`),
  UNIQUE KEY `facilityLevel_UNIQUE` (`fl_name`),
  KEY `facilityLevel` (`fl_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1