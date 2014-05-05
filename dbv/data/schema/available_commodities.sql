CREATE TABLE `available_commodities` (
  `ac_id` int(11) NOT NULL AUTO_INCREMENT,
  `ac_availability` varchar(45) NOT NULL DEFAULT 'n/a',
  `ac_location` varchar(255) NOT NULL DEFAULT 'n/a',
  `ac_quantity` int(11) NOT NULL DEFAULT '-1',
  `ac_reason_unavailable` varchar(45) NOT NULL DEFAULT 'n/a',
  `ac_expiry_date` varchar(10) NOT NULL DEFAULT 'n/a',
  `ac_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comm_code` varchar(11) NOT NULL,
  `supp_id` varchar(55) NOT NULL,
  `fac_id` varchar(11) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ac_id`),
  KEY `CommodityID` (`comm_code`),
  KEY `SupplierID` (`supp_id`),
  KEY `facilityID` (`fac_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1