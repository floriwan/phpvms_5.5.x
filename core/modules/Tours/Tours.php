<?php
/**
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class Tours extends CodonModule {

	public function index() {

    //echo "<p>index</p>";

		$allTours = TourData::getTourList(date("Y-m-d"));
    //$allTours = TourData::getTourList();
    //print_r($allTours);
    $allPilots = PilotData::getAllPilots();

    if (count($allTours) == 0) {
      echo "<div class=\"box\"><p>There is no tour active at the moment.</p></div>";
    }

    $this->render('tours_template.php');

    // show all tours
    foreach ($allTours as $tour) {

      $schedules = SchedulesData::getScheduleFlightnumRegex($tour->flightnum_regex);

      $distance = 0;

      foreach ($schedules as $schedule) {
        $distance += $schedule->distance;
      }

      $this->set('tour', $tour);
      $this->set('schedules', $schedules);
      $this->set('distance', $distance);
      $this->set('numberLegs', count($schedules));

      $this->render('tours.php');

    }

	}

  public function toursDetail($tourid = '') {

    $tour = TourData::getTour($tourid);
    $schedules = SchedulesData::getScheduleFlightnumRegex($tour->flightnum_regex);

    foreach ($schedules as $schedule) {
      $distance += $schedule->distance;
    }

    if (Auth::LoggedIn() == true) {
      $pilot = PilotData::getPilotData(Auth::$pilot->pilotid);
      $pilotStatus = TourData::getPilotStatus($tour, $pilot);
      if (!is_array($pilotStatus))
        $pilotStatus[$schedules[0]->flightnum] = 1;

    }



    $this->set('tour', $tour);
    $this->set('schedules', $schedules);
    $this->set('pilotLegs', $pilotStatus);
    $this->set('distance', $distance);
    $this->set('numberLegs', count($schedules));


    $this->render('toursDetail.php');
  }

  public function pilotTours() {
    if (Auth::LoggedIn() == true) {
      $pilot = PilotData::getPilotData(Auth::$pilot->pilotid);
      $pilotTours = TourData::getPilotTourList($pilot);

      foreach ($pilotTours as $tour) {

        $schedules = SchedulesData::getScheduleFlightnumRegex($tour->flightnum_regex);

        $distance = 0;

        foreach ($schedules as $schedule) {
          $distance += $schedule->distance;
        }

        $this->set('tour', $tour);
        $this->set('schedules', $schedules);
        $this->set('distance', $distance);
        $this->set('numberLegs', count($schedules));

        $this->render('tours.php');

      }


    }
  }

  public function pilotDetails() {

    echo "<p>pilot details</p>";

    // page only visible for logged in pilots
    if (Auth::LoggedIn() == false) {
      $this->render('pages_nopermission.tpl');
      return;
    }

    $pilot = PilotData::getPilotData(Auth::$pilot->pilotid);
    $this->set('pilot', $pilot);
    //$this->render('toursPilot.php');

    $allTours = TourData::getTourList(date("Y-m-d"));

    foreach($allTours as $tour) {

      $schedules = SchedulesData::getScheduleFlightnumRegex($tour->flightnum_regex);
      $pilotLegs = PIREPData::getAllPilotsReportForTour($pilot->pilotid,
        $tour->flightnum_regex, $tour->valid_from, $tour->valid_to);

      if ($tour->random == 0) {
        $this->set('nextLeg', self::getNextTourLeg($pilotLegs, $schedules));
      } else {
        $this->set('nextLeg', "unknown");
      }

      $this->set('schedules', $schedules);
      $this->set('tour', $tour);
      $this->set('legdata', $pilotLegs);
      $this->render('toursPilot.php');
    }



  }

  public function bookSchedule() {
    $scheduleid = $_GET[scheduleid];
    TourData::bookSchedule($scheduleid, Auth::$userinfo->pilotid);
    echo "<p>schedule " . $scheduleid . " is booked.</p>";
    $this->index();
  }

  function getNextTourLeg($pilotLegs, $schedules) {
    //echo count($pilotLegs);
    return $schedules[count($pilotLegs)];
  }

}
