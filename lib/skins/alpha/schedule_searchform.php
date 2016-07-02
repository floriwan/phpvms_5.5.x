<h3>Search Schedules</h3>
<form id="form" action="<?php echo actionurl('/schedules/view');?>" method="post">

  <?php

  $lastarrivalicao = "";

  /* search for the last arrival airport for this pilot */
  if(Auth::LoggedIn())
  {
    $reports = PIREPData::getLastReports(Auth::$userinfo->pilotid, 1);

    if ($reports) {
      $arrairport = OperationsData::getAirportInfo($reports->arricao);
      echo "<p>Your last arrival airport : <strong>" .$reports->arricao . "</strong> (" . $arrairport->name . ")</p>";
      $lastarrivalicao = $reports->arricao;
    } else {
      echo "<p>No last airport found.</p>";
    }
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

		if(!$depairports) $depairports = array();
			foreach($depairports as $airport)
			{

        $selected = "";
        if ($lastarrivalicao === $airport->icao)
          $selected = "selected";
        else
          $selected = "";

        echo '<option '.$selected. ' value="'.$airport->icao.'">'.$airport->icao
          .' ('.$airport->name.')</option>';

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
