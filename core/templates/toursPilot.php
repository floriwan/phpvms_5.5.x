<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<p>
  Pilot : <?php echo $pilot->firstname ?><br>
  Tour : <?php echo $tour->title ?><br>

  <?php if (count($legdata) == 0) { ?>
    tour not yet started. first leg is <?php echo $schedules[0]->flightnum ?>

  <?php } else { ?>

    <?php foreach ($legdata as $leg) {
      echo "finished leg : " . $leg->code.$leg->flightnum . " " . $leg->submitdate . "<br>";
    } ?>

    <?php
    $tourFinished = false;
    if(count($schedules) == count($legdata)) {
      $tourFinished = true;
    }

    if ($tourFinished == 1) {
      echo "tour finished";
    } else {
      if ($tour->random == 1) {
          echo "random tour, you can book any leg";
      } else {
        if ($nextLeg != 'unknown') {
          echo "next leg is : " . $nextLeg->flightnum . "<br>";
        }
      }
    }

    ?>

  <?php } ?>


</p>
