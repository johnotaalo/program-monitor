CREATE TABLE `facility_owners` (
  `fo_id` int(11) NOT NULL AUTO_INCREMENT,
  `fo_name` varchar(255) NOT NULL,
  `fo_for` varchar(3) NOT NULL,
  `fo_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`fo_id`),
  UNIQUE KEY `facilityOwner_UNIQUE` (`fo_name`),
  KEY `facilityType` (`fo_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1