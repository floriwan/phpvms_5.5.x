<table>
  <?php foreach($pilots as $pilot) { ?>
    <tr>
      <td>
        <?php if(Auth::LoggedIn() == true) { ?>
          <a href="<?php echo url('/profile/view/'.$pilot->pilotid);?>"><?php echo PilotData::GetPilotCode($pilot->code, $pilot->pilotid) ?></a>
        <?php } else { ?>
          <?php echo PilotData::GetPilotCode($pilot->code, $pilot->pilotid) ?>
        <?php } ?>

        </td>
      <td><?php echo $pilot->firstname . ' ' . $pilot->lastname ?></td>
      <td><img src="<?php echo Countries::getCountryImage($pilot->location);?>" alt="<?php echo Countries::getCountryName($pilot->location);?>"></td>
    </tr>
  <?php } ?>
</table>
