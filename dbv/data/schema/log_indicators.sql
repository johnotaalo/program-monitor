CREATE TABLE `log_indicators` (
  `li_id` int(11) NOT NULL AUTO_INCREMENT,
  `li_response` varchar(6) DEFAULT NULL,
  `li_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `indicator_code` varchar(8) NOT NULL,
  `fac_id` varchar(11) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`li_id`),
  KEY `Challenges_id` (`li_id`),
  KEY `ChallengeID` (`indicator_code`),
  KEY `facilityID` (`fac_id`),
  KEY `facilityID_2` (`fac_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1