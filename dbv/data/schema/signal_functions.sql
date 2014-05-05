CREATE TABLE `signal_functions` (
  `sf_id` int(11) NOT NULL AUTO_INCREMENT,
  `sf_code` varchar(15) NOT NULL,
  `sf_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`sf_id`),
  UNIQUE KEY `idSignal_Functions` (`sf_id`),
  UNIQUE KEY `signalCode` (`sf_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1