<?php
/**
 * @author F. Goeldenitz
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

 class TourData extends CodonData {

   /**
    * return a list of all valid tours
    */
   public static function getTourList($currentDate = "2010-01-01") {

     if ($currentDate == "2010-01-01") {
       $sql = "SELECT * FROM " . TABLE_PREFIX . "tours";
     } else {
       $sql = "SELECT * FROM " . TABLE_PREFIX . "tours
       WHERE '" . $currentDate . "' >= valid_from AND '" . $currentDate . "' <= valid_to";
     }
     //echo "<p>" . $sql . "</p>";
     $res = DB::get_results($sql);

     if (!$res) {
       return array();
     } else {
       return $res;
     }
   }

   public static function getPilotStatus($tour, $pilot) {

     $pilotStatus = array();

     // get all tour schedules
     $schedules = SchedulesData::getScheduleFlightnumRegex($tour->flightnum_regex);

     // search the first leg in the schedule table
     //echo "<p>search reports : " . $pilot->pilotid . " / " . $tour->flightnum_regex . " / " . $tour->valid_from . " / " . $tour->valid_to . "</p>";
     $pilotSchedules = PIREPData::getAllPilotsReportForTour($pilot->pilotid, $tour->flightnum_regex, $tour->valid_from, $tour->valid_to);
     if (!is_array($pilotSchedules)) $pilotSchedules = array();
     //echo "pilot schedules : "; print_r($pilotSchedules);

     //if (!is_array($pilotSchedules))
    //  return $pilotSchedules;

     //echo "<p>pilot schedule : " . $pilot->pilotid . $tour->flightnum_regex . $tour->valid_from . $tour->valid_to . "</p>";
     //print_r($pilotSchedules);

     $valid_from = $tour->valid_from;
     $valid_to = $tour->valid_to;
     //echo "<p>check pilot status valid_from " . $valid_from . " valid_to " . $valid_to . "</p>";

     foreach($schedules as $schedule) {
       $pirep = self::isScheduleInPirep($schedule, $pilotSchedules, $valid_from, $valid_to);
       if ($pirep != 0) {
         $pilotStatus[$schedule->flightnum] = 1;
         $valid_from = date('Y-m-d', $pirep->submitdate);
       } else {
         $pilotStatus[$schedule->flightnum] = 0;
       }

     }

     // cleanup the status array
     if ($tour->random == 0) {
       $clearAllValues = false;
       foreach ($pilotStatus as $key => $currentStatus) {
         if ($currentStatus == 0) {
           $clearAllValues = true;
         }

        if ($clearAllValues == true) {
          $pilotStatus[$key] = 0;
        }
       }
     }

     print_r($pilotStatus);
     return $pilotStatus;

   }

   private static function isScheduleInPirep($schedule, $pireps, $valid_from, $valid_to) {
     //echo "<p> is schedule " . $schedule->flightnum . " in pirep ...</p>";
/*
echo "<p>".$valid_from."</p>";
print_r(strtotime($valid_to));
echo "<br>";
print_r(strtotime($pirep->submitdate));
echo "<br>";
*/

     foreach ($pireps as $pirep) {
//       print_r($pirep->submitdate);
//       echo "<br>";

       //echo "<p> pirep submitate : " . $pirep->submitdate . $date->format('Y-m-d') . "</p>";
//       echo "<p> compare : " . $pirep->flightnum."==".$schedule->flightnum . " && " . $valid_from .
//          "<=". $pirep->submitdate . " && " . $valid_to .">=". $pirep->submitdate. "</p>";
       if ($pirep->flightnum == $schedule->flightnum &&
        strtotime($valid_from) <= $pirep->submitdate && strtotime($valid_to) >= $pirep->submitdate) {
         //echo "<p> return pirep</p>";
         return $pirep;
       }
     }
     //echo "<p> return 0</p>";
     return 0;
   }

   public static function getTour($tourid) {
     $sql = "SELECT * FROM " . TABLE_PREFIX . "tours WHERE id = " . $tourid;
     $res = DB::get_row($sql);
     return $res;
   }

   /**
    * book the next schedule from the tour
    */
   public static function bookSchedule($scheduleid, $pilotid) {
    echo "<p>TourData::bookSchedule " . $pilotid. " " . $scheduleid . "</p>";
    SchedulesData::addBid($pilotid, $scheduleid);
    $latest_bid = SchedulesData::getLatestBid($pilotid);
    print_r($latest_bid);
   }

   /**
   * get a list of tours which are active at the given date
   */
   public static function getActiveTourList() {

   }

   /**
   */
   public static function getScheduleList($flightnum_regex) {

   }

 }

 ?>
