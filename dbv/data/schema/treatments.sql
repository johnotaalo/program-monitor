CREATE TABLE `treatments` (
  `treatment_id` int(11) NOT NULL AUTO_INCREMENT,
  `treatment_name` varchar(255) NOT NULL,
  `treatment_code` varchar(6) NOT NULL,
  `treatment_for` varchar(3) NOT NULL COMMENT 'dia-diarrhoea',
  PRIMARY KEY (`treatment_id`),
  UNIQUE KEY `indicatorName` (`treatment_name`),
  UNIQUE KEY `indicatorCode` (`treatment_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1