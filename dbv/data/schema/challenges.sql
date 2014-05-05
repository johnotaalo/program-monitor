CREATE TABLE `challenges` (
  `challenge_id` int(11) NOT NULL AUTO_INCREMENT,
  `challenge_code` varchar(45) NOT NULL,
  `challenge_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`challenge_id`),
  KEY `idChallenges` (`challenge_id`),
  KEY `challenge_code` (`challenge_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1