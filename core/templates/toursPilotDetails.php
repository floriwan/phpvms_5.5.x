<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<p>
  Pilot : <?php echo $pilotdata->firstname ?><br>

  Tour : <?php echo $tour->name ?><br>

  <?php if (count($legdata) == 0) { ?>
    tour not yet started.
  <?php } else { ?>

    <?php foreach ($legdata as $leg) {
      echo $leg->code.$leg->flightnum . " " . $leg->submitdate . "<br>";
    } ?>

    <?php
    $tourFinished = false;
    if(count($schedules) == count($legdata)) {
      $tourFinished = true;
    }

    if ($tourFinished == 1) {
      echo "tour finished";
    } else {
      if ($nextLeg != 'unknown')
        echo "next leg is : " . $nextLeg->flightnum . "<br>";
    }

    ?>

  <?php } ?>


</p>
