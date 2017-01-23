<?php

/*
 * @author F. Goeldenitz
 */


class Tours extends CodonModule {

  /**
   * Tours::HTMLHead()
   *
   * @return
   */
  public function HTMLHead() {

    echo "<p>".$this->controller->function."</p>";
    switch ($this->controller->function)
    {
      case 'listtours':
      case 'showtour':
        $this->set('sidebar', 'sidebar_tours.php');
        break;
    }

  }

  /**
   * Tours::index()
   *
   * @return
   */
  public function index() {
    $this->listtours();
  }

  public function listtours() {
    $this->set('alltours', TourData::getTourList());
    $this->render('tours_list.php');
  }

  public function showtour() {
    //echo "<p>Tour".$this->get->tourID."</p>";
    $tourdata = TourData::getTour($this->get->tourID);
    $this->set('tourdata', $tourdata);
    $this->set('allpilots', PilotData::getAllPilots());
    $this->set('schedules', SchedulesData::getScheduleFlightnumRegex($tourdata->flightnum_regex));
    $this->render('tours_details.php');
  }
}
