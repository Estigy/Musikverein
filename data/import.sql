-- Neue Tabelle lt_abzeichen

CREATE TABLE IF NOT EXISTS `lt_abzeichen` (
`id` int(10) unsigned NOT NULL,
  `bezeichnung` varchar(64) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

INSERT INTO `lt_abzeichen` (`id`, `bezeichnung`) VALUES
(1, 'JMLA Bronze'),
(2, 'JMLA Silber'),
(3, 'JMLA Gold'),
(4, 'Abzeichen für Ersprießliche Tätigkeit');

ALTER TABLE `lt_abzeichen`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `lt_abzeichen`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;

-- Instrumenten-Verleich: Ausgebender und Rücknehmender dürfen NULL sein

ALTER TABLE `lt_instrumente_verleih` CHANGE `ausgebender` `ausgebender` INT(10) NULL, CHANGE `ruecknehmender` `ruecknehmender` INT(10) UNSIGNED NULL; 
UPDATE `lt_instrumente_verleih` SET ausgebender = NULL where ausgebender = 0;
UPDATE `lt_instrumente_verleih` SET ruecknehmender = NULL where ruecknehmender = 0;

-- Termine: Kapelle in Json-Array umbauen

UPDATE `lt_termine` SET kapelle = '["BMK"]' WHERE kapelle = '~|~BMK~|~';
UPDATE `lt_termine` SET kapelle = NULL WHERE kapelle = '~|~~|~';
UPDATE `lt_termine` SET kapelle = '["NWK"]' WHERE kapelle = '~|~NWK~|~';
UPDATE `lt_termine` SET kapelle = '["Kleine Gruppe"]' WHERE kapelle = '~|~Kleine Gruppe~|~';
UPDATE `lt_termine` SET kapelle = '["JK"]' WHERE kapelle = '~|~JK~|~';
UPDATE `lt_termine` SET kapelle = '["BMK","JK"]' WHERE kapelle = '~|~BMK~|~JK~|~';
UPDATE `lt_termine` SET kapelle = '["BMK","Kleine Gruppe"]' WHERE kapelle = '~|~BMK~|~Kleine Gruppe~|~';

-- Abzeichen-Verleihungstabelle: Fremdschlüssel

ALTER TABLE `lt_mitglieder2abzeichen` CHANGE `abzeichen` `id_abzeichen` INT UNSIGNED NOT NULL; 

-- Funktionen-Zuordnungstabelle: Fremdschlüssel

ALTER TABLE `lt_mitglieder2funktion` CHANGE `funktion` `id_funktion` INT UNSIGNED NOT NULL; 


-- NULLable-Änderungen

ALTER TABLE `lt_termine` CHANGE `id_bmk_calendar_events` `id_bmk_calendar_events` INT(10) UNSIGNED NULL DEFAULT '0', CHANGE `status` `status` VARCHAR(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL; 
ALTER TABLE `lt_instrumente` CHANGE `status` `status` INT(10) UNSIGNED NOT NULL; 
ALTER TABLE `lt_noten` CHANGE `unbrauchbar` `unbrauchbar` TINYINT(4) NOT NULL DEFAULT '0', CHANGE `ausgelagert` `ausgelagert` TINYINT(4) NOT NULL DEFAULT '0'; 
