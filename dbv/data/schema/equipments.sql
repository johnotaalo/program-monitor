CREATE TABLE `equipments` (
  `eq_id` int(11) NOT NULL AUTO_INCREMENT,
  `eq_code` varchar(11) NOT NULL,
  `eq_name` varchar(100) NOT NULL,
  `eq_unit` varchar(22) NOT NULL,
  `eq_for` varchar(3) NOT NULL,
  PRIMARY KEY (`eq_id`),
  KEY `equipmentCode` (`eq_code`,`eq_name`),
  KEY `equipmentCode_2` (`eq_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1