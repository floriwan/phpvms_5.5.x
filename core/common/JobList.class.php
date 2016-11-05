<?php
/**
 * @author F. Goeldenitz
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

 class JobList extends CodonData {

   /**
    * add a new job into the database
    * @param schedule_id the reference into the schedule table
    * @param job start duration_value
    * @param job end data
    */
   public static function addNewJob($schedule_id, $valid_from, $valid_to) {

     $count = JobList::getJobsCount();

     echo "job list size:" .$count ." config list size: " . JOB_LISTSIZE . "<br";

     if ($count < JOB_LISTSIZE) {
       $sql = "INSERT INTO " . TABLE_PREFIX . "joblist (schedule_id, status, valid_from, valid_to) VALUES (".$schedule_id.", 'N', '".$valid_from."','".$valid_to."')";
       //echo "sql : " . $sql . "<br>";

       $res = DB::query($sql);
       if (DB::errno() != 0) return false;
     } else {
       echo "<br><br>job list is full<br>";
     }

     return true;

   }

   /**
    * get a detailed list of open and booked jobs
    */
  public static function getDetailedJobList($jobid) {

    if ($jobid != null)
      $where_statement = " AND joblist.id = ".$jobid." ";

    $sql = "SELECT joblist.*,
        schedules.code as code, schedules.flightnum as flightnum, schedules.distance as distance,
        dep_airport.icao as depicao, arr_airport.icao as arricao,
        aircraft.registration as aircraft_registration, aircraft.fullname as aircraft_name
        FROM phpvms_joblist AS joblist
        LEFT JOIN phpvms_schedules AS schedules ON schedules.id = joblist.schedule_id
        LEFT JOIN phpvms_airports AS dep_airport ON dep_airport.icao = schedules.depicao
        LEFT JOIN phpvms_airports AS arr_airport ON arr_airport.icao = schedules.arricao
        LEFT JOIN phpvms_aircraft AS aircraft ON aircraft.id = schedules.aircraft
        WHERE (joblist.status = 'N' OR joblist.status = 'B') " . $where_statement . "
        ORDER BY joblist.valid_from, joblist.valid_to";

        //echo "sql : " . $sql . "<br>";

      $res = DB::get_results($sql);

      if ($jobid != null)
        return $res[0];
      else
        return $res;
  }

  /**
   * book a single job for a pilots
   * @param jobid book this job
   * @param pilotid this pilot wnat to book the flight
   */
  public static function bookJob($jobid, $pilotid) {

    $sql = "UPDATE `" . TABLE_PREFIX . "joblist` SET `pilot_id`=".$pilotid.", `status`='B' WHERE id = ".$jobid;
    DB::query($sql);

  }

  /**
  *
  */
  public static function removeBooking($jobid, $pilotid) {

    $sql = "UPDATE `" . TABLE_PREFIX . "joblist` SET `pilot_id`=NULL, `status`='N' WHERE id = ".$jobid;
    DB::query($sql);

  }

   /**
    * count the open jobs in the database
    */
   public static function getJobsCount() {
     $sql = "SELECT count(*) as jobsize FROM " . TABLE_PREFIX . "joblist WHERE status = 'N'";
     $res = DB::get_row($sql);
     return $res->jobsize;
   }


 }

 ?>
