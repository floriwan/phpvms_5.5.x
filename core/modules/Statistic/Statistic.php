<?php
/**
 *
 * @author F. Goeldenitz
 */

class Statistic extends CodonModule {

  public function index() {

    // check login
    if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.tpl');
			return;
		}

    $this->render('statistic_main.tpl');

  }

}
