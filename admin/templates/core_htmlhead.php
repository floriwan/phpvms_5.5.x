<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<script type="text/javascript">
var baseurl="<?php echo SITE_URL;?>";
var airport_lookup = "<?php echo Config::Get('AIRPORT_LOOKUP_SERVER'); ?>";
var phpvms_api_server = "<?php echo Config::Get('PHPVMS_API_SERVER'); ?>";
</script>

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>-->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript" src="<?php echo fileurl('lib/js/jqModal.js'); ?>"></script>
<script type="text/javascript" src="<?php echo fileurl('lib/js/jquery.form.js'); ?>"></script>
<script type="text/javascript" src="<?php echo fileurl('lib/js/jquery.bigiframe.js'); ?>"></script>
<script type="text/javascript" src="<?php echo fileurl('lib/js/jquery.metadata.js'); ?>"></script>
<script type="text/javascript" src="<?php echo fileurl('lib/js/ckeditor/ckeditor.js'); ?>"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="<?php echo SITE_URL?>/admin/lib/phpvmsadmin.js"></script>

<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php echo SITE_URL?>/lib/rss/latestpireps.rss">

<?php
if(isset($MODULE_HEAD_INC))
	echo $MODULE_HEAD_INC;
?>
