

  <div class="features-row">
    <section>
      <span class="icon major fa-map-o accent1"></span>
      <h3>Recent Reports</h3>
      <p><?php MainController::Run('PIREPS', 'RecentFrontPage', 5); ?></p>
    </section>

    <section>
      <span class="icon major fa-user accent2"></span>
      <h3>Newest Pilots</h3>
      <p><?php MainController::Run('Pilots', 'RecentFrontPage', 5); ?></p>
    </section>
  </div>

  <div class="features-row">
    <section>
      <span class="icon major fa-info accent3"></span>
      <h3>Users Online</h3>
      <p>There have been <?php echo count($usersonline)?> user(s), and <?php echo count($guestsonline);?> guest(s) online in the past <?php echo Config::Get('USERS_ONLINE_TIME')?> minutes.</p>

<?php

  $acarsdata = ACARSData::GetACARSData();

  if (!$acarsdata) {
    echo "<p>There are no pilots online at the moment.</p>";
    $acarsdata = array();
  } else {

    echo "<table><tr><th colspan=\"5\">Pilots online</th>";

    foreach($acarsdata as $acarsitem) {
      //print_r($acarsitem);

      $pilotcode = "N/A";
      if (sizeof($acarsitem->pilotid) != 0) {
        $pilotdata = PilotData::getPilotData($acarsitem->pilotid);
        $pilotcode =  PilotData::GetPilotCode($pilotdata->code, $pilotdata->pilotid);
      }
      echo "<tr>";
      echo "<td>" . $pilotcode . "</td>";
      echo "<td></td>";
      echo "<td><a href=\"".url('/vFleetTracker/view/'.$acarsitem->aircraft)."\">".$acarsitem->aircraft."</a></td>";
      echo "<td>".$acarsitem->depicao." <i class=\"icon fa-angle-right\"></i> ".$acarsitem->arricao."</td>";
      echo "<td>".$acarsitem->phasedetail."</td>";
      echo "</tr>";
    }

    echo "</table>";
  }

 ?>

    </section>

    <section>
      <span class="icon major fa-bar-chart-o accent4"></span>
      <h3>Statistics</h3>
      <p>
        <table>
          <tr><td><?php echo StatsData::PilotCount(); ?></td><td>Pilots</td></tr>
          <tr><td><?php echo StatsData::TotalFlights(); ?></td><td>Total Flights</td></tr>
          <tr><td><?php echo StatsData::TotalHours(); ?></td><td>Total Hours</td></tr>
          <tr><td><?php echo StatsData::TotalFlights(); ?></td><td>Total Flights</td></tr>
          <!--<?php echo StatsData::TotalHours(); ?></span>Total hr</li>-->
          <tr><td><?php echo StatsData::TotalFlightsToday(); ?></td><td>Flights Today</td></tr>
        </table>
      </p>
    </section>
  </div>
