<?php

/**
 *
 * @author F. Göldenitz
 */

class OpenAIPData extends CodonData {

    public static function getAirportData($icao) {
    }
    
    public static function updateOpenAIPFiles() {

        if (!is_dir(SITE_ROOT.AIP_PATH)) {
            echo "<p>directory " . SITE_ROOT.AIP_PATH . " not available, create new one ...</p>";

            if (!mkdir(AIP_PATH)) {
                echo "<p>can not create directory " . SITE_ROOT.AIP_PATH . ". Can not update AIP files, abort!</p>";
                return;
            }
        }
    
        if (!is_writeable(dirname(SITE_ROOT.AIP_PATH."/tst.txt"))) {
            echo "<p>no write permission in directory " . SITE_ROOT.AIP_PATH . ". Abort!</p>";
            return;
        }
        

        echo "<p>download directory: " . SITE_ROOT.AIP_PATH . "</p>";
        echo "<p>open aip URL: " . OPENAIP_URL . "</p>";
        OpenAIPData::downloadAIPFiles(OPENAIP_URL);
        OpenAIPData::updateDB(SITE_ROOT.AIP_PATH);

    }

    public static function updateDB($aip_path) {
        echo "<p>update database ...</p>";

        $files = scandir($aip_path);
        //print_r($files);
        $count = 0;
        
        foreach ($files as $file) {
            $count++;
            
            if (strpos($file, "wpt") == 0) {
                continue;
            }
        
            $aip_file = $aip_path."/".$file;

            if (!file_exists($aip_file)) {
                echo "<p>can not open file " . $aip_file . "</p>";
                continue;
            }

            if (filesize($aip_file) == 0) {
                echo "<p>skip file $aip_file, no content</p>";
                continue;
            }

            echo "<p>import file : " . $aip_file . "</p>";
            $xml = simplexml_load_file($aip_file);

            if ($xml === false) {
                echo "<p>can not load xml file $aip_file\n";
                continue;
            }

            foreach ($xml->children() as $airports) {
                foreach ($airports->children() as $airport) {
            
                    // skip airports without icao code
                    if ((string)$airport->ICAO == "") {
                        continue;
                    }
                    
                    // skip airports with no runway
                    if (sizeof($airport->RWY) < 1) {
                        echo "<p>airport " . (string)$airport->ICAO . " with no runway, skip ...</p>";
                        continue;
                    }
                    
                    // first add the airport
                    $airportID = OpenAIPData::addAirport((string)$airport['TYPE'],
                                (string)$airport->COUNTRY, 
                                (string)$airport->NAME,
                                (string)$airport->ICAO,
                                (string)$airport->GEOLOCATION->LAT,
                                (string)$airport->GEOLOCATION->LON,
                                (string)$airport->GEOLOCATION->ELEV);
                    //echo "<p>airport id " . $airportID . "</p>";
                    
                    if ($airportID == 0) {
                        echo "<p>ERROR: can not add airport " . (string)$airport->ICAO . "</p>";
                        continue;
                    }
                    
                    // add all runways for this airport
                    foreach ($airport->RWY as $rwy) {
                        
                        //$directions = array();
                        $rwCount = 0;
                        foreach($rwy->DIRECTION as $dir) {
                            //echo "<p>" . (string)$dir['TC'] . "</p>";
                            $directions[$rwCount] = (string)$dir['TC'];
                            $rwCount++;
                        }
                        
                        //echo "direction : " . $directions[0] . " / " . $directions[1] . "</p>";
                        if (OpenAIPData::addRunway($airportID,
                            (string)$rwy['OPERATIONS'],
                            (string)$rwy->NAME,
                            (string)$rwy->SFC,
                            (string)$rwy->LENGTH,
                            (string)$rwy->WIDTH,
                            $directions[0],
                            $directions[1]) == false) {
                                echo "<p>ERROR: can not add runway to airport " . (string)$airport->ICAO . "</p>";  
                            }
                                
                    }
                    
                    // add radio equipment
                    foreach ($airport->RADIO as $radio) {
                        if (OpenAIPData::addRadio($airportID,
                        (string)$radio['CATEGORY'],
                        (string)$radio->FREQUENCY,
                        (string)$radio->TYPE,
                        (string)$radio->DESCRIPTION) == false) {
                            echo "<p>ERROR: can not add communication to airport " . (string)$airport->ICAO . "</p>";  
                        }
                    }
                    
                }
            }
            
            //if ($count > 2) return;
            
        }

    }
    
