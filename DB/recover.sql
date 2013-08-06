
CREATE TABLE IF NOT EXISTS `recover` (
  `user_id` int(10) DEFAULT NULL,
  `date_expire` int(10) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  UNIQUE KEY `user_id` (`user_id`),
  KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

