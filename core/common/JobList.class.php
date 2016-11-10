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

     // first remove the old jobs
     JobList::removeOldJobs();

     // now get the amount of valid jobs
     $count = JobList::getJobsCount();

     echo "job list size:" .$count ." config list size: " . JOB_LISTSIZE . "<br";

     // and add a job if there are not enough jobs in the db
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
    * @param a valid jobid
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

      $res = DB::get_results($sql);

      if ($jobid != null)
        return $res[0];
      else
        return $res;
  }

  /**
  * get a single job
  * @param a valid jobid
  */
  public static function getJob($jobid) {
    $sql = "SELECT * FROM ". TABLE_PREFIX . "joblist WHERE id = " . $jobid;
    $res = DB::get_results($sql);

    if (!$res) {
      echo "no valid job found with jobid " . $jobid . "!";
      return;
    }
    return $res[0];

  }

  /**
  * remove jobs that are not booked and no longer valid
  * todo remove the bid from booked flights
  */
  public static function removeOldJobs() {
    $sql = "DELETE FROM `" . TABLE_PREFIX . "joblist` WHERE (status = 'N' OR status = 'B') AND valid_from < NOW()-INTERVAL 1 DAY";
    DB::query($sql);
  }

  /**
   * book a single job for a pilots and set a bid for this flight
   * @param jobid book this job
   * @param pilotid this pilot wnat to book the flight
   */
  public static function bookJob($jobid, $pilotid) {

    // is the jobid a valid id
    $job = JobList::getJob($jobid);

    if (!$job) {

      echo "the jobid " . $jobid . " is not a valid id!";
      return false;

    } else {

      echo "add a new bid on " . $job->schedule_id;
      SchedulesData::addBid($pilotid, $job->schedule_id);

      $latest_bid = SchedulesData::getLatestBid($pilotid);

      $sql = "UPDATE `" . TABLE_PREFIX . "joblist` SET `pilot_id`=".$pilotid.", `status`='B', `bid_id`=".$latest_bid->bidid." WHERE id = ".$jobid;
      DB::query($sql);

      return true;
    }

  }

  /**
  * remove the booking of the flight and delete the bid
  * @param delete thje job with this id
  * @param the pilot id
  */
  public static function removeBooking($jobid, $pilotid) {

    // is the jobid a valid id
    $job = JobList::getJob($jobid);

    // check the pilot id
    if ($job->pilot_id != Auth::$userinfo->pilotid) {
      echo "<p><b>you can only remove your own jobs!!</b></p>";
      return false;
    }

    if ($job) {

      // remove the id
      echo "<p>remove bid on " . $job->schedule_id . "<br>";
      SchedulesData::removeBid($job->bid_id);

      // and update the job table
      $sql = "UPDATE `" . TABLE_PREFIX . "joblist` SET `pilot_id`=NULL, `status`='N', `bid_id`=NULL WHERE id = ".$jobid;
      DB::query($sql);

    } else {
      echo "<p>no job found jobid " . $jobid . "</p>";
      return false;
    }



    return true;

  }

  /**
  * Try to find a job in the joblist that matches the given pirep
  */
  public static function search($pirepid) {

    echo "<p>search pirepid: " . $pirepid . "</p>";
    // get pirep details
    $pirepdetails = PIREPData::getReportDetails($pirepid);

    if (!$pirepdetails) {
      echo "<p>no pirep with id " . $pirepid . " found, can not book flight</p>";
      return false;
    }

    // get the important information and
    // search with arrival and departure and submitdate a job in the database
    $pilot_id = $pirepdetails->pilotid;
    $depicao = $pirepdetails->depicao;
    $arricao = $pirepdetails->arricao;
    $submitdate = date("Y-m-d", $pirepdetails->submitdate);

    echo "<p>found pirep pilot_id:" . $pilot_id . " depicao:" . $depicao . " arricao:" . $arricao . " submitdate:" . $submitdate . "</p>";

    $sql = "SELECT j.* FROM " . TABLE_PREFIX . "joblist AS j
      LEFT JOIN " . TABLE_PREFIX . "schedules AS s ON s.id = j.schedule_id
      WHERE j.status = 'B' AND
      j.pilot_id = " . $pilot_id . " AND
      s.arricao = '" . $arricao . "' AND
      s.depicao = '" . $depicao . "' AND
      j.valid_from <= '" . $submitdate . "' AND
      j.valid_to >= '" . $submitdate . "'";

    $res = DB::get_results($sql);

    if (!is_array($res)) {
      echo "<p>" . $sql . "</p>";
      echo "<p>no valid job found for pilotid " . $pilot_id . " and departure " . $depicao . " arrival " . $arricao . " submitdate " . $submitdate . "</p>";
      return false;
    }

    // update the found job and set the status to 'F'
    $jobid = $res[0]->id;
    echo "update jobid:" . $jobid . "</p>";
    $sql = "UPDATE `" . TABLE_PREFIX . "joblist` SET status='F' WHERE id =" . $jobid;
    DB::query($sql);

    JobList::updatePilotData($pilot_id);

  }

  /**
  * update the pilot data, increase jobcounter and grand awards
  * @param update pilot with this id
  */
  public static function updatePilotData($pilot_id) {

    // update the pilots job counter
    $jobcount = PilotData::updateJobCounter($pilot_id);

    // grand the 1st award
    if ($jobcount == 1) {

      echo "<p>check pilots awards</p>";
      $award_list = AwardsData::GetPilotAwards($pilot_id);

      if (!is_array($award_list)) {
        AwardsData::AddAwardToPilot($pilot_id, JOB_1STAWARD_ID);
      } else {

        $found = false;
        foreach ($award_list as $award) {
          if ($award->awardid == JOB_1STAWARD_ID)
            $found = true;
        }

        if (!$found) {
          AwardsData::AddAwardToPilot($pilot_id, JOB_1STAWARD_ID);
        }

      }

    }

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
