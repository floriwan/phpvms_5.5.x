<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
Dear <?php echo $pilot->firstname.' '.$pilot->lastname ?>,
Your registration for <?php echo SITE_NAME?> was accepted! Please visit us
at <a href="<?php echo SITE_URL?>"><?php echo SITE_NAME?></a> to login and complete your registration.

Please take a look into our <a href="<?php echo SITE_URL?>/smf">forum. Your accout for the forum is:


<?php $pcode = self::getPilotCode($pilotdata->code, $pilot->pilotid); ?>

Username : <?php echo $pcode ?>
Password : <?php strtolower($pcode) ?>

Have fun
Thanks!
<?php echo SITE_NAME?> Staff
