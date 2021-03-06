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
<h3><?php echo SITE_NAME?>'s Fleet Tracker For <?php echo $aircraft->fullname;?> (<?php echo $aircraft->registration;?>)</h3>
<br />
<p><center>
  <?php if(!empty($aircraft->imagelink)) echo '<img style="max-width:700px;" src="'.$aircraft->imagelink.'" />'; ?>
</center></p>

<table>
  <thead><tr>
    <th>Aircraft General Info</th>
  </tr></thead>
  <tr>
    <td>ICAO</td>
    <td><?php echo $aircraft->icao;?></td>
  </tr>
  <tr>
    <td>Name</td>
    <td><?php echo $aircraft->name;?></td>
  </tr>
  <tr>
    <td>Fullname</td>
    <td><?php echo $aircraft->fullname;?></td>
  </tr>
  <tr>
    <td>Registration</td>
    <td><?php echo $aircraft->registration;?></td>
  </tr>

  <tr>
    <td>SELCAL</td>
    <td><?php echo $aircraft->selcal;
      if ($aircraft->selcal)
      echo " <a target=\"_blank\" href=\"https://en.wikipedia.org/wiki/SELCAL\"><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i</a>"
    ?>
  </tr>

  <tr>
    <td>Navigation Equipment (flightplan item 10)</td>
    <td><?php echo $aircraft->equipment;
      if ($aircraft->equipment)
      echo " <a target=\"_blank\" href=\"https://en.wikipedia.org/wiki/Equipment_codes\"><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i</a>"
    ?>
  </tr>

  <tr>
    <td>Additional Information (flightplan item 18)</td>
    <td><?php echo $aircraft->field18; ?>
  </tr>

  <tr>
    <td>Range (nm)</td>
    <td><?php echo $aircraft->range;?></td>
  </tr>
  <tr>
    <td>Weight (lbs)</td>
    <td><?php echo $aircraft->weight;?></td>
  </tr>
  <tr>
    <td>Cruise (ft)</td>
    <td><?php echo $aircraft->cruise;?></td>
  </tr>
  <tr>
    <td>Passanger</td>
    <td><?php echo $aircraft->maxpax;?></td>
  </tr>
  <tr>
    <td>Cargo (lbs)</td>
    <td><?php echo $aircraft->maxcargo;?></td>
  </tr>

  <thead><tr>
    <th>Aircraft Stats</th>
  </tr></thead>
  <tr>
    <td>Total Miles</td>
    <td><?php echo round(vFleetTrackData::countMiles($aircraft->id));?></td>
  </tr>
  <tr>
    <td>Total Hours</td>
    <td><?php echo round(vFleetTrackData::countHours($aircraft->id));?></td>
  </tr>
  <tr>
    <td>Total Flights</td>
    <td><?php echo vFleetTrackData::countFlights($aircraft->id);?></td>
  </tr>
  <tr>

    <?php if(count(vFleetTrackData::CargoAircraft($aircraft->id)) > 0)
    {
    ?>
    <td>Total Passengers Carried </td><td><?php echo vFleetTrackData::countPassengers($aircraft->id);?></td>
    <?php
    }
    else
    {
    ?>
    <td>Total Cargo Carried </td><td><?php echo round(vFleetTrackData::countPassengers($aircraft->id));?></td>
    <?php
    }
    ?>

  </tr>

</table>

<?php
  $liveries = AircraftData::getLiveries($aircraft->id);
  if (!$liveries) $liveries = [];

  if (sizeof($liveries) > 0) { ?>
    <h3>Liveries</h3>

    <table>
    <?php foreach ($liveries as $livery) { ?>

      <tr><td>
        <?php switch($livery->sim) {
        case 1: echo "FSX"; break;
        case 2: echo "P3D"; break;
        case 3: echo "X-Plane"; break;
      } ?>
      </td>
      <td><?php echo $livery->desc ?></td>
      <td><a target="_blank" href="<?php echo $livery->link ?>"> <i class="fa fa-external-link" aria-hidden="true"></i> </a></td>

    <?php } ?>
    </table>
  <?php }

?>



