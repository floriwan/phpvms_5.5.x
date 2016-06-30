<?php
/**
Module Created By Vansers

This module is only use for phpVMS (www.phpvms.net) - (A Virtual Airline Admin Software)

@Created By Vansers
@Copyrighted @ 2011
@Under CC 3.0
@http://creativecommons.org/licenses/by-nc-sa/3.0/

// Version 1.0 (September 7.12) - Module Created
**/
?>
<h3><?php echo SITE_NAME?>'s Fleet Tracker</h3>

<?php
	if(!$allaircrafts)
	{
		echo '<div id="error">No Aircrafts!</div>';
		return;
	}
?>

<!--
<?php MainController::Run('vFleetTracker', 'viewallmap');?>
-->

<?php
  $all_airlines = OperationsData::getAllAirlines();
  array_push($all_airlines, 0);

  if (!all_airlines) {
    echo "<p>no airlines found</p>";
  }

  /* start one table for all airlines */
  echo "<table>";
  echo "<thead><tr><th>ICAO</th><th>Name</th><th>Full Name</th><th>Registration</th><th>Last Flight</th><th>Location</th><th>Total Flights</th><th>Total Hours</th><th>Total Miles</th></tr></thead>";
  echo "<tbody>";

  foreach ($all_airlines as $airline) {
    /*echo "<p> airlineid " . $airline->id . "</p>";*/

    $airline_aircrafts = vFleetTrackData::getAircraftsByAirline($airline->id);
    if (!$airline_aircrafts) {
      if (strlen($airline->name) != 0) {
        echo "<tr><th>".$airline->name."</th></tr>";
        echo "<tr><td>no aircrafts found for airline " . $airline->name . "</td></tr>";
      }
    } else {

      /* if the is no airline set, write fixed text */
      if (strlen($airline->name) != 0)
        echo "<tr><th colspan=\"9\">".$airline->name."</th></tr>";
      else
        echo "<tr><th colspan=\"9\">No Airline</th></tr>";

      //echo "<table>";
      //echo "<tr><th>ICAO</th><th>Name</th><th>Full Name</th><th>Registration</th><th>Last Flight</th><th>Location</th><th>Total Flights</th><th>Total Hours</th><th>Total Miles</th></tr>";

      foreach ($airline_aircrafts as $aircraft) {

        /* get the last flight for this aircraft */
        $lastflight = vFleetTrackData::getLastFlightAircraft($aircraft->id);
        if($lastflight)
        {
          $last = '<a href="'.url('/pireps/view/'.$lastflight->pirepid).'">'.$lastflight->code.$lastflight->flightnum.' ('.$lastflight->depicao.' - '.$lastflight->arricao.')</a>';
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

        echo "<tr><td>".$aircraft->icao."</td>";
        echo "<td>".$aircraft->name."</td>";
        echo "<td>".$aircraft->fullname."</td>";
        echo "<td><a href='".url('/vFleetTracker/view/'.$aircraft->registration)."'>".$aircraft->registration."</a></td>";
        echo "<td>".$last."</td>";
        echo "<td>".$lastlocation."</td>";
        echo "<td>".vFleetTrackData::countFlights($aircraft->id)."</td>";
        echo "<td>".round(vFleetTrackData::countHours($aircraft->id))."</td>";
        echo "<td>".round(vFleetTrackData::countMiles($aircraft->id))."</td></tr>";
      }
      //echo "</table>";
    }
  }

  echo "</tbody>";
  echo "</table>";

 ?>

<?php
/*
<table id="tabledlist" class="tablesorter">
<thead>
<tr>
	<th>ICAO</th>
	<th>Name</th>
	<th>Full Name</th>
	<th>Registration</th>
	<th>Last Flight</th>
    <th>Location</th>
    <th>Total Flights</th>
    <th>Total Hours</th>
    <th>Total Miles</th>
    <th>View</th>
</tr>
</thead>
<tbody>
<?php
foreach($allaircrafts as $aircraft)
{
	$lastflight = vFleetTrackData::getLastFlightAircraft($aircraft->id);
	if($lastflight)
	{
		$last = '<a href="'.url('/pireps/view/'.$lastflight->pirepid).'">'.$lastflight->code.$lastflight->flightnum.' ('.$lastflight->depicao.' - '.$lastflight->arricao.')</a>';
	}
	else
	{
		$last = 'No Flights Yet!';
	}

	$location = vFleetTrackData::getLastFlightAircraft($aircraft->id);
	if($location)
	{
		$lastlocation = $location->arricao;
	}
	else
	{
		$lastlocation = 'N/A';
	}

?>
<tr>
	<td><?php echo $aircraft->icao;?></td>
	<td><?php echo $aircraft->name;?></td>
	<td><?php echo $aircraft->fullname;?></td>
	<td><?php echo $aircraft->registration;?></td>
	<td><?php echo $last;?></td>
    <td><?php echo $lastlocation;?></td>
    <td><?php echo vFleetTrackData::countFlights($aircraft->id);?></td>
    <td><?php echo round(vFleetTrackData::countHours($aircraft->id));?></td>
    <td><?php echo round(vFleetTrackData::countMiles($aircraft->id));?></td>
    <td><a href="<?php echo url('/vFleetTracker/view/'.$aircraft->registration);?>">View Aircraft</a></td>
<?php
}
?>
</tbody>
</table>
*/ ?>
