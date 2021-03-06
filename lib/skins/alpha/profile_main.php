
  <div class="features-row">
  <section>
    <span class="icon major fa-user accent2"></span>
      <h3>My Profile</h3>
      <p>
      <strong>Your Pilot ID: </strong> <?php echo $pilotcode; ?><br />
      <strong>Your Rank: </strong><?php echo $userinfo->rank;?><br />
      <strong>IVAO ID: </strong><?php echo $pilot->ivao_id;?><br />
      <?php

      $landingrate = LandingRateData::getPilotAverageLandingRate($pilot->pilotid);

      if($report)
      { ?>
        <strong>Latest Flight: </strong><a href="<?php echo url('pireps/view/'.$report->pirepid); ?>">
            <?php echo $report->code . $report->flightnum; ?></a>
        <br />
        <strong>Landing Rate: </strong><?php echo $landingrate ?><br />
      <?php
      }
      ?>

      <strong>Total Flights: </strong><?php echo $userinfo->totalflights?><br />
      <strong>Total Hours: </strong><?php echo $userinfo->totalhours; ?><br />
      <strong>Total Transfer Hours: </strong><?php echo $userinfo->transferhours?><br />
      <strong>Total Money: </strong><?php echo FinanceData::FormatMoney($userinfo->totalpay) ?><br />

      <?php
      if($nextrank)
      {
      ?>
        <p>You have <?php echo ($nextrank->minhours - $pilot_hours)?> hours
          left until your promotion to <?php echo $nextrank->rank?></p>
      <?php
      }
      ?>

    </p>
  </section>

  <section>
    <span class="icon major fa-trophy accent3"></span>
    <h3>Upcoming Events</h3>
    <p>
    <?php
      $events = EventsData::get_upcoming_events();

      if (!$events) {
        echo 'No Upcoming Events';
      } else {
        echo '<table>';
        foreach($events as $event) { ?>
          <tr>
            <td> <?php echo date('Y-m-d', strtotime($event->date)) ?> </td>
            <td> <?php echo $event->title ?></td>
            <td> <?php echo '<td><a href="'.SITE_URL.'/index.php/events/get_event?id='.$event->id.'">' ?> <i class="fa fa-sign-in" aria-hidden="true"></i> </a></td>
          </tr>
        <?php }
        echo '</table>';
      }
    ?>
    </p>

  </section>

  </div>

  <div class="features-row">
  <section>
    <span class="icon major fa-area-chart accent4"></span>
      <h3>My Last Flights</h3>
      <p>
      <?php
      $pilotid = PilotData::getProperPilotID($pilotcode);
      $reports = PIREPDATA::getLastReports($pilotid, 10);

      if(!$reports) {
      	echo 'No reports have been filed';
      } else {

        echo "<table>";

        foreach($reports as $report) { ?>
          <tr>
            <td><a href="<?php echo url('/pireps/viewreport/'.$report->pirepid);?>">#<?php echo $report->pirepid; ?></a></td>
            <td><?php echo $report->code.$report->flightnum;?></td>
            <td><?php echo $report->depicao?> <i class="icon fa-angle-right"></i> <?php echo $report->arricao?></td>
          </tr>

          <?php }
        echo "</table>";

      } ?>

    </p>
  </section>

  <section>
    <span class="icon major fa-cloud accent1"></span>
      <h3>Weather</h3>
      <p>
        <?php
        //include 'include.php';

        $pilotid = PilotData::getProperPilotID($pilotcode);
        $reports = PIREPDATA::getLastReports($pilotid, 1);

        MainController::Run('Weather', 'request_metar', $reports->arricao);

        //Weather::request_metar($reports->arricao);
        //echo "<p> new weather : " . $metar . "</p>";

        //print_r( WeatherData::get_metar($reports->arricao));
        //echo "<p> new weather : " . WeatherData::get_metar($reports->arricao)['altim_in_hg'] . "</p>";

        //if(!$reports) {
        //	echo 'No reports have been found';
        //} else {
        //  get_metar($reports->arricao);
        //}
        ?>
      </p>
  </section>

  </div>
