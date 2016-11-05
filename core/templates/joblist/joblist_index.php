<?php

//@author F. Goeldenitz

?>

<h3><?php echo SITE_NAME; ?> Joblist</h3>

<?php
if (!joblist) {
  echo 'no open jobs';
} else { ?>

<center>
  <table border="1px" width="80%">
    <tr>
      <td><b>start date</b></td>
      <td><b>end date</b></td>
      <td><b>flight</b></td>
      <td><b>aircraft</b></td>
      <td><b>departure</b></td>
      <td><b>arrival</b></td>
      <td><b>distance</b></td>
      <td><b>status</b></td>
      <td><b></b></td>
    </tr>

    <?php foreach ($joblist as $job) {

      if ($job->pilot_id != "") $pilot = PilotData::getPilotData($job->pilot_id);

      echo "<tr>";
      echo "<td>".$job->valid_from."</td>";
      echo "<td>".$job->valid_to."</td>";
      echo "<td>".$job->code . $job->flightnum."</td>";
      echo "<td>".$job->aircraft_registration . " (" . $job->aircraft_name.")</td>";
      echo "<td>".$job->depicao."</br>";
      echo "<td>".$job->arricao."</br>";
      echo "<td>".$job->distance."nm</br>";
      echo "<td>".$job->status."</br>";
      if ($job->status === "N") echo "<td><i class=\"fa fa-address-card-o\" aria-hidden=\"true\"></i></td>";
      if ($job->status === "B") echo "<td>". PilotData::getPilotCode($pilot->code, $pilot->pilotid) . "</td>";

      echo "</tr>";
    } ?>
  </table>
</center>



<?php
} ?>
