<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<h2>Airline News</h2>

<table>

    <?php foreach ($allnews as $news) {
      echo "<tr><a name=\"news_".$news->id."\"></a>";
      echo "<th>" . date(DATE_FORMAT, $news->postdate) . "</th>";
      echo "<th>From : " . $news->postedby . "</th>";
      echo "<th>Subject : " . $news->subject . "</th>";
      echo "</tr>";

      echo "<tr>";
      echo "<td colspan=\"3\">" . $news->body . "</td>";
      echo "</tr>";
    } ?>


</table>
