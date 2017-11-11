<?php
/**
 * 	STOP! HAMMER TIME!
 *
 * ====> READ THIS !!!!!
 *
 * I really really, REALLY suggest you don't edit this file.
 * Why? This is the "main header" file where I put changes for updates.
 * And you don't want to have to manually go through and figure those out.
 *
 * That equals headache for you, and headache for me to figure out what went wrong.
 *
 * BUT BUT WAIT, you say... I want to include more javascript, css, etc...!
 * Well - in your skin's header.tpl file, this file is included as:
 *
 * Template::Show('core_htmlhead.tpl');
 *
 * Just add your stuff under that line there. That way, it's in the proper
 * spot, and this file stays intact for the system (and me) to be able to
 * make clean updates whenever needed. Less bugs = happy users (and happy me)
 *
 * THANKS!
 */
?>
<script type="text/javascript">
var baseurl = "<?php echo SITE_URL;?>";
var geourl = "<?php echo GEONAME_URL; ?>";
</script>

<link rel="stylesheet" media="all" type="text/css" href="<?php echo fileurl('lib/css/phpvms.css')?>" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo fileurl('lib/css/datatables.min.css')?>" />

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Config::Get('PAGE_ENCODING');?>" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>-->
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="<?php echo fileurl('lib/js/jquery.form.js');?>"></script>
<script type="text/javascript" src="<?php echo fileurl('lib/js/phpvms.js');?>"></script>

<script type="text/javascript" src="<?php echo fileurl('lib/skins/alpha/assets/js/jquery.waypoints.min.js');?>"></script>
<script type="text/javascript" src="<?php echo fileurl('lib/skins/alpha/assets/js/jquery.counterup.min.js');?>"></script>

<!-- flip terminal message -->
<script type="text/javascript" src="<?php echo fileurl('lib/js/jquery.splitflap.js');?>"></script>

<!-- paging for the schedule page -->
<!--<script type="text/javascript" src="https://cdn.datatables.net/v/ju/jqc-1.12.3/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/ju-1.11.4/jqc-1.12.3/dt-1.10.12/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.js"></script>-->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>


<?php
echo $MODULE_HEAD_INC;
