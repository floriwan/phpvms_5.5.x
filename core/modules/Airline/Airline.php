<?php
/**
 *
 * @author Florian Göldenitz
 * @copyright
 * @link
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class Airline extends CodonModule {

    /**
     * Activity::index()
     *
     * @return void
     */
    public function index() {

      // get the active airlines only
      $airlines = OperationsData::getAllAirlines(true);
      $this->set("allairlines", $airlines);
      $this->render("airline_list.php");

    }

    /**
     * Activity::frontpage()
     *
     * @param integer $count
     * @return void
     */
    public function frontpage() {
    }

}
