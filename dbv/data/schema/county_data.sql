CREATE TABLE `county_data` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `county_id` int(11) DEFAULT NULL,
  `under_five` int(11) DEFAULT NULL,
  `women_of_reproductive_age` int(11) DEFAULT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1