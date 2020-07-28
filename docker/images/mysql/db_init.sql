DROP TABLE IF EXISTS `earned_money`;

CREATE TABLE `earned_money` (
  `drink` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profit` DECIMAL(10,2) NOT NULL DEFAULT '0.0',
  PRIMARY KEY (`drink`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


