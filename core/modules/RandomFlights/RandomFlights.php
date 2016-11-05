<?php
/**
 * @author F. Göldenitz
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class RandomFlights extends CodonModule {


	public function index() {


    echo "<p>index</p>";

    $this->set('joblist', JobList::getDetailedJobList());
    $this->show('joblist/joblist_index.php');

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

    $start_value = rand($start[0], $start[1]);
    $duration_value = rand($duration[0], $duration[1]);

    echo "<p>start in $start_value days and duration is $duration_value<br>";

    $start_date = date('Y-m-d', strtotime('+'.$start_value.' Days'));
    $end_date = date('Y-m-d', strtotime('+'.$start_value+$duration_value.' Days'));
    echo "new flight is valid from $start_date until $end_date</p>";

    $random_flightnumber = SchedulesData::getRandomFlightNumber();
    //echo "random flight number: " . $random_flightnumber . "<br>";

    $selected_flight = SchedulesData::findFlight($random_flightnumber);
    //print_r($selected_flight);
    echo "<br>";
    echo "selected flight is:<br>";
    echo "flightnumber [".$selected_flight->code . $selected_flight->flightnum."]
      aircraft: " . $selected_flight->registration . "(" . $selected_flight->aircraft . ") departure: " .
       $selected_flight->depicao . " arrival: " .  $selected_flight->arricao . " distance: " . $selected_flight->distance . "<br>";

    JobList::addNewJob($selected_flight->id, $start_date, $end_date);

    //$job_list = JobList::getDetailedJobList();
  }

}

// http://localhost/flycaribbean/phpvms/index.php/RandomFlights?start=5-10&duration=5-10
//SELECT * FROM `phpvms_schedules` ORDER BY RAND() LIMIT 1SELECT * FROM `phpvms_schedules` ORDER BY RAND() LIMIT 1
