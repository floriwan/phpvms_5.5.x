<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<div class="row">
<div class="6u 12u(mobilep)">

<table class="news_table">
  <thead><td colspan="3">latest News</td></thead>

    <?php foreach ($allnews as $news) {
      echo "<tr>";
      echo "<td>" . date('Y-m-d h:i:s', $news->postdate) . " - " . $news->postedby . "</td>";
      //echo "<td>" . $news->postedby . "</td>";

      if (strlen($news->subject) > 35)
        $news_subject = substr($news->subject, 0, 35) . "...";
      else
        $news_subject = $news->subject;


      echo "<td><strong>" . $news_subject . "</strong></td>";
      echo "<td><a href=\"". url('/news') ."#news_" . $news->id . "\"><i class=\"fa fa-external-link\" aria-hidden=\"true\"></i></a></td>";
      //echo "<td>" . preg_replace('/\s+/', '', $news->body) . "</td>";
      echo "</tr>";
    } ?>


</table>
</div>


<div class="6u 12u(mobilep)">
<table class="news_table">
  <thead><td colspan="3">latest Activities</td></thead>

  <?php foreach ($allactivities as $activity) {

    if ($activity->pilotid == 0) $pilot_code = "";
    else $pilot_code = PilotData::getPilotCode($activity->code, $activity->pilotid);

    echo "<tr>";
    echo "<td>" . $activity->submitdate . "</td>";
    echo "<td>" . $pilot_code . " " . $activity->message . "</td>";
    echo "</tr>";
  } ?>
</table>
</div>
</div>
