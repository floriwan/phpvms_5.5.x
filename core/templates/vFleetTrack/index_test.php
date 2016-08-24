<?php
/**
 * author: f. goeldenitz
**/
?>



<center>
  <img width="100%" src="<?php echo SITE_URL?>/lib/images/fleet.jpg" alt="FlyCaribbean Fleet">
  <h3><?php echo SITE_NAME?>'s Fleet Tracker</h3>
</center>

<script type="text/javascript">

    $(document).ready(function() {

        $('#fleettable').DataTable( {
          "paging":   false,
          "order": [[ 1, "asc" ]]
        } );

    } );

</script>


<?php

  $all_aircrafts = vFleetTrackData::getAllAircraftsAirlines();

  if (!$all_aircrafts) {
    echo '<div id="error">No Aircrafts found!</div>';
		return;
  } ?>

  <table id="fleettable" class="display">
  <thead><tr><th>Logo</th>
    <th>Airline</th>
    <th>Name</th>
    <th>Full Name</th>
    <th>Registration</th>
    <th>Last Flight</th>
    <th>Location</th>
    <th>Total Flights</th>
    <th>Total Hours</th>
    <th>Total Miles</th>
  </tr></thead>

  <tfoot><tr><th>Airline</th>
    <th id="searchcol"></th>
    <th id="searchcol">Name</th>
    <th id="searchcol">Full Name</th>
    <th id="searchcol">Registration</th>
    <th>Last Flight</th>
    <th>Location</th>
    <th>Total Flights</th>
    <th>Total Hours</th>
    <th>Total Miles</th>
  </tr></tfoot>

  <tbody>

  <?php
  foreach ($all_aircrafts as $aircraft) {

    /* get the last flight for this aircraft */
    $lastflight = vFleetTrackData::getLastFlightAircraft($aircraft->id);
    if($lastflight)
    {
      if(Auth::LoggedIn() == true) {
        $last = '<a href="'.url('/pireps/view/'.$lastflight->pirepid).'">'.$lastflight->code.$lastflight->flightnum.' ('.$lastflight->depicao.' - '.$lastflight->arricao.')</a>';
      } else {
        $last = ''.$lastflight->code.$lastflight->flightnum.' ('.$lastflight->depicao.' - '.$lastflight->arricao.')';
      }
    }
    else
    {
      $last = 'No Flights Yet!';
    }

    /* get the current location */
    $location = vFleetTrackData::getLastFlightAircraft($aircraft->id);
    if($location)
    {
      $lastlocation = $location->arricao;
    }
    else
    {
      $lastlocation = 'N/A';
    }

    echo "<tr>";
    if (strlen($aircraft->alogo) > 1) echo "<td><img height=\"32\" width=\"127\" src=\"$aircraft->alogo\"></td>";
    else echo "<td></td>";
    echo "<td>".$aircraft->aname."</td>";
    echo "<td>".$aircraft->icao." (".$aircraft->name.")</td>";
    echo "<td>".$aircraft->fullname."</td>";
    echo "<td><a href='".url('/vFleetTracker/view/'.$aircraft->registration)."'>".$aircraft->registration."</a></td>";
    echo "<td>".$last."</td>";
    echo "<td>".$lastlocation."</td>";
    echo "<td>".vFleetTrackData::countFlights($aircraft->id)."</td>";
    echo "<td>".round(vFleetTrackData::countHours($aircraft->id))."</td>";
    echo "<td>".round(vFleetTrackData::countMiles($aircraft->id))."</td></tr>";

  } ?>

  </tbody>

  </table>
