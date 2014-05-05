CREATE TABLE `bemonc_functions` (
  `bem_id` int(11) NOT NULL AUTO_INCREMENT,
  `bem_conducted` varchar(45) DEFAULT NULL,
  `bem_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `challenge_code` varchar(45) NOT NULL,
  `sf_code` varchar(11) NOT NULL,
  `fac_id` varchar(11) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`bem_id`),
  KEY `Challenges_id` (`bem_id`),
  KEY `signal_FunctionsID` (`sf_code`),
  KEY `facilityID` (`fac_id`),
  KEY `facilityID_2` (`fac_id`),
  KEY `bemonc_functions_ibfk_9_idx` (`challenge_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1