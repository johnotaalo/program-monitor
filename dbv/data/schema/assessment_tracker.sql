CREATE TABLE `assessment_tracker` (
  `ast_id` int(11) NOT NULL AUTO_INCREMENT,
  `ast_section` varchar(45) NOT NULL,
  `ast_last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ast_survey` varchar(4) NOT NULL COMMENT 'ch or mnh',
  `facilityCode` varchar(45) NOT NULL,
  PRIMARY KEY (`ast_id`),
  KEY `facilityCode` (`facilityCode`),
  KEY `trackerSection_2` (`ast_section`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1