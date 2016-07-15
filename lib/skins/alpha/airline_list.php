<h3>Airlines List</h3>

<?php
if(!$allairlines)
{
	echo '<p id="error">No airlines have been added</p>';
	return;
}
?>

<table id="tabledlist" class="tablesorter">
<thead>
<tr>
	<th>ICAO</th>
  <th>Callsign</th>
	<th>Airline</th>
</tr>
</thead>
<tbody>

<?php foreach($allairlines as $airline) { ?>

<tr>
  <td><?php echo $airline->code; ?></td>
	<td><?php echo $airline->callsign; ?></td>
  <td><?php echo $airline->name; ?></td>
</tr>

<?php } ?>

</tbody>
</table>
