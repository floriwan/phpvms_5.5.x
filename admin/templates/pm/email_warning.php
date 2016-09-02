<?php
$pilotid = $pilot->pilotid;
$pirp = PManagerData::getpirep($pilotid);
$pir = $pirp->submitdate;
?>
<p>Dear <?php echo $pilot->firstname.' '.$pilot->lastname ;?>,</p>
<p>You are required to submit a valid PIREP within 2 weeks after registration and one valid PIREP every two month. Your last PIREP was sent on <?php echo $pir; ?>.</p>
<p>Your account has been set to inactive. If you don't submit a valid PIREP within two weeks, your account will be deleted.</p>
<p>Sincerely</p>
<p><?php echo SITE_NAME ;?> - Staff</p>
