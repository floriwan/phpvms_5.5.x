<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<h3>Edit Livery</h3>

<form action="<?php echo adminurl('/operations/liveries');?>" method="post">

<dt>Aircraft</dt>
<dd><?php echo $aircraft->registration . " (". $aircraft->icao . ")" ?></dd>

<dt>* Sim</dt>
<dd>
  <select name="sim">
    <option <?php if ($livery->sim == Config::Get('FSX')) echo "selected" ?> value="<?php echo Config::Get('FSX') ?>">FSX</option>
    <option <?php if ($livery->sim == Config::Get('P3D')) echo "selected" ?> value="<?php echo Config::Get('P3D') ?>">P3D</option>
    <option <?php if ($livery->sim == Config::Get('X-Plane')) echo "selected" ?> value="<?php echo Config::Get('X-Plane') ?>">X-Plane</option>
  </select>
</dd>

<dt>* Download URL</dt>
<dd><input name="link" type="text"  value="<?php echo $livery->link ?>" /></dd>

<dt>Image</dt>
<dd><input name="image" type="text"  value="<?php echo $livery->image ?>" /></dd>

<dt>Description</dt>
<dd><input name="desc" type="text"  value="<?php echo $livery->desc ?>" /></dd>

<dt></dt>
<dd><input type="hidden" name="aircraftID" value="<?php echo $aircraft->id;?>" />
  <input type="hidden" name="registration" value="<?php echo $aircraft->registration; ?>" />
  <input type="hidden" name="liveryID", value="<?php echo $livery->ID; ?>" />
	<input type="hidden" name="action" value="editlivery" />
	<input type="submit" name="submit" value="Save Livery" />
</dd>

</form>
