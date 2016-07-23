<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<h3>Livery</h3>
<p>These are all liveries for the airline planes.</p>
<?php

if (!$allliveries) {
  echo '<p id="error">No liveries added</p>';
	return;
}

?>

<table id="tabledlist" class="tablesorter">
<thead>
<tr>
	<th>Aircraft</th>
  <th>Sim</th>
  <th>Image</th>
  <th>Link</th>
  <th>Desc</th>
  <th>Options</th>
</tr>
</thead>

<tbody>
  <?php foreach($allliveries as $livery) {
    $aircraft = OperationsData::getAircraftInfo($livery->aircraftID);
  ?>
    <tr>
    <td align="center"><?php echo $aircraft->icao . " (". $aircraft->registration . ")"; ?></td>
  	<td align="center">
      <?php switch($livery->sim) {
        case 1: echo "FSX"; break;
        case 2: echo "P3D"; break;
        case 3: echo "X-Plane"; break;
      } ?>
    </td>
  	<td align="center"><?php echo $livery->image; ?></td>
    <td align="center"><?php echo $livery->link; ?></td>
    <td align="center"><?php echo $livery->desc; ?></td>

    <td align="center" width="1%" nowrap>

      <button class="{button:{icons:{primary:'ui-icon-wrench'}}}"
        onclick="window.location='<?php echo adminurl('/operations/editlivery?id='.$livery->ID);?>';">&nbsp;</button>

      <button class="{button:{icons:{primary:'ui-icon-trash'}}}"
        onclick="window.location='<?php echo adminurl('/operations/deletelivery?id='.$livery->ID);?>';">&nbsp;</button>
    </td>

    </tr>
  <?php } ?>
</tbody>
</table>
