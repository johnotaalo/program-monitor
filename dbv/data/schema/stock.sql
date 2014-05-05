CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_quantity` int(11) NOT NULL,
  `stock_expiry_date` date NOT NULL,
  `stock_comments` varchar(255) DEFAULT NULL,
  `stock_place_found` varchar(45) DEFAULT NULL COMMENT 'e.g OPD, PEDS, etc',
  `stock_created` timestamp NULL DEFAULT NULL,
  `stock_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comm_code` varchar(45) NOT NULL,
  `fac_mfl` varchar(45) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`stock_id`),
  KEY `fk_stock_commodity` (`comm_code`),
  KEY `fk_stock_facility1` (`fac_mfl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1