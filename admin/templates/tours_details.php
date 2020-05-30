<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<?php
if(!$tourdata) {
	echo '<p>There is no tour set!</p>';
	return;
}
?>

<h3><?php echo $tourdata->title; ?></h3>

<p><img src="<?php echo $tourdata->image; ?>"></p>

<p><?php echo $tourdata->description; ?></p>

<p>start : <?php echo $tourdata->valid_from; ?> end : <?php echo $tourdata->valid_to; ?></p>

<?php if ($tourdata->random == 1)
  echo "<p>Fly legs in random order</p>";
else
  echo "<p>Fly legs in the given order</p>"; ?>

<p>Flightnumber regular expression : <pre><?php echo $tourdata->flightnum_regex; ?></pre></p>


<?php

  $outstr = "";
  $tourstart = 0;

  foreach ($allpilots as $pilot) {
    $outstr = "<p>" . PilotData::GetPilotCode($pilot->code, $pilot->pilotid) . " / " . $pilot->firstname . " " . $pilot->lastname . "<br>";
    $pilotstatus = TourData::getPilotStatus($tourdata, $pilot);

    foreach ($schedules as $schedule) {
      if ($pilotstatus[$schedule->flightnum] == 1) {
        $outstr .= $schedule->flightnum . " / ";
        $tourstart = 1;
      }
    }

    if ($tourstart == 1)
      echo $outstr;

    $outstr = "";
    $tourstart = 0;

  }
 ?>
