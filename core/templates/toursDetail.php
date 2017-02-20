<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<!--<h2>FlyCaribbean Tours Overview</h2>-->

<div class="box">
  <h3><?php echo $tour->title ?></h3>

  <span class="image fit">
    <img src="<?php echo $tour->image ?>">
  </span>

  <p><?php echo $tour->description ?></p>

  <table>
    <thead>
      <tr>
        <th>start date</th><th>end date</th><th>num. Legs</th><th>distance</th><th></th><!--<th>tour details</th>-->
      </tr>
    </thead>

    <tbody>
      <tr>
        <?php if ($tour->valid_from == "2010-01-01" && $tour->valid_to == "2999-01-01") { ?>
          <td>always active</td>
          <td>&nbsp;</td>
        <?php } else { ?>
          <td><?php echo $tour->valid_from ?></td>
          <td><?php echo $tour->valid_to ?></td>
        <?php } ?>
        <td><?php echo $numberLegs ?></td>
        <td><?php echo $distance ?> nm</td>
        <td>
          <?php if ($tour->random == 1) { ?>
            Legs can be flown in any order
          <?php } else { ?>
            Legs must be flown in the given order
          <?php } ?>
        </td>
        <!--<td><a href="<?php echo url('/Tours/toursDetail/'.$tour->id);?>">
        <i class="fa fa-info-circle" aria-hidden="true"></i></a></td>-->
      </tr>
    </tbody>

  </table>

</div>
<div class="box">


  <?php
    $tourActive = 0;
    if (strtotime($tour->valid_from) < time() && strtotime($tour->valid_to) > time())
      $tourActive = 1;
  ?>

  <table>
    <thead>
        <tr>
            <th>Legumber</th>
            <th>Departure</th>
            <th></th>
            <th>Destination</th>
            <th>distance</th>
        </tr>
    </thead>

    <tbody>

    <?php $oldState = 0;
      foreach ($schedules as $key => $schedule) { ?>
      <tr>
        <td><?php echo $schedule->code . $schedule->flightnum ?></td>
        <td><?php echo $schedule->depicao ?></td>
        <td><i class="icon fa-angle-right"></i></td>
        <td><?php echo $schedule->arricao ?></td>
        <td><?php echo $schedule->distance ?>nm</td>
        <td><?php if (Auth::LoggedIn()) { ?>
          <a href="<?php echo url('/schedules/details/'.$schedule->id);?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
        <?php } ?>



        <td>
          <?php

          if (!Auth::LoggedIn())
              continue;
            if ($tourActive == 1 && $key == 0 && $pilotLegs[$schedule->flightnum] == 0) { ?>
            <a href="<?php echo SITE_URL . "/index.php/Tours/bookSchedule?scheduleid=" . $schedule->id ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
            <!--<a href="<?php echo actionurl('/schedules/addbid/?id='.$schedule->id);?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>-->
          <?php } elseif ($tourActive == 1 && $oldState == 1 && $pilotLegs[$schedule->flightnum] == 0 && $tour->random == 0) { ?>
            <a href="<?php echo SITE_URL . "/index.php/Tours/bookSchedule?scheduleid=" . $schedule->id ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
            <!--<a href="<?php echo actionurl('/schedules/addbid/?id='.$schedule->id);?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>-->
          <?php } elseif ($tourActive == 1 && $pilotLegs[$schedule->flightnum] == 0 && $tour->random == 1) { ?>
            <a href="<?php echo SITE_URL . "/index.php/Tours/bookSchedule?scheduleid=" . $schedule->id ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
            <!--<a href="<?php echo actionurl('/schedules/addbid/?id='.$schedule->id);?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>-->
          <?php } elseif ($pilotLegs[$schedule->flightnum] == 1) { ?>
          <i class="fa fa-check" aria-hidden="true"></i>
        <?php } ?>

      </tr>
    <?php $oldState = $pilotLegs[$schedule->flightnum]; } ?>

  </tbody>
  </table>

  </div>


  <?php
  $tourActive = false;

  $tourTable = "<div class=\"box\"><h3>Active pilots on this tour</h3><table><thead><tr><th>Pilot</th>";
  for ($i=0; $i < count($schedules); $i++) {
    $tourTable .= "<th>" . ($i+1) . "</th>";
  }
  $tourTable .= "</tr></thead>";
  $tourTable .= "<tbody>";

  foreach($allpilots as $pilot) {

    $pilotStatus = TourData::getPilotStatus($tour, $pilot);

    // if the first leg is accepted, the tour is active for this pilot
    if ($pilotStatus[$schedules[0]->flightnum] == 1) {
      $tourActive = true;

      $tourTable .= "<tr><td>". PilotData::GetPilotCode($pilot->code, $pilot->pilotid) . " " . $pilot->firstname . " " . $pilot->lastname . "</td>";

      foreach ($schedules as $key => $schedule) {
        if ($pilotStatus[$schedule->flightnum] == 1)
          $tourTable .= "<td><i class=\"fa fa-check\" aria-hidden=\"true\"></i></td>";
        else
          $tourTable .= "<td>&nbsp;</td>";
      }

    }
    $tourTable .= "</tr>";
  }

  $tourTable .= "</tbody></table></div>";

  echo $tourTable;

  ?>
