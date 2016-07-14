<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
Dear <?php echo $pilot->firstname.' '.$pilot->lastname ?>,

Your registration for <?php echo SITE_NAME?> was accepted! Please visit us
at <a href="<?php echo SITE_URL?>"><?php echo SITE_NAME?></a> to login and complete your registration.

Do you have any questions, please visit our forum <a href="http://www.flycaribbeanva.com/smf/index.php?action=login">FlyCaribbanVA Forum</a>.
Your login is <?php echo PilotData::GetPilotCode($pilot->code, $pilot->pilotid) ?> and the password is your pilotcode in lowercase.
Please change your password on your fist forum visit.

Thanks!
<?php echo SITE_NAME?> Staff
