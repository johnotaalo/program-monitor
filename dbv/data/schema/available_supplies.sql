CREATE TABLE `available_supplies` (
  `as_id` int(11) NOT NULL AUTO_INCREMENT,
  `as_availability` varchar(45) NOT NULL DEFAULT 'n/a',
  `as_location` varchar(255) NOT NULL DEFAULT 'n/a',
  `as_quantity` int(11) DEFAULT '-1',
  `as_reason_unavailable` varchar(45) DEFAULT 'n/a',
  `as_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplies_code` varchar(11) NOT NULL,
  `supplier_code` varchar(55) NOT NULL,
  `fac_mfl` varchar(11) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`as_id`),
  KEY `CommodityID` (`supplies_code`),
  KEY `SupplierID` (`supplier_code`),
  KEY `facilityID` (`fac_mfl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1