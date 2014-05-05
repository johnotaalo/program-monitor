CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_code` varchar(11) NOT NULL,
  `supplier_name` varchar(45) DEFAULT NULL,
  `supplier_for` varchar(3) NOT NULL,
  PRIMARY KEY (`supplier_id`),
  KEY `supplierCode` (`supplier_code`),
  KEY `supplierName` (`supplier_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1