
CREATE TABLE IF NOT EXISTS `openaip_airport` ( 
    `id` INT NOT NULL AUTO_INCREMENT , 
    `type` ENUM('APT', 'AF_CIVIL', 'AF_MIL_CIVIL','AF_WATER','AD_CLOSED', 'AD_MIL', 'HELI_CIVIL', 'HELI_MIL', 'AF_MIL_CIVIL', 'LIGHT_AIRCRAFT', 'GLIDING', 'INTL_APT') NOT NULL , 
    `country` CHAR(2) NOT NULL , 
    `name` VARCHAR(60) NOT NULL , 
    `icao` CHAR(4) NOT NULL , 
    `lat` FLOAT NOT NULL , 
    `lon` FLOAT NOT NULL , 
    `elev` FLOAT NOT NULL , 
    PRIMARY KEY (`id`, `icao`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `openaip_runway` (
    `id` int NOT NULL AUTO_INCREMENT,
    `airportID` int NOT NULL,
    `operation` ENUM('ACTIVE', 'CLOSED', 'TEMPORARILY CLOSED') NOT NULL,
    `name` char(8) NOT NULL,
    `sfc` ENUM('ASPH', 'GRAS', 'UNKN', 'CONC', 'SAND', 'GRVL', 'SNOW', 'ICE') NOT NULL,
    `length` float NOT NULL,
    `width` float NOT NULL,
    `dir1` char(3) NOT NULL,
    `dir2` char(3) NOT NULL,
    PRIMARY KEY (`id`, `airportID`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `openaip_radio` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `airportID` int(11) NOT NULL,
    `category` ENUM('NAVIGATION', 'INFORMATION', 'COMMUNICATION', 'OTHER') NOT NULL,
    `type` ENUM('INFO', 'GROUND', 'APPROACH', 'TOWER', 'ILS', 'CTAF', 'OTHER', 'APRON', 'LIGHTS', 'ARRIVAL', 'ATIS', 'CENTER', 'DEPARTURE') NOT NULL,
    `frequency` float NOT NULL,
    `desc` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`, `airportID`)
) ENGINE=InnoDB;

