CREATE TABLE `commodities` (
  `comm_id` int(11) NOT NULL AUTO_INCREMENT,
  `comm_code` varchar(15) NOT NULL,
  `comm_name` varchar(45) NOT NULL,
  `comm_unit` varchar(45) DEFAULT NULL,
  `comm_for` varchar(3) NOT NULL COMMENT 'mnh or mch',
  PRIMARY KEY (`comm_id`),
  UNIQUE KEY `idCommodity` (`comm_id`),
  UNIQUE KEY `commodityCode` (`comm_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1