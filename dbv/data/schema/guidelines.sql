CREATE TABLE `guidelines` (
  `guide_id` int(11) NOT NULL AUTO_INCREMENT,
  `guide_code` varchar(11) NOT NULL,
  `guide_name` varchar(55) NOT NULL,
  `guide_for` varchar(3) NOT NULL,
  PRIMARY KEY (`guide_id`),
  KEY `guidelineCode` (`guide_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1