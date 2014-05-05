CREATE TABLE `log_commodity_stock_outs` (
  `lcso_id` int(11) NOT NULL AUTO_INCREMENT,
  `lcso_usage` int(11) NOT NULL DEFAULT '-1',
  `lcso_unavailable_times` varchar(55) NOT NULL DEFAULT 'n/a',
  `lcso_option_on_outage` varchar(25) DEFAULT 'n/a',
  `lcso_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comm_id` varchar(11) NOT NULL,
  `fac_id` varchar(55) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`lcso_id`),
  KEY `facilityID` (`fac_id`),
  KEY `commodityID` (`comm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1