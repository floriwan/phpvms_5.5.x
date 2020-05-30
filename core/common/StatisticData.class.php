<?php

/**
 *  Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
 *  View license.txt in the root, or visit http://creativecommons.org/licenses/by-nc-sa/3.0/
 *
 * @author F. Göldenitz
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class StatisticData extends CodonData {

  /**
   *
   */
  public static function getJsonHoursPerMonth() {

    $years_since_start = StatsData::getYearsSinceStart();
    print_r($years_since_start);

    echo "<br>current year";
    print_r(PirepData::getIntervalCurrentYear());
    echo "<br>";
    /*foreach ($years_since_start as $year => $timeval) {
      print_r($year);
      print_r($timeval);
      # code...
    }*/

    echo "<br>";
    print_r(PIREPData::getIntervalYear("1498401065"));
    echo "<br>";
    print_r(PIREPData::getIntervalYear("2017"));
    echo "<br>";

  }

}
