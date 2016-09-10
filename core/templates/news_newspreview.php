<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<!--<p class="activity_line"><div id="activity_line"></div></p>-->

<p><div class="terminal_message"></div></p>

<h2>Airline News</h2>

<ul class="dates">

  <?php foreach ($allnews as $news) { ?>

    <li>
      <span class="date"><?php echo date('M',  $news->postdate)?><strong><?php echo date('d',  $news->postdate)?></strong></span>
      <h3><?php echo($news->postedby)?> / <?php echo($news->subject)?></h3>
      <p><?php echo substr(strip_tags($news->body), 0, 100);?> ...
        <?php echo "<td><a href=\"". url('/news') ."#news_" . $news->id . "\"><i class=\"fa fa-external-link\" aria-hidden=\"true\"></i></a></td>"; ?></p>
    </li>

  <?php } ?>

</ul>

<script type="text/javascript">

  var activities = [];

  <?php foreach($allactivities as $activity) {
    if ($activity->pilotid == 0) $pilot_code = "";
    else $pilot_code = PilotData::getPilotCode($activity->code, $activity->pilotid) . ' '; ?>

    //console.log('<?php echo $activity->submitdate ?>');
    activities.push('<?php echo substr($activity->submitdate, 0, 10) . "  " . $pilot_code . $activity->message ?>');
  <?php } ?>

  counter_two = 0;

  function nextTerminalMessage() {

    complete_message = activities[counter_two];
    //console.log($("#activity_line").width());
    //console.log($(window).width());
    max_char = Math.floor($(".terminal_message").width() / (50*0.3));

    if (complete_message.length < max_char) {
      complete_message = activities[counter_two].concat(' '.repeat(max_char - activities[counter_two].length));
    }

    var ratio = 0.3;
    $('.terminal_message')
            .splitFlap({
                speed: 6,
                speedVariation: 5,
                charWidth:  50 * ratio,
                charHeight: 100 * ratio,
                imageSize:  (2500 * ratio) + 'px ' + (100 * ratio) + 'px',
                text: complete_message,
                onComplete: function() {
                  counter_two++;
                  if(counter_two >= activities.length-1) { counter_two = 0; }
                  setTimeout(function() {nextTerminalMessage(); }, 10000) /* wait 10 sec */
                }
            });

  }

  (function ($) {
    $(document).ready(function () {
      nextTerminalMessage();
    });
  })(jQuery);


  //var elem = $('#activity_line');
  var elem = document.getElementById("activity_line");
  var counter = 0;

  //setInterval(nextMessage, 10000);

  window.onload = function() {
      //elem.innerHTML = activities[counter];
      //$('#activity_line').animate({backgroundColor: '#f8f8f8'},  'slow');
      //counter++;
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
