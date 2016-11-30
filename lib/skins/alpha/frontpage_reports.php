


  <?php if(!$reports) {
  	echo 'No reports have been filed';
  	return;
  }

  echo "<table>";

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
        <?php echo $report->depicao?>
      </td>
      <td><i class="icon fa-angle-right"></i></td>
      <td><img src="<?php echo Countries::getCountryImage($arrairport->country);?>"
          alt="<?php echo Countries::getCountryName($arrairport->country);?>" /> <?php echo $report->arricao?>
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
  echo "</table>";
  ?>
