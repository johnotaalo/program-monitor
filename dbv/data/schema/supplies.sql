CREATE TABLE `supplies` (
  `supply_id` int(11) NOT NULL AUTO_INCREMENT,
  `supply_code` varchar(15) NOT NULL,
  `supply_name` varchar(150) NOT NULL,
  `supply_unit` varchar(100) NOT NULL,
  `supply_for` varchar(3) NOT NULL,
  PRIMARY KEY (`supply_id`),
  KEY `suppliesCode` (`supply_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1