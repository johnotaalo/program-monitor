CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) DEFAULT NULL,
  `user_password` varchar(45) DEFAULT NULL,
  `user_email` varchar(45) DEFAULT NULL,
  `user_phone` varchar(45) DEFAULT NULL,
  `user_rights` int(1) DEFAULT NULL,
  `user_active` int(1) DEFAULT NULL,
  `user_signature` int(1) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1