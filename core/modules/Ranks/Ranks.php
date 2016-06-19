<?php
/**
 *
 * @author Florian Göldenitz
 * @copyright
 * @link
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class Ranks extends CodonModule {

    /**
     * Activity::index()
     *
     * @return void
     */
    public function index() {
      $rank_infos = RanksData::getAllRanks();

      if (!rank_infos) {
        $rank_infos = array();
      }

      $this->set("allranks", $rank_infos);
      $this->render("ranks_list.tpl");

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
