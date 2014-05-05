CREATE TABLE `facility_types` (
  `ft_id` int(11) NOT NULL AUTO_INCREMENT,
  `ft_name` varchar(55) NOT NULL,
  PRIMARY KEY (`ft_id`),
  UNIQUE KEY `facilityType_UNIQUE` (`ft_name`),
  KEY `facilityType` (`ft_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1