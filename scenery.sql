CREATE TABLE IF NOT EXISTS `phpvms_scenery` ( 
    `id` INT NOT NULL AUTO_INCREMENT , 
    `icao` CHAR(4) NOT NULL , 
    `descr` varchar(200),
    `sim` varchar(10) NOT NULL,
    `link`varchar(200) NOT NULL,
    `payware` int NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY (`icao`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `phpvms_scenery_report` ( 
    `id` INT NOT NULL AUTO_INCREMENT , 
    `sceneryID` CHAR(4) NOT NULL , 
    `report` varchar(200) NOT NULL,
    `pilotID` varchar(11) NOT NULL DEFAULT '0',
    `submitdate` date NOT NULL DEFAULT '1970-01-01',
    `confirmed` int NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY (`sceneryID`)
) ENGINE = InnoDB;
