CREATE TABLE IF NOT EXISTS `biz_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent` int NOT NULL DEFAULT '0',
  `label` varchar(60) DEFAULT NULL,
  `googleADSense` mediumtext NOT NULL,
  `priority` smallint DEFAULT NULL,
  `cat_phone` varchar(25) DEFAULT NULL,
  `active` tinyint DEFAULT '0',
  `hidden` tinyint NOT NULL DEFAULT '0',
  `extra_fields` text,
  `max_lead_send` smallint DEFAULT NULL,
  `add_email_to_form` tinyint NOT NULL DEFAULT '0',
  `show_whatsapp_button` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;