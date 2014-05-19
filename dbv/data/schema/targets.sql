CREATE TABLE `targets` (
  `target_id` int(11) NOT NULL,
  `target_value` int(11) DEFAULT NULL,
  `target_created` timestamp NULL DEFAULT NULL,
  `target_creator` int(11) DEFAULT NULL,
  `target_indicator` int(11) DEFAULT NULL,
  PRIMARY KEY (`target_id`),
  KEY `indicators_idx` (`target_indicator`),
  CONSTRAINT `indicators` FOREIGN KEY (`target_indicator`) REFERENCES `indicators` (`indicator_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1