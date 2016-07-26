<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<p>Dear <?php echo $pilot->firstname.' '.$pilot->lastname ?>,</p>


<p>Your registration for <?php echo SITE_NAME?> was accepted!</p>

<p>Your pilot ID is : <?php echo PilotData::GetPilotCode($pilot->code, $pilot->pilotid) ?></p>

<p>Please visit us at <a href="<?php echo SITE_URL?>"><?php echo SITE_NAME?></a> to login and complete your registration.</p>

<p>If you have any questions, please visit our forum <a href="http://www.flycaribbeanva.com/smf/index.php?action=login">FlyCaribbanVA Forum</a>.
Your login is <?php echo PilotData::GetPilotCode($pilot->code, $pilot->pilotid) ?> and the password is your pilot ID in lowercase.
Please change your password on your first forum visit.</p>

Thanks!
<?php echo SITE_NAME?> Staff
