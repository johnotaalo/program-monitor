CREATE TABLE `deliveries` (
  `del_id` int(11) NOT NULL AUTO_INCREMENT,
  `del_value` int(11) DEFAULT NULL,
  `del_month_year` int(11) DEFAULT NULL,
  `del_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fac_mfl` varchar(11) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`del_id`),
  KEY `facilityID` (`fac_mfl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1