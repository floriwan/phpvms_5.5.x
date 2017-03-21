<?php


class LandingRateData extends CodonData {

  public static function getMonthlyLandingRate($count=7) {
    $query = "SELECT pilotid, code, flightnum, depicao, arricao, aircraft, landingrate, submitdate
          FROM `".TABLE_PREFIX."pireps`
          WHERE landingrate < '0' AND MONTH(submitdate) = MONTH(CURDATE())
          ORDER BY landingrate DESC
          LIMIT $count";
    return DB::get_results($query);
  }

  public static function getOverallLandingRate() {
    $query = "SELECT pilotid, code, flightnum, depicao, arricao, aircraft, landingrate, submitdate
        FROM `".TABLE_PREFIX."pireps`
        WHERE landingrate < '0'
        ORDER BY landingrate DESC";
    return DB::get_results($query);
  }

  public static function getOverallAverageLandingRate() {
    return self::getAverageLandingRate(self::getOverallLandingRate());
  }

  public static function getPilotLandingRate($pilotid) {
      $query = "SELECT pilotid, code, flightnum, depicao, arricao, aircraft, landingrate, submitdate
          FROM `".TABLE_PREFIX."pireps`
          WHERE landingrate < '0'
          AND pilotid = '$pilotid'
          ORDER BY landingrate DESC";
    return DB::get_results($query);
  }

  public static function getPilotAverageLandingRate($pilotid) {
    return self::getAverageLandingRate(self::getPilotLandingRate($pilotid));
  }

  /**
   * get average landing rate
   */
  public static function getAverageLandingRate($landingrates) {
    if (!empty($landingrates)) {
      $overall = 0;

      foreach ($landingrates as $landingrate) {
        $overall += $landingrate->landingrate;
      }
      return round($overall / count($landingrates));
    } else {
      return '0';
    }
  }

}

?>
