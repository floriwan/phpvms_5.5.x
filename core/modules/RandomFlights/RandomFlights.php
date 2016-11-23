<?php
/**
 * @author F. Göldenitz
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class RandomFlights extends CodonModule {


	public function index() {


    echo "<p>index</p>";

    $this->set('joblist', JobList::getDetailedJobList(null));
    $this->show('joblist/joblist_index.php');

	}

  public function removeBooking() {
    echo "<p>removeBooking</p>";

    $jobid = $_GET[jobid];

    $ret = JobList::removeBooking($jobid, Auth::$userinfo->pilotid);

    if ($ret) {
      $booked_job = JobList::getDetailedJobList($jobid);
      echo "<p> removed booking of flight " . $booked_job->code . $booked_job->flightnum . " from " . $booked_job->depicao . " to " . $booked_job->arricao . " </p>";
    } else {
      echo "<p>can not remove this job from the booked list";
    }

    $this->set('joblist', JobList::getDetailedJobList(null));
    $this->show('joblist/joblist_index.php');

  }

  public function bookJob() {
    echo "<p>bookJob</p>";

    $jobid = $_GET[jobid];

    JobList::bookJob($jobid, Auth::$userinfo->pilotid);

    $booked_job = JobList::getDetailedJobList($jobid);
    echo "<p> booked flight " . $booked_job->code . $booked_job->flightnum . " from " . $booked_job->depicao . " to " . $booked_job->arricao . " </p>";

    $this->set('joblist', JobList::getDetailedJobList(null));
    $this->show('joblist/joblist_index.php');

  }

  /**
   * !! test function !!
  */
  public function testSend() {
    $pirepid = $_GET[pirepid];
    JobList::search($pirepid);

    JobList::updatePilotData(5);
  }

  public function generateJob() {

    echo "<p>generateJob</p>";
    $start_string = $_GET[start];
    $duration_string = $_GET[duration];

    if (!$start_string) {
      echo "<p>start string not set!</p>";
      return;
    }

    if (!$duration_string) {
      echo "<p>duration string not set!</p>";
      return;
    }

    $start = explode("-", $start_string);
    $duration = explode("-", $duration_string);

    //echo "<p>flight will start in $start[0] to $start[1] days<br>";
    //echo "<p>and is valid between $duration[0] and $duration[1] days</p>";

    JobList::fillJobList($start[0], $start[1], $duration[0], $duration[1]);

  }

}

// http://localhost/flycaribbean/phpvms/index.php/RandomFlights?start=5-10&duration=5-10
//SELECT * FROM `phpvms_schedules` ORDER BY RAND() LIMIT 1SELECT * FROM `phpvms_schedules` ORDER BY RAND() LIMIT 1
