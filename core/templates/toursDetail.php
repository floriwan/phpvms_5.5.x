<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<!--<h2>FlyCaribbean Tours Overview</h2>-->

<div class="box">
  <h3><?php echo $tour->title ?></h3>

  <span class="image fit">
    <img src="<?php echo $tour->image ?>">
  </span>

  <p><?php echo $tour->description ?></p>

  <table>
    <thtead>
      <tr>
        <th>start date</th><th>end date</th><th>num. Legs</th><th>distance</th><th></th><th>tour details</th>
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
        <td><a href="<?php echo url('/Tours/toursDetail/'.$tour->id);?>">
        <i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
      </tr>
    </tbody>

  </table>

<hr>

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
          <?php if (!Auth::LoggedIn())
              continue;
            if ($key == 0 && $pilotLegs[$schedule->flightnum] == 0) { ?>
            <a href="<?php echo SITE_URL . "/index.php/Tours/bookSchedule?scheduleid=" . $schedule->id ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
            <!--<a href="<?php echo actionurl('/schedules/addbid/?id='.$schedule->id);?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>-->
          <?php } elseif ($oldState == 1 && $pilotLegs[$schedule->flightnum] == 0 && $tour->random == 0) { ?>
            <a href="<?php echo SITE_URL . "/index.php/Tours/bookSchedule?scheduleid=" . $schedule->id ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
            <!--<a href="<?php echo actionurl('/schedules/addbid/?id='.$schedule->id);?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>-->
          <?php } elseif ($pilotLegs[$schedule->flightnum] == 0 && $tour->random == 1) { ?>
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
