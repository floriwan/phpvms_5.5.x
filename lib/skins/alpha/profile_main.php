
  <div class="features-row">
  <section>
    <span class="icon major fa-user accent2"></span>
      <h3>My Profile</h3>
      <p>
      <strong>Your Pilot ID: </strong> <?php echo $pilotcode; ?><br />
      <strong>Your Rank: </strong><?php echo $userinfo->rank;?><br />
      <?php
      if($report)
      { ?>
        <strong>Latest Flight: </strong><ahref="<?php echo url('pireps/view/'.$report->pirepid); ?>">
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
  </section>

  <section>
    <span class="icon major fa-trophy accent3"></span>
    <h3>My Awards</h3>
    <p>
    <?php
    if(!$allawards)
    {
      echo 'No awards yet';
    }
    else
    {

      /* To show the image:
        <img src="<?php echo $award->image?>" alt="<?php echo $award->descrip?>" />
      */

    ?>

    <ul>
      <?php foreach($allawards as $award){ ?>
      <li><?php echo $award->name ?></li>
      <?php } ?>
    </ul>

    <?php
    }
    ?>
    </p>
  </section>

  </div>

  <div class="features-row">
  <section>
    <span class="icon major fa-area-chart accent4"></span>
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
            <td><a href="<?php echo url('/pireps/viewreport/'.$report->pirepid);?>">#<?php echo $report->pirepid; ?></td>
            <td><?php echo $report->code.$report->flightnum;?></td>
            <td><?php echo $report->depicao?> <i class="icon fa-angle-right"></i> <?php echo $report->arricao?></td>
          </tr>
          </tr>

          <?php }
        echo "</table>";

      } ?>

    </p>
  </section>

  <section>
    <span class="icon major fa-cloud accent1"></span>
      <h3>Weather</h3>
      <p>
        <?php
        include 'include.php';
        $pilotid = PilotData::getProperPilotID($pilotcode);
        $reports = PIREPDATA::getLastReports($pilotid, 1);

        if(!$reports) {
        	echo 'No reports have been found';
        } else {
          get_metar($reports->arricao);
        }
        ?>
      </p>
  </section>

  </div>
