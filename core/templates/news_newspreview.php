<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<table>

    <?php foreach ($allnews as $news) {
      echo "<tr>";
      echo "<td>" . date(DATE_FORMAT, $news->postdate) . " - " . $news->postedby . "</td>";
      //echo "<td>" . $news->postedby . "</td>";
      echo "<td><strong>" . $news->subject . "</strong></td>";
      echo "<td><a href=\"". url('/news') ."#news_" . $news->id . "\"><i class=\"fa fa-external-link\" aria-hidden=\"true\"></i></a></td>";
      //echo "<td>" . preg_replace('/\s+/', '', $news->body) . "</td>";
      echo "</tr>";
    } ?>


</table>
