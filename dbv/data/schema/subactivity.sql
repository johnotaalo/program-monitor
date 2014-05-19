CREATE TABLE `subactivity` (
  `subactivity_id` int(11) NOT NULL AUTO_INCREMENT,
  `subactivity_name` varchar(45) DEFAULT NULL,
  `subactivity_start` int(11) DEFAULT NULL,
  `subactivity_end` int(11) DEFAULT NULL,
  `activity_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`subactivity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1