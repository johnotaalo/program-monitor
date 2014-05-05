CREATE TABLE `log_treatment` (
  `lt_id` int(11) NOT NULL AUTO_INCREMENT,
  `lt_other_treatment` varchar(255) DEFAULT 'n/a',
  `lt_severe_dehydration_number` int(11) NOT NULL DEFAULT '-1',
  `lt_some_dehydration_number` int(11) NOT NULL DEFAULT '-1',
  `lt_no_dehydration_number` int(11) NOT NULL DEFAULT '-1',
  `lt_dysentry_number` int(11) NOT NULL DEFAULT '-1',
  `lt_no_classification_number` int(11) NOT NULL DEFAULT '-1',
  `lt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `treatment_code` varchar(45) NOT NULL,
  `facility_mfl` varchar(11) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`lt_id`),
  KEY `Challenges_id` (`lt_id`),
  KEY `ChallengeID` (`treatment_code`),
  KEY `facilityID` (`facility_mfl`),
  KEY `facilityID_2` (`facility_mfl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1