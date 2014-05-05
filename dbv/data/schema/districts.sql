CREATE TABLE `districts` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `district_name` varchar(45) NOT NULL,
  `district_access_code` varchar(255) NOT NULL,
  PRIMARY KEY (`district_id`),
  UNIQUE KEY `districtName_UNIQUE` (`district_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1