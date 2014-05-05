CREATE TABLE `ort_corner_aspects` (
  `oca_id` int(11) NOT NULL AUTO_INCREMENT,
  `oca_response` varchar(255) DEFAULT NULL,
  `questionCode` varchar(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fac_mfl` varchar(11) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`oca_id`),
  KEY `Challenges_id` (`oca_id`),
  KEY `facilityID` (`fac_mfl`),
  KEY `facilityID_2` (`fac_mfl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1