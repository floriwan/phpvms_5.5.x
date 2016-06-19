<h3>Search Schedules</h3>
<form id="form" action="<?php echo actionurl('/schedules/view');?>" method="post">

  <?php
  if(Auth::LoggedIn())
  {
    $search = array(
      'p.pilotid' => Auth::$userinfo->pilotid,
      'p.accepted' => PIREP_ACCEPTED
    );

    $reports = PIREPData::findPIREPS($search, 1); // return only one

    if(is_object($reports))
    {
      # IF the arrival airport doesn't match the departure airport
      echo "<p>last arrival : ".$reports->arricao."</p>";
      if($reports->arricao != $route->depicao)
      {
        continue;
      }
    }
    echo "<p>last arrival : ".$reports->arricao."</p>";
  }

  ?>

<div id="tabcontainer">
	<ul>
		<li><a href="#depapttab"><span>By Departure Airport</span></a></li>
		<li><a href="#arrapttab"><span>By Arrival Airport</span></a></li>
		<li><a href="#aircrafttab"><span>By Aircraft Type</span></a></li>
		<li><a href="#distance"><span>By Distance</span></a></li>
	</ul>
	<div id="depapttab">
		<p>Select your departure airport:</p>

		<select id="depicao" name="depicao">
		<option value="">Select All</option>
		<?php


    if(Auth::LoggedIn())
    {
      $search = array(
        'p.pilotid' => Auth::$userinfo->pilotid,
        'p.accepted' => PIREP_ACCEPTED
      );

      $reports = PIREPData::findPIREPS($search, 1); // return only one

      if(is_object($reports))
      {
        # IF the arrival airport doesn't match the departure airport
        if($reports->arricao != $route->depicao)
        {
          continue;
        }
      }
    }

		if(!$depairports) $depairports = array();
			foreach($depairports as $airport)
			{
        if ($airport->icao == $reports->arricao) {
          echo '<option selected value="'.$airport->icao.'">'.$airport->icao
  						.' ('.$airport->name.')</option>';
        } else {
				  echo '<option value="'.$airport->icao.'">'.$airport->icao
						.' ('.$airport->name.')</option>';
          }
			}
		?>

		</select>
		<input type="submit" name="submit" value="Find Flights" />
	</div>
	<div id="arrapttab">
		<p>Select your arrival airport:</p>
		<select id="arricao" name="arricao">
			<option value="">Select All</option>
		<?php
		if(!$depairports) $depairports = array();
			foreach($depairports as $airport)
			{
				echo '<option value="'.$airport->icao.'">'.$airport->icao
						.' ('.$airport->name.')</option>';
			}
		?>

		</select>
		<input type="submit" name="submit" value="Find Flights" />
	</div>
	<div id="aircrafttab">
		<p>Select aircraft:</p>
		<select id="equipment" name="equipment">
			<option value="">Select equipment</option>
		<?php

		if(!$equipment) $equipment = array();
		foreach($equipment as $equip)
		{
			echo '<option value="'.$equip->name.'">'.$equip->name.'</option>';
		}

		?>
		</select>
		<input type="submit" name="submit" value="Find Flights" />
	</div>
	<div id="distance">
		<p>Select Distance:</p>
		<select id="type" name="type">
			<option value="greater">Greater Than</option>
			<option value="less">Less Than</option>
		</select>
		<input type="text" name="distance" value="" />
		<input type="submit" name="submit" value="Find Flights" />
	</div>
</div>

<p>
<input type="hidden" name="action" value="findflight" />
</p>
</form>
<script type="text/javascript">

</script>
<hr>
