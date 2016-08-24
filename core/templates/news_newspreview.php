<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<p class="activity_line"><div id="activity_line">test</div></p>

<table>
  <thead><td colspan="3">latest News</td></thead>

    <?php foreach ($allnews as $news) {
      echo "<tr>";
      echo "<td><strong>" . date('Y-m-d h:i:s', $news->postdate) . "</strong> " . $news->postedby . "</td>";
      //echo "<td>" . $news->postedby . "</td>";

      echo "<td><strong>" . $news->subject . "</strong></td>";
      echo "<td><a href=\"". url('/news') ."#news_" . $news->id . "\"><i class=\"fa fa-external-link\" aria-hidden=\"true\"></i></a></td>";
      //echo "<td>" . preg_replace('/\s+/', '', $news->body) . "</td>";
      echo "</tr>";
    } ?>


</table>

<script type="text/javascript">

  var activities = [];

  <?php foreach($allactivities as $activity) {
      if ($activity->pilotid == 0) $pilot_code = "";
      else $pilot_code = PilotData::getPilotCode($activity->code, $activity->pilotid) . ' '; ?>
      activities.push('<?php echo $activity->submitdate . " - " . $pilot_code  . $activity->message ?>');
  <?php } ?>

  //var elem = $('#activity_line');
  var elem = document.getElementById("activity_line");
  var counter = 0;

  setInterval(nextMessage, 10000);

  window.onload = function() {
      elem.innerHTML = activities[counter];
      $('#activity_line').animate({backgroundColor: '#f8f8f8'},  'slow');
      counter++;
  };

  function nextMessage() {

      $('#activity_line').fadeOut(500, function() {
        $('#activity_line').html(activities[counter]).fadeIn(500);
      });

      counter++;
      if(counter >= activities.length-1) { counter = 0; }
  }

  function setEmpty() {
    $('#activity_line').html("&nbsp;");
  }
</script>
