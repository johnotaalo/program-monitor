CREATE TABLE `indicators` (
  `indicator_id` int(11) NOT NULL AUTO_INCREMENT,
  `indicator_name` varchar(255) NOT NULL,
  `indicator_code` varchar(6) NOT NULL,
  `indicator_for` varchar(3) NOT NULL COMMENT 'svc-services, dgn-diagnosis, sgn-signs, ror-review of records, cns-counsel',
  PRIMARY KEY (`indicator_id`),
  UNIQUE KEY `indicatorName` (`indicator_name`),
  UNIQUE KEY `indicatorCode` (`indicator_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1