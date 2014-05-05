CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_code` varchar(10) NOT NULL,
  `question_name` text,
  `question_for` varchar(7) NOT NULL COMMENT 'ceoc,',
  PRIMARY KEY (`question_id`),
  UNIQUE KEY `idSignal_Functions` (`question_id`),
  UNIQUE KEY `signalCode` (`question_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1