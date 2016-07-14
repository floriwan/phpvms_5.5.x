<h3><?php echo SITE_NAME; ?>'s Pilots</h3>

<?php
	if(!$allpilots)
	{
		echo 'There are no pilots!';
		return;
	}
?>
<table id="tabledlist" class="tablesorter">
<thead>
<tr>
	<th>Pilot ID</th>
  <th></th>
	<th>Name</th>
	<th>Rank</th>
	<th>Flights</th>
	<th>Hours</th>
  <th> </th>
</tr>
</thead>
<tbody>
<?php
foreach($allpilots as $pilot)
{
	/*
		To include a custom field, use the following example:

		<td>
			<?php echo PilotData::GetFieldValue($pilot->pilotid, 'VATSIM ID'); ?>
		</td>

		For instance, if you added a field called "IVAO Callsign":

			echo PilotData::GetFieldValue($pilot->pilotid, 'IVAO Callsign');
	 */

	 // To skip a retired pilot, uncomment the next line:
	 //if($pilot->retired == 1) { continue; }
?>
<tr>
	<td width="1%" nowrap><a href="<?php echo url('/profile/view/'.$pilot->pilotid);?>">
			<?php echo PilotData::GetPilotCode($pilot->code, $pilot->pilotid)?></a>
	</td>
	<td>
		&nbsp;<img src="<?php echo Countries::getCountryImage($pilot->location);?>"
			alt="<?php echo Countries::getCountryName($pilot->location);?>" />
  </td>
  <td>
		<?php echo $pilot->firstname.' '.$pilot->lastname?>
	</td>
	<td><img src="<?php echo $pilot->rankimage?>" alt="<?php echo $pilot->rank;?>" /></td>
	<td><?php echo $pilot->totalflights?></td>
	<td><?php echo Util::AddTime($pilot->totalhours, $pilot->transferhours); ?></td>

  <td><?php if (!empty($pilot->ivao_id) && $pilot->ivao_status == 0) { ?> <img alt="offline" src="<?php echo SITE_URL?>/lib/images/ivao_offline.png" alt="ivao" />
    <?php } else if (!empty($pilot->ivao_id) && $pilot->ivao_status == 1) { ?> <img alt="online" src="<?php echo SITE_URL?>/lib/images/ivao_online.png" alt="ivao" />
    <?php } ?>
  </td>
<?php
}
?>
</tbody>
</table>
