CREATE TABLE `counties` (
  `county_id` int(11) NOT NULL AUTO_INCREMENT,
  `county_name` varchar(45) NOT NULL,
  `county_fusion_map_id` int(2) NOT NULL,
  PRIMARY KEY (`county_id`),
  UNIQUE KEY `countyName_UNIQUE` (`county_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1