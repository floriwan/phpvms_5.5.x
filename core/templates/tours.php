<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<!--<h2>FlyCaribbean Tours Overview</h2>-->

<div class="box">

<header>
  <h3><?php echo $tour->title ?></h3>
  <!--<p>
    <a href="<?php echo url('/Tours/toursDetail/'.$tour->id);?>">
    <i class="fa fa-info-circle" aria-hidden="true"></i> Tour Details </a>
  </p>-->
</header>

<span class="image fit">
  <img src="<?php echo $tour->image ?>">
</span>

<p><?php echo $tour->description ?></p>

<table>
  <thtead>
    <tr>
      <th>start date</th><th>end date</th><th>num. Legs</th><th>distance</th><th></th><th>tour details</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <?php if ($tour->valid_from == "2010-01-01" && $tour->valid_to == "2999-01-01") { ?>
        <td>always active</td>
        <td>&nbsp;</td>
      <?php } else { ?>
        <td><?php echo $tour->valid_from ?></td>
        <td><?php echo $tour->valid_to ?></td>
      <?php } ?>
      <td><?php echo $numberLegs ?></td>
      <td><?php echo $distance ?> nm</td>
      <td>
        <?php if ($tour->random == 1) { ?>
          Legs can be flown in any order
        <?php } else { ?>
          Legs must be flown in the given order
        <?php } ?>
      </td>
      <td><a href="<?php echo url('/Tours/toursDetail/'.$tour->id);?>">
      <i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
    </tr>
  </tbody>

</table>

</div>

</ul>
