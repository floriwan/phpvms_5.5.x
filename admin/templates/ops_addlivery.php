<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<h3>Add Livery</h3>

<form action="<?php echo adminurl('/operations/liveries');?>" method="post">

<dt>Aircraft ICAO Code</dt>
<dd><?php echo $aircraft->icao; ?></dd>

<dt>Aircraft Registration </td>
<dd> <?php echo $aircraft->registration; ?></dd>

<dt>* Sim</dt>
<dd>
  <select name="sim">
    <option value="<?php echo Config::Get('FSX') ?>">FSX</option>
    <option value="<?php echo Config::Get('P3D') ?>">P3D</option>
    <option value="<?php echo Config::Get('X-Plane') ?>">X-Plane</option>
  </select>
</dd>

<dt>* Download URL</dt>
<dd><input name="link" type="text"  value="" /></dd>

<dt>Image</dt>
<dd><input name="image" type="text"  value="" /></dd>

<dt>Description</dt>
<dd><input name="desc" type="text"  value="" /></dd>

<dt></dt>
<dd><input type="hidden" name="aircraftID" value="<?php echo $aircraft->id;?>" />
  <input type="hidden" name="registration" value="<?php echo $aircraft->registration; ?>" />
	<input type="hidden" name="action" value="addlivery" />
	<input type="submit" name="submit" value="Add Livery" />
</dd>

</form>
