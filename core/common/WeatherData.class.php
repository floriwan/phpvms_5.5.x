<?php
/**
 * @author F. Goeldenitz
 * @copyright
 * @link
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

 class WeatherData extends CodonData {

   /**
    * get metar data
    */
   public static function get_metar_xml($icao) {
     $metar_url = 'https://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=metars&requestType=retrieve&format=xml&stationString='.$icao.'&hoursBeforeNow=1';
     return simplexml_load_file($metar_url);
   }

   /**
    * get station info
    */
   public static function get_info_xml($icao) {
     $info_url = 'https://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=stations&requestType=retrieve&format=xml&stationString='.$icao;
     return simplexml_load_file($info_url);
   }

   public static function format_date($data_string) {
     $utc = strtotime(trim($data_string));
     return date("D, F jS Y g:i A",$utc);
   }

   public static function convert_clouds($sky_cover) {

     $sky_cover = (string) $sky_cover;

     $cloude_code = array(
		    'SKC' => 'clear skies',
		    'CLR' => 'clear skies',
		    'FEW' => 'partly cloudy',
		    "SCT" => 'scattered clouds',
		    'BKN' => 'mostly cloudy',
		    'OVC' => 'overcast',
		    'VV'  => 'vertical visibility');

        //if (array_key_exists($sky_cover, $cloude_code)) echo "lalala" . $cloude_code[$sky_cover];
        //else echo "puhhh";

    return $cloude_code[$sky_cover];
  }

  public static function wind_direction($angle) {
    //$compass = array('N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW');

    $compass = array(
      'north', 'northnortheast', 'northeast',
      'eastnortheast', 'east', 'eastsoutheast',
      'southeast', 'southsoutheast', 'south', 'southsouthwest', 'southwest',
      'westsouthwest', 'west', 'westnorthwest',
      'northwest', 'nothnorthwest');

    $direction = $compass[round($angle / 22.5) % 16];
    return $direction;
  }

  public static function inHgToQNH($hpa) {
      return round((float)$hpa / 0.02953);
  }

  public static function degreeToFahrenheit($degree) {
    return round(($degree * 1.8) + 32);
  }

 }
