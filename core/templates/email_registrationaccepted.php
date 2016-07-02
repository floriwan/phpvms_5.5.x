<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
Dear <?php echo $pilot->firstname.' '.$pilot->lastname ?>,

Your registration for <?php echo SITE_NAME?> was accepted! Please visit us
at <a href="<?php echo SITE_URL?>"><?php echo SITE_NAME?></a> to login and complete your registration.

<?php
$pilotcode = self::getPilotCode($pilot->code, $pilot->pilotid);
?>

Login to our forum and change your password:
User     : <?php $pilotcode ?>
Password : <?php strtolower($pilotcode) ?>


Thanks!
<?php echo SITE_NAME?> Staff
