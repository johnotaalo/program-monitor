CREATE TABLE `community_strategies` (
  `cs_id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_response` int(11) NOT NULL DEFAULT '-1',
  `cs_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `strat_id` varchar(45) NOT NULL,
  `fac_ID` varchar(11) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cs_id`),
  KEY `facilityID` (`fac_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1