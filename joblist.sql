DROP TABLE IF EXISTS `phpvms_joblist`;

CREATE TABLE IF NOT EXISTS `phpvms_joblist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_id` int(11) NOT NULL,
  `pilot_id` int(11),
  `bid_id`int(11),
  `valid_from` date NOT NULL DEFAULT '1970-01-01',
  `valid_to` date NOT NULL DEFAULT '1970-01-01',
  `status` varchar(1) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM   ;

ALTER TABLE `phpvms_pilots` ADD `job_count` INT(11) NOT NULL DEFAULT '0';
