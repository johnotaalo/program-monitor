CREATE TABLE `supplies_outage_options` (
  `soo_id` int(11) NOT NULL AUTO_INCREMENT,
  `soo_description` varchar(255) NOT NULL,
  PRIMARY KEY (`soo_id`),
  UNIQUE KEY `optionDescription` (`soo_description`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1