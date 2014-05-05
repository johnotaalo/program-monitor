CREATE TABLE `commodity_outage_options` (
  `coo_id` int(11) NOT NULL AUTO_INCREMENT,
  `coo_description` varchar(255) NOT NULL,
  PRIMARY KEY (`coo_id`),
  UNIQUE KEY `optionDescription` (`coo_description`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1