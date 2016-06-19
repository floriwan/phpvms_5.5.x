<h3><?php echo $title?></h3>

<?php
	if(!$allranks)
	{
		echo 'no ranks found!';
		return;
	}
?>

<table id="tabledlist" class="tablesorter">
<thead>
<tr>
  <th>Rank Tile</th>
  <th>Minimum Hours</th>
  <th>Rank Image</th>
</tr>
</thead>
<tbody>

  <?php
  foreach($allranks as $rank) {
    echo "<tr><td>" . $rank->rank . "</td>";
    echo "<td>" . $rank->minhours . "</td>";
    echo "<td><img src='" . $rank->rankimage . "'></td></tr>";
  }
  ?>
</tbody>
</table>
