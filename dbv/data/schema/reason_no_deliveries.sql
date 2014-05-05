CREATE TABLE `reason_no_deliveries` (
  `rnd_id` int(11) NOT NULL AUTO_INCREMENT,
  `rsn_name` varchar(255) NOT NULL,
  PRIMARY KEY (`rnd_id`),
  UNIQUE KEY `reasonName` (`rsn_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1