CREATE TABLE `available_resources` (
  `ar_id` int(11) NOT NULL AUTO_INCREMENT,
  `ar_availability` varchar(45) NOT NULL DEFAULT 'n/a',
  `ar_location` varchar(255) NOT NULL DEFAULT 'n/a',
  `ar_quantity` int(11) NOT NULL DEFAULT '-1',
  `ar_reason_unavailable` varchar(45) NOT NULL DEFAULT 'n/a',
  `equipment_code` varchar(11) NOT NULL,
  `supplier_code` varchar(55) NOT NULL,
  `ar_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fac_mfl` varchar(11) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ar_id`),
  KEY `CommodityID` (`equipment_code`),
  KEY `SupplierID` (`supplier_code`),
  KEY `facilityID` (`fac_mfl`),
  KEY `SuppliesCode` (`equipment_code`,`supplier_code`,`fac_mfl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1