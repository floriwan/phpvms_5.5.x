<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<h2>Airline News</h2>

<ul class="dates">

  <?php foreach ($allnews as $news) { ?>

    <li>
      <?php echo "<a name=\"news_".$news->id."\"></a>"; ?>
      <span class="date"><?php echo date('M',  $news->postdate)?><strong><?php echo date('d',  $news->postdate)?></strong></span>
      <h3><?php echo($news->postedby)?> / <?php echo($news->subject)?></h3>
      <p><?php echo($news->body);?>
    </li>

  <?php } ?>

</ul>
