<table>
  <?php foreach($pilots as $pilot) { ?>
    <tr>
      <td><a href="<?php echo url('/profile/view/'.$pilot->pilotid);?>"><?php echo PilotData::GetPilotCode($pilot->code, $pilot->pilotid) ?></a></td>
      <td><?php echo $pilot->firstname . ' ' . $pilot->lastname ?></td>
      <td><img src="<?php echo Countries::getCountryImage($pilot->location);?>" alt="<?php echo Countries::getCountryName($pilot->location);?>"></td>
    </tr>
  <?php } ?>
</table>
