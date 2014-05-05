CREATE TABLE `log_morbidity` (
  `lm_id` int(11) NOT NULL AUTO_INCREMENT,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fac_mfl` varchar(11) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`lm_id`),
  KEY `facilityID` (`fac_mfl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1