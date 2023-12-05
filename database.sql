--
-- База данных: `testtaskdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(128) DEFAULT NULL,
  `u_age` int(10) DEFAULT NULL,
  `u_phone` varchar(128) DEFAULT NULL,
  `u_email` varchar(255) DEFAULT NULL,
  `u_city` varchar(128) DEFAULT NULL,
  `u_photo` varchar(255) DEFAULT NULL,
  `u_mailindex` int(10) DEFAULT NULL,
  `u_password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_email` (`u_email`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
