
-- Table structure for `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(32) NOT NULL,
  `stat` varchar(10) NOT NULL,
  `date` text NOT NULL,
  `time` text NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `salt` text NOT NULL,
  `password` text NOT NULL,
  `otp` text NOT NULL,
  `otp_expiration` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `phone` text NOT NULL,
  `country` varchar(10) NOT NULL,
  `full_phone` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `token`, `stat`, `date`, `time`, `username`, `email`, `salt`, `password`, `otp`, `otp_expiration`, `phone`, `country`, `full_phone`) VALUES ('1', 'e50ae4996073d46622f496dd3a32d08b', '0', '2024-08-28', '13:30:54', 'ezychat_superadmin', 'computerwisdom1224@gmail.com', 'd2ed1f36e1e2a02a94b04a38c9ee7f00', '1beb16ca627eb370ec5a4fdce551c755', '', '0000-00-00 00:00:00', '85555421', '65', '6585555421');


-- Table structure for `webbycms_example`
DROP TABLE IF EXISTS `webbycms_example`;
CREATE TABLE `webbycms_example` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(32) NOT NULL,
  `stat` varchar(10) NOT NULL,
  `date` text NOT NULL,
  `time` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `webbycms_example` (`id`, `token`, `stat`, `date`, `time`) VALUES ('1', '6764ade585b3df6597eef343e4c2d32a', '0', '2024-08-28', '11:35 AM');

