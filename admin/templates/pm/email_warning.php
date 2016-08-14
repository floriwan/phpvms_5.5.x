<?php
$pilotid = $pilot->pilotid;
$pirp = PManagerData::getpirep($pilotid);
$pir = $pirp->submitdate;
?>
<p>Dear <?php echo $pilot->firstname.' '.$pilot->lastname ;?>,</p>
<p>You are required to submit a valid PIREP within 30 days after registration and one valid PIREP every 90 days. Your last PIREP was sent on <?php echo $pir; ?>.</p>
<p>Please be advised if you do not send a report within the next 30 days your account will be deleted.</p>
<p>Sincerely</p>
<p><?php echo SITE_NAME ;?> - Staff</p>
