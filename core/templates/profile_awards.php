<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<h3>My Awards</h3>



<?php
if(!$allawards) {
  echo 'No awards yet';
} else {

?>
<table>

  <?php foreach($allawards as $award){ ?>
  <tr><td><img src="<?php echo $award->image?>" alt="<?php echo $award->descrip?>" /></td>
    <td><?php echo $award->name ?></td></tr>
  <?php } ?>

</table>
<?php
}
