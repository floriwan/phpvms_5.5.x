


  <?php if(!$reports) {
  	echo 'No reports have been filed';
  	return;
  }

  echo "<table>";

  foreach($reports as $report) { ?>

    <tr>
      <td>
        <?php if(Auth::LoggedIn() == true) { ?>
          <a href="<?php echo url('/pireps/viewreport/'.$report->pirepid);?>">#<?php echo $report->pirepid . ' - ' . $report->code.$report->flightnum?></a>
        <?php } else { ?>
          #<?php echo $report->pirepid . ' - ' . $report->code.$report->flightnum?>
        <?php } ?>
      </td>
      <td><?php echo $report->depicao?> <i class="icon fa-angle-right"></i> <?php echo $report->arricao?></td>
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
