<div class="features-row">
<section>

  <h3>My Profile</h3>
  <p>
  <strong>Your Pilot ID: </strong> <?php echo $pilotcode; ?><br />
  <strong>Your Rank: </strong><?php echo $userinfo->rank;?><br />
  <strong>IVAO ID: </strong><?php echo $pilot->ivao_id;?><br />
  <strong>VATSIM ID: </strong><?php echo $pilot->vatsim_id;?><br />
  <?php
  if($report)
  { ?>
    <strong>Latest Flight: </strong><a href="<?php echo url('pireps/view/'.$report->pirepid); ?>">
        <?php echo $report->code . $report->flightnum; ?></a>
    <br />
  <?php
  }
  ?>

  <strong>Total Flights: </strong><?php echo $userinfo->totalflights?><br />
  <strong>Total Hours: </strong><?php echo $userinfo->totalhours; ?><br />
  <strong>Total Transfer Hours: </strong><?php echo $userinfo->transferhours?><br />
  <strong>Total Money: </strong><?php echo FinanceData::FormatMoney($userinfo->totalpay) ?><br />

  <?php
  if($nextrank)
  {
  ?>
    <p>You have <?php echo ($nextrank->minhours - $pilot_hours)?> hours
      left until your promotion to <?php echo $nextrank->rank?></p>
  <?php
  }
  ?>
  </p>

  <p><a href="<?php echo url('/profile/editprofile'); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Profile</a></p>

</section>

<section>
  <h3>My Last Flights</h3>
  <p>
  <?php
  $pilotid = PilotData::getProperPilotID($pilotcode);
  $reports = PIREPDATA::getLastReports($pilotid, 10);

  if(!$reports) {
    echo 'No reports have been filed';
  } else {

    echo "<table>";

    foreach($reports as $report) { ?>
      <tr>
        <td><a href="<?php echo url('/pireps/viewreport/'.$report->pirepid);?>">#<?php echo $report->pirepid; ?></a></td>
        <td><?php echo $report->code.$report->flightnum;?></td>
        <td><?php echo $report->depicao?> <i class="icon fa-angle-right"></i> <?php echo $report->arricao?></td>
      </tr>

      <?php }
    echo "</table>";

  } ?>

</p>
</section>
</div>

<div class="features-row">
<section>
  <h3>My Awards</h3>

  <?php
  if(!$allawards) {
  echo 'No awards yet';
  } else {

  ?>
  <table>

  <?php foreach($allawards as $award){ ?>
  <tr><td><img src="<?php echo $award->image?>" alt="<?php echo $award->descrip?>" /></td>
    <td><?php echo $award->name ?></td></tr>
  <?php } ?>

  </table>
  <?php
  } ?>
</section>

<section>
  <h3>My Flight Bids</h3>
  <?php
  $bids = SchedulesData::GetBids(Auth::$pilot->pilotid);
  if(!$bids)
  {
  	echo '<p align="center">You have not bid on any flights</p>';
  }
  else
  {
  ?>
  <table id="tabledlist" class="tablesorter">
  <thead>
  <tr>
  	<th>Flight Number</th>
  	<th>Route</th>
  	<th>Aircraft</th>
  	<th>Departure Time</th>
  	<th>Arrival Time</th>
  </tr>
  </thead>

  <?php
  foreach($bids as $bid)
  {
  ?>
  <tr id="bid<?php echo $bid->bidid ?>">
  	<td><?php echo $bid->code . $bid->flightnum; ?></td>
  	<td align="center"><?php echo $bid->depicao; ?> <i class="icon fa-angle-right"></i> <?php echo $bid->arricao; ?></td>
  	<td align="center"><?php echo $bid->aircraft; ?></td>
  	<td><?php echo $bid->deptime;?></td>
  	<td><?php echo $bid->arrtime;?></td>
  </tr>
  <?php
  }
  } ?>

  </table>

</section>
</div>

</section>

<section class="box feature">
<h3>Pilot Badge</h3>

<?php
$badge_url = fileurl(SIGNATURE_PATH.'/'.PilotData::GetPilotCode(Auth::$pilot->code, Auth::$pilot->pilotid).'.png');
$pilotcode = PilotData::getPilotCode(Auth::$pilot->code, Auth::$pilot->pilotid);
?>

<p align="center">
	<img src="<?php echo $badge_url ?>" />
</p>
<p>
	<strong>Direct Link:</strong>
	<input onclick="this.select()" type="text" value="<?php echo $badge_url ?>" style="width: 100%" />
	<br /><br />
	<strong>Image Link:</strong>
	<input onclick="this.select()" type="text" value='<img src="<?php echo $badge_url ?>" />' style="width: 100%" />
	<strong>BBCode:</strong>
	<input onclick="this.select()" type="text" value='[img]<?php echo $badge_url ?>[/img]' style="width: 100%" />
</p>
