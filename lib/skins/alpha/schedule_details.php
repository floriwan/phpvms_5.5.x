<h3>Schedule Details For Flight Number <?php echo $schedule->code.$schedule->flightnum ?></h3>
<div class="indent">

<?php
    $depAirport = OpenAIPData::getAirport($schedule->depicao);
    $depRadio = OpenAIPData::getRadio($depAirport[0]->id);
    $depRwy = OpenAIPData::getRunway($depAirport[0]->id);
    $deplatdms = OpenAIPData::dec2dms($depAirport[0]->lat);
    $deplondms = OpenAIPData::dec2dms($depAirport[0]->lon);
    
    $arrAirport = OpenAIPData::getAirport($schedule->arricao);
    $arrRunway = OpenAIPData::getRunway($arrAirport[0]->id);
    $arrRadio = OpenAIPData::getRadio($arrAirport[0]->id);
    $arrlatdms = OpenAIPData::dec2dms($arrAirport[0]->lat);
    $arrlondms = OpenAIPData::dec2dms($arrAirport[0]->lon);
    
?>

<div class="row">
<div class="6u 12u(mobilep)">
    <h3>Departure<?php echo $schedule->depname ?> (<?php echo $schedule->depicao ?>) at <?php echo $schedule->deptime ?></h3>
    
    <table class="alt">
    <tbody>
    <tr>
        <td>Coordinates</td>
        <td>N<?php echo $deplatdms['deg'] ?>&deg; <?php echo $deplatdms['min'] ?>' <?php echo $deplatdms['sec'] ?>'' / 
            W<?php echo $deplondms['deg'] ?>&deg; <?php echo $deplondms['min'] ?>' <?php echo $deplondms['sec'] ?>''<br>
            <font size="-1"><sup>Latitude: <?php echo $depAirport[0]->lat ?> Longitude: <?php echo $depAirport[0]->lon ?></sup></font>
        </td>
    </tr>
    <tr>
        <td>Elevation</td>
        <td><?php echo OpenAIPData::meter2feet($depAirport[0]->elev) ?> feet MSL</td>
    </tbody>
    </table>
    </p>

    <p>
    <table class="alt">
        <tbody>
        <?php foreach($depRadio as $radio) { ?>
        <tr>
            <td><?php echo $radio->type ?> (<?php echo $radio->desc ?>)</td>
            <td><?php echo $radio->frequency ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    </p>
    
    <p>
    <table class="alt">
        <tbody>
        <?php foreach($depRwy as $rwy) { ?>
        <tr>
            <td colspan="2"><strong>Runway <?php echo $rwy->name ?></strong></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?php echo $rwy->operation ?></td>
        </tr>
        <tr>
            <td>Surface</td>
            <td><?php echo OpenAIPData::toSurface($rwy->sfc) ?></td>
        </tr>
        <tr>
            <td>Dimension</td>
            <td><?php echo OpenAIPData::meter2feet($rwy->length) ?> x <?php echo OpenAIPData::meter2feet($rwy->width) ?> feet / 
                <?php echo $rwy->length ?> x <?php echo $rwy->width ?> meters</td>
        </tr>

        
        <?php } ?>
        </tbody>
    </table>
    </p>
    
    <p>
    <table class="alt">
        <tbody>
        <tr><td>Weather Information</td></tr>
        <tr><td><?php MainController::Run('Weather', 'request_metar', $schedule->depicao); ?></td></tr>
        </tbody>
    </table>
    </p>
    
    
</div>
<div class="6u 12u(mobilep)">
    <h3>Arrival <?php echo $schedule->arrname ?> (<?php echo $schedule->arricao ?>) at <?php echo $schedule->arrtime ?></h3>
    
    <table class="alt">
    <tbody>
    <tr>
        <td>Coordinates</td>
        <td>N<?php echo $arrlatdms['deg'] ?>&deg; <?php echo $arrlatdms['min'] ?>' <?php echo $arrlatdms['sec'] ?>'' / 
            W<?php echo $arrlondms['deg'] ?>&deg; <?php echo $arrlondms['min'] ?>' <?php echo $arrlondms['sec'] ?>''<br>
            <font size="-1"><sup>Latitude: <?php echo $arrAirport[0]->lat ?> Longitude: <?php echo $arrAirport[0]->lon ?></sup></font>
        </td>
    </tr>
    <tr>
        <td>Elevation</td>
        <td><?php echo OpenAIPData::meter2feet($arrAirport[0]->elev) ?> feet MSL</td>
    </tbody>
    </table>
    </p>

    <p>
    <table class="alt">
        <tbody>
        <?php foreach($arrRadio as $radio) { ?>
        <tr>
            <td><?php echo $radio->type ?> (<?php echo $radio->desc ?>)</td>
            <td><?php echo $radio->frequency ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    </p>
    
    <p>
    <table class="alt">
        <tbody>
        <?php foreach($arrRunway as $rwy) { ?>
        <tr>
            <td colspan="2"><strong>Runway <?php echo $rwy->name ?></strong></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?php echo $rwy->operation ?></td>
        </tr>
        <tr>
            <td>Surface</td>
            <td><?php echo OpenAIPData::toSurface($rwy->sfc) ?></td>
        </tr>
        <tr>
            <td>Dimension</td>
            <td><?php echo OpenAIPData::meter2feet($rwy->length) ?> x <?php echo OpenAIPData::meter2feet($rwy->width) ?> feet / 
                <?php echo $rwy->length ?> x <?php echo $rwy->width ?> meters</td>
        </tr>

        
        <?php } ?>
        </tbody>
    </table>
    </p>
    
    <p>
    <table class="alt">
        <tbody>
        <tr><td>Weather Information</td></tr>
        <tr><td><?php MainController::Run('Weather', 'request_metar', $schedule->depicao); ?></td></tr>
        </tbody>
    </table>
    </p>

</div>
</div>



<?php
if($schedule->route!='')
{ ?>
<strong>Route: </strong><?php echo $schedule->route ?><br />
<?php
}?>
<br />

<strong>Schedule Frequency</strong>
<div align="center">
<?php
/*
	Added in 2.0!
*/
$chart_width = '800';
$chart_height = '170';

/* Don't need to change anything below this here */
?>
<div align="center" style="width: 100%;">
	<div align="center" id="pireps_chart"></div>
</div>

<script type="text/javascript" src="<?php echo fileurl('/lib/js/ofc/js/swfobject.js')?>"></script>
<script type="text/javascript">
swfobject.embedSWF("<?php echo fileurl('/lib/js/ofc/open-flash-chart.swf');?>",
	"pireps_chart", "<?php echo $chart_width;?>", "<?php echo $chart_height;?>",
	"9.0.0", "expressInstall.swf",
	{"data-file":"<?php echo actionurl('/schedules/statsdaysdata/'.$schedule->id);?>"});
</script>
<?php
/* End added in 2.0
*/
?>
</div>