    /**
     * format frequency string
     */
    public static function formatFrequency($freq) {
        
        $tmp = explode(".", $freq);
        
        // three digits after the .
        if (strlen($tmp[0]) == 3) {
            return $tmp[0] . "." . str_pad($tmp[1], 3, "0");
        }
        
        if (strlen($tmp[0]) == 2) {
            return $tmp[0] . "." . str_pad($tmp[1], 4, "0");
        }
    }
    
    public static function toSurface($surface) {
        if ($surface == "CONC") return "Concrete";
        if ($surface == "ASPH") return "Asphalt";
        if ($surface == "GRAS") return "Gras";
        if ($surface == "UNKN") return "Unknown";
        if ($surface == "SAND") return "Sand";
        if ($surface == "GRVL") return "Gravel";
        if ($surface == "SNOW") return "Snow";
        if ($surface == "ICE") return "Ice";
        return $surface;
    }
    
    public static function meter2feet($meter) {
        return round($meter * 3.2808399, 0);
    }
    
    public static function dec2dms($dec) {
        $dec = ltrim($dec, '-');
        $vars = explode(".",$dec);
        $deg = $vars[0];
        $tempma = "0.".$vars[1];

        $tempma = $tempma * 3600;
        $min = floor($tempma / 60);
        $sec = round($tempma - ($min*60), 2);

        return array("deg"=>$deg,"min"=>$min,"sec"=>$sec);
    }
    
    public static function getAirport($icao) {
        $sql = "SELECT * FROM " . AIP_TABLE_PREFIX . "airport WHERE `icao` = '" . $icao . "'";
        //echo "<p>" . $sql . "</p>";
        return DB::get_results($sql);
        // SELECT a.*, r.* FROM `openaip_airport` as a LEFT JOIN `openaip_runway` as r ON (a.id = r.airportID)
        // SELECT a.*, r.* FROM `openaip_airport` as a LEFT JOIN `openaip_radio` as r ON (a.id = r.airportID) WHERE a.icao = 'EDDF'
    }
    
    public static function getRadio($airportID) {
        $sql = "SELECT * FROM " . AIP_TABLE_PREFIX . "radio WHERE `airportID` = '" . $airportID . "'";
        return DB::get_results($sql);
    }
    
    public static function getRunway($airportID) {
        $sql = "SELECT * FROM " . AIP_TABLE_PREFIX . "runway WHERE `airportID` = '" . $airportID . "'";
        return DB::get_results($sql);
        
    }
    
    public static function addRadio($airportID, $cat, $freq, $type, $desc) {
        $sql = 'INSERT INTO ' . AIP_TABLE_PREFIX . "radio
            (`airportID`, `category`, `type`, `frequency`, `desc`)
            VALUES ('".$airportID."', '".$cat."', '".$type."', '".$freq."', '".$desc."');";
        $result = DB::query($sql);

        if (DB::errno() != 0) {
            echo "<p>ERROR: " . $sql . "</p>";
            return false;
        }
        return true;
    }
    
    /**
     * add runway to a specific airport
     */
    public static function addRunway($airportID, $op, $name, $sfc, $length, $width, $dir1, $dir2) {
        $sql = 'INSERT INTO ' . AIP_TABLE_PREFIX . "runway
            (`airportID`, `operation`, `name`, `sfc`, `length`, `width`, `dir1`, `dir2`)
            VALUES ('".$airportID."', '".$op."', '".$name."', 
            '".$sfc."', '".$length."',
            '".$width."', '".$dir1."',
            '".$dir2."');";
        $result = DB::query($sql);

        if (DB::errno() != 0) {
            echo "<p>ERROR: " . $sql . "</p>";
            return false;
        } 
        return true;
    }
    
