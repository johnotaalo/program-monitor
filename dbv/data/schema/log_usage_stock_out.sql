CREATE TABLE `log_usage_stock_out` (
  `luso_id` int(11) NOT NULL AUTO_INCREMENT,
  `losu_usage` int(11) NOT NULL,
  `losu_unavailable_times` varchar(55) NOT NULL,
  `comm_code` varchar(11) NOT NULL,
  `fac_mfl` varchar(55) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`luso_id`),
  KEY `commodityID` (`comm_code`),
  KEY `facilityID` (`fac_mfl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1