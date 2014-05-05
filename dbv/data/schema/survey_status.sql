CREATE TABLE `survey_status` (
  `ss_id` int(11) NOT NULL AUTO_INCREMENT,
  `ss_classification` varchar(45) DEFAULT NULL,
  `ss_year` varchar(45) DEFAULT NULL,
  `fac_id` int(11) DEFAULT NULL,
  `st_id` int(11) DEFAULT NULL,
  `sc_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ss_id`),
  KEY `facilities_ss_idx` (`fac_id`),
  KEY `survey_types_ss_idx` (`st_id`),
  KEY `survey_categories_ss_idx` (`sc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1