    /**
     * Remove airpot with icao code.
     * Because icao code con only be used once, all airport found with the given
     * code will be remove from database
     * @param $icao remove airports with this icao code
     */
    public static function removeAirport($icao) {
    
        $airportID = OpenAIPData::getAirportID($icao);
        if ($airportID == 0) {
            echo "<p>ERROR: can not remove airport " . $icao . " from database</p>";
            return false;
        }
        
        $sql = "DELETE FROM " . AIP_TABLE_PREFIX . "airport WHERE `icao` = '" . $icao . "'";
        $result = DB::query($sql);
        if (DB::errno() != 0) {
            echo "<p>ERROR: " . $sql . "</p>";
            return false;
        } 
        
        $sql = "DELETE FROM " . AIP_TABLE_PREFIX . "runway WHERE `airportID` = '" . $airportID . "'";
        $result = DB::query($sql);
        
        $sql = "DELETE FROM " . AIP_TABLE_PREFIX . "radio WHERE `airportID` = '" . $airportID . "'";
        $result = DB::query($sql);
        
        return true;
        
    }
    
    /**
     * Check if an airport with icao code is available in the db
     * @param $icao check this icao code
     * @return true if an airport was found
     */
    public static function airportExists($icao) {
        $sql = 'SELECT id from ' . AIP_TABLE_PREFIX . "airport where icao = '".$icao."';";
        $result = DB::get_results($sql);
        
        if (!is_array($result))
            return false;
        else
            return true;
    }
    
    /**
     * Add airport into database.
     * Check for existing airportand remove all airports with the same icao code.
     * Icao code must be unique.
     */
    public static function addAirport($type, $country, $name, $icao, $lat, $lon, $elev) {
        
        // check for dublicates
        if (OpenAIPData::airportExists($icao)) {
            if (!OpenAIPData::removeAirport($icao)) {
                return;
            }
        }
                    
        $sql = 'INSERT INTO ' . AIP_TABLE_PREFIX . "airport
            (`type`, `country`, `name`, `icao`, `lat`, `lon`, `elev`)
            VALUES ('".$type."', '".$country."', 
            '".$name."', '".$icao."',
            '".$lat."', '".$lon."',
            '".$elev."');";

        $result = DB::query($sql);
        if (DB::errno() != 0) {
            echo "<p>ERROR: " . $sql . "</p>";
            return 0;
        } 

        return OpenAIPData::getAirportID($icao);

    }

    /**
     * @param $icao airport icao code
     * @return airport database id
     */
    public static function getAirportID($icao) {
        $sql = 'SELECT id from ' . AIP_TABLE_PREFIX . "airport where icao = '".$icao."';";
        $result = DB::get_row($sql);
        return $result->id;
    }
    
    public static function downloadAIPFiles($aip_url) {
        $content = explode('</tr>', file_get_contents($aip_url));

        $openaip_files = array();

        foreach ($content as $line) {
            $pos = strpos($line, "</a>");
            $filename = substr($line, $pos - 10, 10);
            if ($pos && sizeof($filename) > 0 && strpos($filename, "aip") > 0) {
                $openaip_files[] = $filename;
            }
        }
        echo "<p>found " . sizeof($openaip_files) . " airport files</p>";

        foreach ($openaip_files as $remotefile) {
            $local_filename = SITE_ROOT.AIP_PATH."/".$remotefile;
            file_put_contents($local_filename, fopen($aip_url . $remotefile, 'r'));
            /*if (!file_exists($local_filename)) {
                file_put_contents($local_filename, fopen($aip_url . $remotefile, 'r'));
            }*/

        }
    }

}
