<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<h3>Aircraft List</h3>
<p>These are all the aircraft that your airline operates.</p>
<?php
if(!$allaircraft)
{
	echo '<p id="error">No aircraft have been added</p>';
	return;
}
?>
<table id="tabledlist" class="tablesorter">
<thead>
<tr>
	<th>ICAO</th>
	<th>Name/Type</th>
	<th>Full Name</th>
	<th>Registration</th>
  <th>Nav Equipment</th>
	<th align="center">Max Pax</th>
	<th align="center">Max Cargo</th>
  <th align="center">Airline</th>
  <th align="center">Liveries</th>
	<th colspan="3">Options</th>
</tr>
</thead>
<tbody>
<?php
foreach($allaircraft as $aircraft)
{
  $liveries = AircraftData::getLiveries($aircraft->id);

?>
<tr class="<?php echo ($aircraft->enabled==0)?'disabled':''?>">
	<td align="center"><?php echo $aircraft->icao; ?></td>
	<td align="center"><?php echo $aircraft->name; ?></td>
	<td align="center"><?php echo $aircraft->fullname; ?></td>
	<td align="center"><?php echo $aircraft->registration; ?></td>
  <td align="center"><?php echo $aircraft->equipment; ?></td>
	<td align="center"><?php echo $aircraft->maxpax; ?></td>
	<td align="center"><?php echo $aircraft->maxcargo; ?></td>

  <?php
  if ($aircraft->airlineid != 0) {
    $airlinename = OperationsData::getAirlineByID($aircraft->airlineid)->name;
  } else {
    $airlinename = "N/A";
  }
  ?>

  <td align="center"><?php echo $airlinename; ?></td>

  <td align="center">
    <?php if ($liveries != 0) {
      foreach ($liveries as $livery) {
        switch($livery->sim) {
          case 1: echo "FSX"; break;
          case 2: echo "P3D"; break;
          case 3: echo "X-Plane"; break;
        }
        echo " (".$livery->desc . ")<br>";
      }
    } ?>
  </td>

  <td align="center" width="1%" nowrap>
		<button class="{button:{icons:{primary:'ui-icon-wrench'}}}"
			onclick="window.location='<?php echo adminurl('/operations/addlivery?aircraftID='.$aircraft->id);?>';">Add Livery</button>
	</td>

	<td align="center" width="1%" nowrap>
		<button class="{button:{icons:{primary:'ui-icon-wrench'}}}"
			onclick="window.location='<?php echo adminurl('/operations/editaircraft?id='.$aircraft->id);?>';">Edit</button>
	</td>

  <td align="center" width="1%" nowrap>
    <button class="{button:{icons:{primary:'ui-icon-copy'}}}"
			onclick="window.location='<?php echo adminurl('/operations/copyaircraft?id='.$aircraft->id);?>';">Copy</button>
	</td>

</tr>
<?php
}
?>
</tbody>
</table>
