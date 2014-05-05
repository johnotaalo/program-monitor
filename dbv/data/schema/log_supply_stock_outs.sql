CREATE TABLE `log_supply_stock_outs` (
  `lsso_id` int(11) NOT NULL AUTO_INCREMENT,
  `lsso_usage` int(11) NOT NULL DEFAULT '-1',
  `lsso_unavailable_times` varchar(55) NOT NULL DEFAULT 'n/a',
  `lsso_option_on_outage` varchar(25) DEFAULT 'n/a',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supply_code` varchar(11) NOT NULL,
  `fac_mfl` varchar(55) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`lsso_id`),
  KEY `facilityID` (`fac_mfl`),
  KEY `commodityID` (`supply_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1