DROP TABLE IF EXISTS `phpvms_autopirep`;
CREATE TABLE IF NOT EXISTS `phpvms_autopirep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `criteria_description` text NOT NULL,
  `created_by` int(5) NOT NULL,
  `enabled` smallint(6) NOT NULL DEFAULT '1',
  `criteria_variable` text NOT NULL,
  `criteria_custom_message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM   ;


INSERT INTO `phpvms_autopirep` (`id`, `criteria_description`, `created_by`, `enabled`, `criteria_variable`, `criteria_custom_message`) VALUES
(11, 'Simrate 8x Speed', 0, 0, 'Simrate set to 8x Speed', 'Exeedet max sim rate'),
(37, 'Overspeed', 0, 0, 'Overspeed ', 'Overspeed '),
(35, 'Paused', 0, 0, 'Paused', 'Paused');

DROP TABLE IF EXISTS `phpvms_autopirep_settings`;
CREATE TABLE IF NOT EXISTS `phpvms_autopirep_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `enabled` varchar(1) NOT NULL,
  `landing_rate` text NOT NULL,
  `sendmail_to_admin` smallint(6) NOT NULL DEFAULT '1',
  `sendmail_to_pilot` tinyint(4) NOT NULL,
  `admin_rejecting` text NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM   ;



INSERT INTO `phpvms_autopirep_settings` (`setting_id`,  `enabled`,`landing_rate`, `sendmail_to_admin`, `sendmail_to_pilot`, `admin_rejecting`) VALUES
(1,0, '', 1, 1, '');
