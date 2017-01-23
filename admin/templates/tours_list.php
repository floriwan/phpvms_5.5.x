<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<h3>Tours List</h3>

<?php
if(!$alltours) {
	echo '<p>There are no tours in database!</p>';
	return;
}
?>

<table id="tabledlist" class="tablesorter">
<thead>
  <tr>
    <th>start</th>
    <th>end</th>
    <th>title</th>
    <th></th>
  </tr>
</thead>

<tbody>

  <?php foreach($alltours as $tour) { ?>
  <tr>
    <td><?php echo $tour->valid_from ?></td>
    <td><?php echo $tour->valid_to ?></td>
    <td><?php echo $tour->title ?></td>
    <td>
      <button class="{button:{icons:{primary:'ui-icon-wrench'}}}"
			onclick="window.location='<?php echo adminurl('/Tours/editour?tourID='.$tour->id);?>';">Edit</button>

      <button class="{button:{icons:{primary:'ui-icon-info'}}}"
			onclick="window.location='<?php echo adminurl('/Tours/showtour?tourID='.$tour->id);?>';">Details</button>
    </td>

  </tr>
  <?php } ?>

</tbody>

</table>
