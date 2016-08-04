CREATE TABLE IF NOT EXISTS `phpvms_aircraft_liveries` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `registration` varchar(30) NOT NULL,
  `sim` varchar(10) NOT NULL,
  `desc` text NOT NULL,
  `image` text NOT NULL,
  `link` text NOT NULL,
  `aircraftID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE  `phpvms_aircraft` ADD  `equipment` varchar(64) NOT NULL ;
ALTER TABLE  `phpvms_aircraft` ADD  `field18` varchar(100) NOT NULL ;
ALTER TABLE  `phpvms_aircraft` ADD  `selcal` varchar(4) NOT NULL ;