<h3>Current Aircraft Location</h3>
<?php
$location = vFleetTrackData::getLastFlightAircraft($aircraft->id);
if($location)
{
	$airport = OperationsData::getAirportInfo($location->arricao);
?>
<div class="mapcenter" align="center">
<div id="currentlocation" style="width: 960px; height: 520px;"></div>
</div>

<script type="text/javascript">
var options = {
	zoom: 10,
	mapTypeId: google.maps.MapTypeId.ROADMAP
}

var map = new google.maps.Map(document.getElementById("currentlocation"), options);
var flightMarkers = [];
current_location = new google.maps.LatLng(<?php echo $airport->lat?>, <?php echo $airport->lng?>);
flightMarkers[flightMarkers.length] = new google.maps.Marker({
		position: current_location,
		map: map,
		title: "<?php echo "$airport->name ($airport->icao)";?>"
	});

/*
if(flightMarkers.length > 0)
{
	var bounds = new google.maps.LatLngBounds();
	for(var i = 0; i < flightMarkers.length; i++) {
		bounds.extend(flightMarkers[i].position);
	}
}

map.fitBounds(bounds);*/

map.setCenter(new google.maps.LatLng(<?php echo $airport->lat?>, <?php echo $airport->lng?>));
map.setZoom(14);

</script>
<?php
}
else
{
	echo 'There is no aircraft location yet!';
}
?>


<h3>Latest 15 Flights List</h3>
<?php MainController::Run('vFleetTracker', 'buildLastFlightTable', $aircraft->id, 15);?>

<h3>Latest 15 Flights Map</h3>
<?php
//There are two different types of maps you can use. The GCMap or the Google Map.
//To use Google Map, uncomment the google map part and comment in the GCMap.
?>

<?php
	$pirep_list = vFleetTrackData::getLastNumFlightsAircraft($aircraft->id, 15);
	$gcstrg = "";
  if ($pirep_list)
  {
	   foreach($pirep_list as $pirep)
	    {
		      $gcstrg = $gcstrg.$pirep->depicao.'+-+'.$pirep->arricao.',+';
	       }
  } else {
    echo 'There are no pireps found!';
  }
?>

<?php
/*

<img src="http://www.gcmap.com/map?P=<?php echo $gcstrg ?>" /><br />
Maps generated by the <a href="http://www.gcmap.com/">Great Circle Mapper</a>&nbsp;- copyright &copy <a href="http://www.kls2.com/~karl/">Karl L. Swartz</a>
*/
?>


<div class="mapcenter" align="center">
<div id="routemap" style="width: 960px; height: 520px;"></div>
</div>

<script type="text/javascript">
var options = {
	mapTypeId: google.maps.MapTypeId.ROADMAP
}

var map = new google.maps.Map(document.getElementById("routemap"), options);
var flightMarkers = [];

<?php
$shown = array();
$pirep_list = vFleetTrackData::getLastNumFlightsAircraft($aircraft->id, 15);
if (!$pirep_list) $pirep_list = [];
foreach($pirep_list as $pirep) {
	// Dont show repeated routes
  if(in_array($pirep->code.$pirep->flightnum.$pirep->depicao.$pirep->arricao, $shown))
		continue;
	else
		$shown[] = $pirep->code.$pirep->flightnum;

	if(empty($pirep->arrlat) || empty($pirep->arrlng)
		|| empty($pirep->deplat) || empty($pirep->deplng))
	{
		continue;
	}
?>
	dep_location = new google.maps.LatLng(<?php echo $pirep->deplat?>, <?php echo $pirep->deplng?>);
	arr_location = new google.maps.LatLng(<?php echo $pirep->arrlat?>, <?php echo $pirep->arrlng?>);

	flightMarkers[flightMarkers.length] = new google.maps.Marker({
		position: dep_location,
		map: map,
		title: "<?php echo "$pirep->depname ($pirep->depicao)";?>"
	});

	flightMarkers[flightMarkers.length] = new google.maps.Marker({
		position: arr_location,
		map: map,
		title: "<?php echo "$pirep->arrname ($pirep->arricao)";?>"
	});

	var flightPath = new google.maps.Polyline({
		path: [dep_location, arr_location],
		geodesic: true,
		strokeColor: "#FF0000", strokeOpacity: 0.5, strokeWeight: 2
	}).setMap(map);
<?php
}
?>

if(flightMarkers.length > 0)
{
	var bounds = new google.maps.LatLngBounds();
	for(var i = 0; i < flightMarkers.length; i++) {
		bounds.extend(flightMarkers[i].position);
	}
}

map.fitBounds(bounds);
</script>

<h3>Available Flights</h3>

<?php MainController::Run('vFleetTracker', 'buildFlightsAvbTable', $aircraft->id);?>
