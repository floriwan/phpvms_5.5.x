<?php
/**
 * @author F. Göldenitz
 * @copyright Copyright (c) 2016
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class IvaoData extends CodonData {

  static $ivao_fields = array('callsign', 'vid', 'realname', 'clienttype', 'frequency', 'latitude', 'longitude',
                       'altitude', 'groundspeed', 'planned_aircraft', 'planned_tascruise',
                       'planned_depairport', 'planned_altitude', 'planned_destairport', 'server',
                       'protrevision', 'rating', 'transponder', 'facilitytype', 'visualrange',
                       'planned_revision', 'planned_flighttype', 'planned_deptime', 'planned_actdeptime',
                       'planned_hrsenroute', 'planned_minenroute', 'planned_hrsfuel', 'planned_minfuel',
                       'planned_altairport', 'planned_remarks', 'planned_route', 'planned_depairport_lat',
                       'planned_depairport_lon', 'planned_destairport_lat', 'planned_destairport_lon',
                       'atis_message', 'time_last_atis_received', 'time_connected', 'client_software_name',
                       'client_software_version', 'adminrating', 'atc_or_pilotrating',
                       'planned_altairport2', 'planned_typeofflight', 'planned_pob', 'true_heading', 'onground', 'undefined', 'mtllivery',
                       );

  public static function updatePilotsOnlineState() {

    self::updateStatus("IVAO");
    self::updatePilotStatus("IVAO");

    return;

  }

  public static function updatePilotStatus($service) {

    $array[] = $ivao_ids;

    if (self::pilotUpdateNeeded($service) == false) return;

    // get all ivao ids from the pilots
    $all_ids = PilotData::getAllIvaoIds();
    foreach($all_ids as $id) {
      if (!empty($id->ivao_id)
        )$ivao_ids[] = $id->ivao_id;
    }

    // reset all ivao state
    PilotData::resetAllIvaoStates();

    // now get the whazzup data and parse it
    $url = self::getWhazzupUrl($service);
    $url = preg_replace('/\s+/', '', $url);
    foreach(explode("\n", file_get_contents($url)) as $line) {

      switch($line) {
        case "!CLIENTS":
          $data_block = 'clients';
          break;
        case "!GENERAL":
        case "!SERVERS":
        case "!AIRPORTS":
          $data_block = 'xxx';
          break;
        default:

          if ($data_block === 'clients') {
            switch($line) {
              case "!CLIENTS":
                $data_block = 'clients';
                break;
              case "!GENERAL":
              case "!SERVERS":
              case "!AIRPORTS":
                $data_block = 'xxx';
                break;
              default:

                if ($data_block === 'clients') {
                  $fields = explode(":", $line);
                  if ($fields[3] === "PILOT") {
                    if (in_array($fields[1], $ivao_ids)) {
                      PilotData::setIvaoOnline($fields[1]);
                    }
                  }
                }

            }
          }
      }
    }

    self::saveLastPilotUpdate($service);

  }

  /**
   * set the last pilot update timestamp in database
   */
  public static function saveLastPilotUpdate($service) {
    $sql = "UPDATE " . TABLE_PREFIX . "onlinestatus SET ";
    $sql .= " `pilot_update`='" . date("Y-m-d H:i:s") . "'";
    $sql .= " where `service`='{$service}'";
    DB::query($sql);
  }

  public static function getWhazzupUrl($service) {
    $sql = "SELECT `url` from " . TABLE_PREFIX . "onlinestatus where `service`='{$service}'";
    $ret = DB::get_results($sql);
    return $ret[0]->url;
  }

  public static function updateStatus($service) {

    if (self::statusUpdateNeeded($service) == false) return;

    $ivao_status_url = Config::Get($service.'_STATUS_URL');

    // no url set, nothin todo, return
    if ($ivao_status_url == '') return;

    $ivao_status = file_get_contents($ivao_status_url);
    foreach(explode("\n", $ivao_status) as $line) {

      // the whazzup url line start with 'url0='
      if (strpos($line, 'url0=') === 0) {
        $whazzup_url = explode("=", $line)[1];
        self::saveStatusUpdate($whazzup_url, $service);
      }
    }
  }

  /**
   *
   */
  public static function saveStatusUpdate($whazzup_url, $service) {

    $sql = "UPDATE " . TABLE_PREFIX . "onlinestatus SET ";
    $sql .= "`url`='" . $whazzup_url . "', ";
    $sql .= " `status_update`='" . date("Y-m-d H:i:s") . "'";
    $sql .= " where `service`='{$service}'";
    DB::query($sql);

    LogData::addLog($pilotid, "update ".$service." whazzup url ".$whazzup_url);

  }

 /**
  * check for the last pilot data update
  */
  public static function pilotUpdateNeeded($service) {

    $sql = "SELECT `pilot_update` from " . TABLE_PREFIX . "onlinestatus where `service`='{$service}'";
    $ret = DB::get_results($sql);

    $past = date_create($ret[0]->pilot_update);
    $today = date_create(date(''));
    $diff = date_diff($past, $today);

    if ($diff->format("%h%i") > 8) {
      //echo "<p>pilot update needed</p>";
      return true;
    } else {
      //echo "<p>no pilot update</p>";
      return false;
    }
  }

  /**
   * Check for the last status update.
   * Update the url only once a month.
   * @param $service check the update intervall for this service
   * @return true, if update must be performed
   */
  public static function statusUpdateNeeded($service) {

    $sql = "SELECT `status_update` from " . TABLE_PREFIX . "onlinestatus where `service`='{$service}'";
    $ret = DB::get_results($sql);

    $past = date_create($ret[0]->status_update);
    $today = date_create(date('Y-m-d'));
    $diff = date_diff($past, $today);

    if ($diff->format("%a") > 30) {
      //echo "<p>update needed</p>";
      return true;
    } else {
      //echo "<p>no update</p>";
      return false;
    }

  }
}
