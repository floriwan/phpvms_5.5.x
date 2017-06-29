
<?php if(isset($errorMsg)) echo '<div id="error">'.$errorMsg.'</div>'; ?>

<h3>Schedule Details For Flight Number <?php echo $schedule->code.$schedule->flightnum ?></h3>

<p>
<a id="<?php echo $schedule->id; ?>" class="addbid" href="<?php echo actionurl('/schedules/addbid/?id='.$schedule->id);?>">
<i class="fa fa-paper-plane" aria-hidden="true"></i> Add schedule to Bid</a>
</p>

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
    <h4>Departure <?php echo $schedule->depname ?> (<?php echo $schedule->depicao ?>) at <?php echo $schedule->deptime ?></h4>
    
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

    <h4>Frequencies</h4>
    <table class="alt">
        <thead>
            <tr><td>Purpose</td>
                <td>Type</td>
                <td>Frequency</td>
                <td>Name</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach($depRadio as $radio) { ?>
        <tr>
            <td><?php echo $radio->category[0] . strtolower(substr($radio->category, 1)) ?></td>
            <td><?php echo $radio->type ?></td>
            <td><?php echo OpenAIPData::formatFrequency($radio->frequency) ?></td>
            <td><?php echo $radio->desc ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
        
</div>
<div class="6u 12u(mobilep)">
    <h4>Arrival <?php echo $schedule->arrname ?> (<?php echo $schedule->arricao ?>) at <?php echo $schedule->arrtime ?></h4>
    
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

    <h4>Frequencies</h4>
    <table class="alt">
        <thead>
            <tr><td>Purpose</td>
                <td>Type</td>
                <td>Frequency</td>
                <td>Name</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach($arrRadio as $radio) { ?>
        <tr>
            <td><?php echo $radio->category[0] . strtolower(substr($radio->category, 1)) ?></td>
            <td><?php echo $radio->type ?></td>
            <td><?php echo OpenAIPData::formatFrequency($radio->frequency) ?></td>
            <td><?php echo $radio->desc ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>


</div>
</div>

<!-- runway information -->
<div class="row">
<div class="6u 12u(mobilep)">

    <h4>Runways</h4>
    <table class="alt">
        <thead>
            <tr>
                <td>RWY</td>
                <td>Direction</td>
                <td>Dimension</td>
                <td>Surface</td>
                <td>Operations</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach($depRwy as $rwy) { ?>
        <tr>
            <td><strong><?php echo $rwy->name ?></strong></td>
            <td><?php echo $rwy->dir1 ?> <br> <?php echo $rwy->dir2 ?></td>
            <td><?php echo OpenAIPData::meter2feet($rwy->length) ?> x <?php echo OpenAIPData::meter2feet($rwy->width) ?> feet<br> 
                <font size="-1"><sup><?php echo $rwy->length ?> x <?php echo $rwy->width ?> meters</sup></font></td>
            <td><?php echo OpenAIPData::toSurface($rwy->sfc) ?> (<?php echo $rwy->sfc ?>)</td>
            <td><?php echo strtolower($rwy->operation) ?></td>
        </tr>        
        <?php } ?>
        </tbody>
    </table>
    
</div>

<div class="6u 12u(mobilep)">
    
    <h4>Runways</h4>
    <table class="alt">
        <thead>
            <tr>
                <td>RWY</td>
                <td>Direction</td>
                <td>Dimension</td>
                <td>Surface</td>
                <td>Operations</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach($arrRunway as $rwy) { ?>
        <tr>
            <td><strong><?php echo $rwy->name ?></strong></td>
            <td><?php echo $rwy->dir1 ?> <br> <?php echo $rwy->dir2 ?></td>
            <td><?php echo OpenAIPData::meter2feet($rwy->length) ?> x <?php echo OpenAIPData::meter2feet($rwy->width) ?> feet<br> 
                <font size="-1"><sup><?php echo $rwy->length ?> x <?php echo $rwy->width ?> meters</sup></font></td>
            <td><?php echo OpenAIPData::toSurface($rwy->sfc) ?> (<?php echo $rwy->sfc ?>)</td>
            <td><?php echo strtolower($rwy->operation) ?></td>
        </tr>        
        <?php } ?>
        </tbody>
    </table>
    
</div>

</div>

<!-- weather information -->
<div class="row">
<div class="6u 12u(mobilep)">
    <h4>Weather Information</h4>
    <table class="alt">
        <tbody>
        <tr><td><?php MainController::Run('Weather', 'request_metar', $schedule->depicao); ?></td></tr>
        </tbody>
    </table>
</div>
    
<div class="6u 12u(mobilep)">
    <h4>Weather Information</h4>
    <table class="alt">
        <tbody>
        <tr><td><?php MainController::Run('Weather', 'request_metar', $schedule->arricao); ?></td></tr>
        </tbody>
    </table>
</div>
</div>

<!-- alternate schedules -->
<div class="row">
<div class="6u 12u(mobilep)">
        <form method="post" action="<?php echo url('/schedules/findflight');?>">
        <input type="hidden" name="depicao" value="<?php echo $schedule->arricao; ?>" />
        <input type="submit" class="button fit" value="schedules with departure from <?php echo $schedule->depname;?> (<?php echo $schedule->depicao; ?>)" />
        </form>
</div>

<div class="6u 12u(mobilep)">
        <form method="post" action="<?php echo url('/schedules/findflight');?>">
        <input type="hidden" name="depicao" value="<?php echo $schedule->arricao; ?>" />
        <input type="submit" class="button fit" value="schedules with departure from <?php echo $schedule->arrname;?> (<?php echo $schedule->arricao; ?>)" />
        </form>
</div>
</div>

<!-- scenery download -->
<div class="row">
<div class="6u 12u(mobilep)">
    <h4>Scenery</h4>
    
    <?php if (!$depscenery) { ?>
        <p>For now we have no scenery download links for <?php echo $schedule->depicao; ?> available.</p>
    <?php } else { ?>
    
        <table class="alt">
        <tbody>
            <?php foreach ($depscenery as $scenery) { ?>
            <tr>
                <td><a href="<?php echo $scenery->link; ?>"><i class="fa fa-external-link fa-fw" aria-hidden="true"></i> <?php echo $scenery->sim; ?></a></td>
                <td><?php if ($scenery->payware == 1) echo "Payware"; else echo "Freeware"; ?></td>
                <td><?php echo $scenery->descr; ?></td>
                <!--<td><a href=""><i class="fa fa-bullhorn" aria-hidden="true"></i></a></td>-->
            </tr>
            <?php } ?>
        </tobdy>
        </table>
        
    <?php } ?>

    <!-- add new scenery -->

    <a id="toggleAddScenery" href="javascript:;" class="button fit">add new scenery for <?php echo $schedule->depname;?> (<?php echo $schedule->depicao; ?>)</a>

    <div id="addSceneryElemets">
    
    <form method="post" action="<?php echo url('/schedules/addScenery');?>">
    
    <div class="row uniform 50%">
    <div class="12u">
        <div class="select-wrapper">
            <select name="simulator" id="simulator">
                <option value="">- Simulator -</option>
                <option value="1">FSX / P3D</option>
                <option value="2">X-Plane</option>
            </select>
        </div>
    </div>
    </div>

    <div class="row uniform 50%">
        <div class="4u 12u(narrower)">
            <input type="checkbox" id="freeware" name="freeware">
            <label for="freeware">Freeware</label>
        </div>
    </div>

    <div class="row uniform 50%">
        <div class="12u">
            <textarea name="description" id="description" maxlength="200" placeholder="Scenery Description" rows="6"></textarea>
        </div>
    </div>
    
    <div class="row uniform 50%">
        <div class="12u">
            <input type="text" name="link" id="link" maxlength="200" value="" placeholder="Link/URL" />
        </div>
    </div>
 
    <div class="row uniform 50%">
        <div class="12u">
            <input type="hidden" name="depicao" value="<?php echo $schedule->depicao; ?>" />
            <input type="hidden" name="pilotid" value="<?php echo Auth::$userinfo->pilotid; ?>" />
            <input type="hidden" name="scheduleid" value="<?php echo $schedule->id; ?>" />
            <input type="submit" id="scenery" name="submit" value="Send" />
            
            
        </div>
    </div>
 
    </form>
     
    </div>
    
</div>

<div class="6u 12u(mobilep)">
    <h4>Scenery</h4>
    <?php if (!$arrscenery) { ?>
        <p>For now we have no scenery download links for <?php echo $schedule->arricao; ?> available.</p>
    <?php } else { ?>
    
        <table class="alt">
        <tbody>
            <?php foreach ($arrscenery as $scenery) { ?>
            <tr>
                <td><a href="<?php echo $scenery->link; ?>"><i class="fa fa-external-link fa-fw" aria-hidden="true"></i> <?php echo $scenery->sim; ?></a></td>
                <td><?php if ($schedule->payware == 1) echo "Payware"; else echo "Freeware"; ?></td>
                <td><?php echo $scenery->descr; ?></td>
                <!--<td><a href=""><i class="fa fa-bullhorn" aria-hidden="true"></i></a></td>-->
            </tr>
            <?php } ?>
        </tobdy>
        </table>
        
    <?php } ?>
    
        <!-- add new scenery -->

    <a id="toggleAddArrScenery" href="javascript:;" class="button fit">add new scenery for <?php echo $schedule->arrname;?> (<?php echo $schedule->arricao; ?>)</a>

    <div id="addSceneryArrElemets">
    
    <form method="post" action="<?php echo url('/schedules/addScenery');?>">
    
    <div class="row uniform 50%">
    <div class="12u">
        <div class="select-wrapper">
            <select name="simulator" id="simulator">
                <option value="">- Simulator -</option>
                <option value="1">FSX / P3D</option>
                <option value="2">X-Plane</option>
            </select>
        </div>
    </div>
    </div>

    <div class="row uniform 50%">
        <div class="4u 12u(narrower)">
            <input type="checkbox" id="arrfreeware" name="freeware">
            <label for="arrfreeware">Freeware</label>
        </div>
    </div>

    <div class="row uniform 50%">
        <div class="12u">
            <textarea name="description" id="description" maxlength="200" placeholder="Scenery Description" rows="6"></textarea>
        </div>
    </div>
    
    <div class="row uniform 50%">
        <div class="12u">
            <input type="text" name="link" id="link" maxlength="200" value="" placeholder="Link/URL" />
        </div>
    </div>
 
    <div class="row uniform 50%">
        <div class="12u">
            <input type="hidden" name="depicao" value="<?php echo $schedule->arricao; ?>" />
            <input type="hidden" name="pilotid" value="<?php echo Auth::$userinfo->pilotid; ?>" />
            <input type="hidden" name="scheduleid" value="<?php echo $schedule->id; ?>" />
            <input type="submit" id="scenery" name="submit" value="Send" />
            
            
        </div>
    </div>
 
    </form>
     
    </div>

    
</div>
</div>

<hr>

<p>
<center>Airport information is provided by<br>
<a href="http://openaip.net/">openaip.net <img src="http://openaip.net/sites/default/themes/themeaip/logo.png"></a>
</center>
</p>

<hr>

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
