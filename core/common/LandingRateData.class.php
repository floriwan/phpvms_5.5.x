<?php


class LandingRateData extends CodonData {

  public static function getLeightLandingRate() {
    return self::getMonthlyLandingRateByWeight(0, 17500, 7);
  }

  public static function getHeavyLandingRate() {
    return self::getMonthlyLandingRateByWeight(17500, 400000, 7);
  }

  public static function getMonthlyLandingRateByWeight($weightAbove, $weightBelow, $count=7) {
    $query = "SELECT pireps.pilotid, pireps.code, pireps.flightnum, pireps.depicao, pireps.arricao, pireps.aircraft, pireps.landingrate, pireps.submitdate
          FROM `".TABLE_PREFIX."pireps` as pireps, `".TABLE_PREFIX."aircraft` as aircraft
          WHERE pireps.landingrate < '0' AND pireps.accepted = '1' AND MONTH(pireps.submitdate) = MONTH(CURDATE())
          AND $weightAbove < SUBSTRING_INDEX(aircraft.weight, ' ', 1) AND $weightBelow > SUBSTRING_INDEX(aircraft.weight, ' ', 1)
          AND pireps.aircraft = aircraft.id
          ORDER BY pireps.landingrate DESC
          LIMIT $count";
    return DB::get_results($query);
  }

  public static function getMonthlyLandingRate($count=7) {
    $query = "SELECT pilotid, code, flightnum, depicao, arricao, aircraft, landingrate, submitdate
          FROM `".TABLE_PREFIX."pireps`
          WHERE landingrate < '0' AND accepted = '1' AND MONTH(submitdate) = MONTH(CURDATE())
          ORDER BY landingrate DESC
          LIMIT $count";
    return DB::get_results($query);
  }

  public static function getMonthlyWorstLandingRate($count=7) {
    $query = "SELECT pilotid, code, flightnum, depicao, arricao, aircraft, landingrate, submitdate
          FROM `".TABLE_PREFIX."pireps`
          WHERE landingrate < '0' AND MONTH(submitdate) = MONTH(CURDATE())
          ORDER BY landingrate ASC
          LIMIT $count";
    return DB::get_results($query);
  }

  public static function getOverallLandingRate() {
    $query = "SELECT pilotid, code, flightnum, depicao, arricao, aircraft, landingrate, submitdate
        FROM `".TABLE_PREFIX."pireps`
        WHERE landingrate < '0' AND accepted = '1'
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
