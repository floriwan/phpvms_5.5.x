<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<h3><?php echo $title?></h3>
<form id="flashForm" action="<?php echo adminaction('/operations/scenery');?>" method="post">
<dl>
<dt>Airport ICAO Code *</dt>
<dd><input id="airporticao" name="icao" type="text" value="<?php echo $scenery->icao?>" /> 
	<!--<button id="lookupicao" onclick="lookupICAO(); return false;">Look Up</button>-->
</dd>

<dt>Simulator *</dt>
<dd><select name="simulator">
    <option value="FSX/P3D">FSX/P3D</option>
    <option value="X-Plane">X-Plane</option>
    </select>
    
<!--<dd><input id="scenerysimulator" name="simulator" type="text" value="<?php echo $scenery->sim?>"  /></dd>-->

<dt>Short Description</dt>
<dd><input id="scenerydescription" name="description" type="text" value="<?php echo $scenery->descr?>" /></dd>

<dt>Link *</dt>
<dd><input id="scenerylink" name="link" type="text" value="<?php echo $scenery->link?>" /></dd>

<dt>Payware</dt>
<?php
	if($scenery->payware == '1')
		$checked = 'checked ';
	else
		$checked = '';
?>
<dd><input name="payware" type="checkbox" value="true" <?php echo $checked?>/></dd>


<dt></dt>
<dd>
    <input type="hidden" name="action" value="<?php echo $action?>" />
    <input type="hidden" name="oldicao" value="<?php echo $scenery->icao?>" />
    <input type="submit" name="submit" value="<?php echo $title?>" />
    
</dd>
</dl>
</form>