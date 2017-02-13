


  <?php if(!$reports) {
  	echo 'No reports have been filed';
  	return;
  }

  echo "<table>";
  echo "<thead><tr><td><strong>Callsign</strong></td><td><img height=\"18\" width=\"18\" src=\"" . SITE_URL . "/lib/images/icon_to.png\"></td>";
  echo "<td></td><td><img height=\"18\" width=\"18\" src=\"" . SITE_URL . "/lib/images/icon_land.png\"></td><td><strong>Pilot</strong></td></tr></thead>";
  echo "<tbody>";

  foreach($reports as $report) {
    $depairport = OperationsData::getAirportInfo($report->depicao);
    $arrairport = OperationsData::getAirportInfo($report->arricao);
    ?>

    <tr>
      <td>
        <?php if(Auth::LoggedIn() == true) { ?>
          <a href="<?php echo url('/pireps/viewreport/'.$report->pirepid);?>">#<?php echo $report->pirepid . ' - ' . $report->code.$report->flightnum?></a>
        <?php } else { ?>
          #<?php echo $report->pirepid . ' - ' . $report->code.$report->flightnum?>
        <?php } ?>
      </td>
      <td><img src="<?php echo Countries::getCountryImage($depairport->country);?>"
        alt="<?php echo Countries::getCountryName($depairport->country);?>" />
        <?php echo $report->depicao?><br>
        <font size="-1"><sup><?php echo $depairport->name ; ?></sup></font>
      </td>
      <td><i class="icon fa-angle-right"></i></td>
      <td><img src="<?php echo Countries::getCountryImage($arrairport->country);?>"
          alt="<?php echo Countries::getCountryName($arrairport->country);?>" /> <?php echo $report->arricao?><br>
          <font size="-1"><sup><?php echo $arrairport->name ; ?></sup></font>
      </td>
      <td>
        <?php if(Auth::LoggedIn() == true) { ?>
          <a href="<?php echo url('/profile/view/'.$report->pilotid);?>"><?php echo $report->firstname . ' ' . $report->lastname?></a>
        <?php } else { ?>
          <?php echo $report->firstname . ' ' . $report->lastname?>
        <?php } ?>
      </td>
    </tr>

  <?php
  }
  echo "</tbody></table>";
  ?>
