CREATE TABLE `lt_anwesenheit_listen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `band` varchar(32) NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `lt_anwesenheit_events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_liste` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `name` varchar(60) NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `lt_anwesenheit_events` ADD INDEX ( `id_liste` );


CREATE TABLE `lt_anwesenheit_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_event` int(10) unsigned NOT NULL,
  `id_mitglied` int(10) unsigned NOT NULL,
  `status` enum('anwesend','abwesend','entschuldigt','') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `lt_anwesenheit_entries` ADD INDEX ( `id_event`, `id_mitglied` );
