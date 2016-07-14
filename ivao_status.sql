CREATE TABLE IF NOT EXISTS `phpvms_ivaowhazzup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `callsign` varchar(15) NOT NULL,
  `vid` varchar(7) NOT NULL,
  `name` varchar(30) NOT NULL,
  `departure` varchar(5) NOT NULL,
  `destination` varchar(5) NOT NULL,
  `transponder_code` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=658 ;

CREATE TABLE IF NOT EXISTS `phpvms_onlinestatus` (
  `id` int(11) NOT NULL,
  `service` varchar(10) NOT NULL,
  `url` varchar(60) NOT NULL,
  `status_update` date NOT NULL,
  `pilot_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE  `phpvms_pilots` ADD  `ivao_id` VARCHAR( 7 ) NOT NULL ;
ALTER TABLE  `phpvms_pilots` ADD  `ivao_status` INT NOT NULL DEFAULT  '0';
