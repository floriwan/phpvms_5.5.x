<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<?php

//@author F. Goeldenitz

?>

<h3><?php echo SITE_NAME; ?> Joblist</h3>

<?php if (!Auth::LoggedIn()) {
  echo '<p>You must login to access this page</p>';
  return;
  } ?>

<?php
if (!joblist) {
  echo 'no open jobs';
} else { ?>

<center>
  <table border="1px" width="80%">
    <th>
      <td><b>start_date</b></td>
      <td><b>end date</b></td>
      <td><b>flight</b></td>
      <td><b>aircraft</b></td>
      <td><b>departure</b></td>
      <td></td>
      <td><b>arrival</b></td>
      <td><b>distance</b></td>
      <td><b>status</b></td>
      <td><b>booked by<b></td>
    </th>

    <?php foreach ($joblist as $job) {

      if ($job->pilot_id != "") $pilot = PilotData::getPilotData($job->pilot_id);

      echo "<tr>";
      echo "<td> </td>";
      echo "<td>".$job->valid_from."</td>";
      echo "<td>".$job->valid_to."</td>";
      echo "<td>".$job->code . $job->flightnum."</td>";
      echo "<td>".$job->aircraft_registration . " (" . $job->aircraft_name.")</td>";
      echo "<td>".$job->depicao."</br>";
      echo "<td><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></td>";
      echo "<td>".$job->arricao."</br>";
      echo "<td>".$job->distance."nm</br>";

      if((Auth::LoggedIn() == true) && ($job->status === "N")) {
        echo "<td><a href=\"" . SITE_URL . "/index.php/RandomFlights/bookJob?jobid=".$job->id."\"><i class=\"fa fa-paper-plane\" aria-hidden=\"true\"></i></a></td>";
      } else if ((Auth::LoggedIn() == true) && (Auth::$userinfo->pilotid == $job->pilot_id)) {
        echo "<td><a href=\"" . SITE_URL . "/index.php/RandomFlights/removeBooking?jobid=".$job->id."\"><i class=\"fa fa-eraser\" aria-hidden=\"true\"></i></td>";
      } else if (($job->status === "B")) {
        echo "<td>-</td>";
      }

//echo '<td><a href="'.SITE_URL.'/index.php/events/get_event?id='.$event->id.'">Details/Signups</a></td></tr>';
      //echo "<td>".$job->status."</br>";
      //if ($job->status === "N") echo "<td><i class=\"fa fa-address-card-o\" aria-hidden=\"true\"></i></td>";
      if ($job->status === "B") echo "<td>". PilotData::getPilotCode($pilot->code, $pilot->pilotid) . "</td>";
      else echo "<td>&nbsp;</td>";

      echo "</tr>";
    } ?>
  </table>
</center>

<p><i class="fa fa-paper-plane" aria-hidden="true"></i> - you can book this flight. This action will also set a bid for this flight.</br>
  <i class="fa fa-eraser" aria-hidden="true"></i> - you can remove the reservation of this flight.</p>





<?php
} ?>
