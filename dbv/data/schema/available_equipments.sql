CREATE TABLE `available_equipments` (
  `ae_id` int(11) NOT NULL AUTO_INCREMENT,
  `ae_availability` varchar(45) NOT NULL DEFAULT 'n/a',
  `ae_location` varchar(255) NOT NULL DEFAULT 'n/a',
  `ae_fully_functional` int(11) NOT NULL DEFAULT '-1',
  `ae_partially_functional` int(11) NOT NULL DEFAULT '-1',
  `ae_non_functional` int(11) NOT NULL DEFAULT '-1',
  `ae_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fac_id` varchar(11) NOT NULL,
  `eq_code` varchar(55) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ae_id`),
  KEY `facilityID` (`fac_id`),
  KEY `equipmentID` (`eq_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1