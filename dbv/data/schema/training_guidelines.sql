CREATE TABLE `training_guidelines` (
  `tg_id` int(11) NOT NULL AUTO_INCREMENT,
  `tg_trained_after_2010` int(11) NOT NULL DEFAULT '0',
  `tg_trained_before_2010` int(11) NOT NULL DEFAULT '0',
  `tg_working` int(4) NOT NULL DEFAULT '0',
  `tg_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fac_mfl` int(11) NOT NULL,
  `guide_code` varchar(11) NOT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`tg_id`),
  KEY `facilityID` (`fac_mfl`),
  KEY `guidelineCode` (`guide_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1