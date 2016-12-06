ALTER TABLE `phpvms_schedules`
ADD `valid_from` DATE NOT NULL DEFAULT '2010-01-01' AFTER `bidid`,
ADD `valid_to` DATE NOT NULL DEFAULT '2010-01-01' AFTER `valid_from`;


CREATE TABLE IF NOT EXISTS `phpvms_tours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100),
  `image` VARCHAR(100),
  `description` text,
  `random` int(1),
  `flightnum_regex` VARCHAR(50),
  `valid_from` DATE NOT NULL DEFAULT '2010-01-01',
  `valid_to` DATE NOT NULL DEFAULT '2999-01-01',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM   ;


# SELECT * FROM `phpvms_schedules` WHERE flightnum REGEXP '^ANXMAS[0-9]{2}'
# ^ANXMAS[0-9]{2}
