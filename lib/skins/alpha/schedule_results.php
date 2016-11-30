<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

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


<script type="text/javascript">

$(document).ready(function() {
        $('#schedule').dataTable( {
                "pagingType":   "full_numbers",
                "order":        [[ 0, "asc" ]],
                "ordering":     false
        } );


        $('#schedule thead #searchcol').each( function () {
          var title = $(this).text();
          //$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
          $(this).html( '<input type="text" placeholder="Search" />' );
        } );

        // DataTable
        var table = $('#schedule').DataTable();

        // Apply the search
        table.columns().every( function () {
                var that = this;

                $( 'input', this.header() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
        } );

} );
</script>

<?php

if(!$schedule_list)
{
	echo '<p align="center">No routes have been found!</p>';
	return;
}
?>

<table id="schedule" class="display">
<thead>
  <tr>
    <th>Departure</th>
    <th>Arrival</th>
    <th>Flight</th>
    <th>Aircraft</th>
    <th>Flight Info</th>
    <th>Options</th>
  </tr>

  <tr>
    <th id="searchcol">Departure</th>
    <th id="searchcol">Arrival</th>
    <th id="searchcol">Flight</th>
    <th id="searchcol">Aircraft</th>
    <th></th>
    <th></th>
  </tr>

</thead>
<tfoot>
  <tr>
    <th id="searchcol">Departure</th>
    <th id="searchcol">Arrival</th>
    <th id="searchcol">Flight</th>
    <th id="searchcol">Aircraft</th>
    <th>Flight Info</th>
    <th>Options</th>
  </tr>
</tfoot>

<tbody>

  <?php foreach($schedule_list as $schedule) { ?>
    <tr>
        <?php
          $depairport = OperationsData::getAirportInfo($schedule->depicao);
          $arrairport = OperationsData::getAirportInfo($schedule->arricao);
         ?>
        <td><img src="<?php echo Countries::getCountryImage($depairport->country);?>"
          alt="<?php echo Countries::getCountryName($depairport->country);?>" />
          <?php echo $schedule->depicao ?></td>
        <td><img src="<?php echo Countries::getCountryImage($arrairport->country);?>"
          alt="<?php echo Countries::getCountryName($arrairport->country);?>" />
          <?php echo $schedule->arricao ?></td>
        <td><a href="<?php echo url('/schedules/details/'.$schedule->id);?>"><?php echo $schedule->code . $schedule->flightnum ?></a></td>
        <td><a href="<?php echo url('/vFleetTracker/view/'.$schedule->registration) ?>"><?php echo $schedule->aircraft; ?> (<?php echo $schedule->registration;?>)</a></td>
        <td><strong>Departure: </strong><?php echo $schedule->deptime;?> &nbsp;&nbsp;&nbsp; <strong>Arrival: </strong><?php echo $schedule->arrtime;?><br />
          <strong>Distance: </strong><?php echo $schedule->distance . Config::Get('UNITS');?><br />
          <strong>Days Flown: </strong><?php echo Util::GetDaysCompact($schedule->daysofweek); ?><br />
        </td>
        <td><a href="<?php echo url('/schedules/details/'.$schedule->id);?>">View Details</a><br />
          <a href="<?php echo url('/schedules/brief/'.$schedule->id);?>">Pilot Brief</a><br />
          <?php
      		# Don't allow overlapping bids and a bid exists
      		if(Config::Get('DISABLE_SCHED_ON_BID') == true && $schedule->bidid != 0) {
      		?>
      			<a id="<?php echo $schedule->id; ?>" class="addbid"
      				href="<?php echo actionurl('/schedules/addbid/?id='.$schedule->id);?>">Add to Bid</a>
      		<?php
      		} else {
      			if(Auth::LoggedIn()) {
      			 ?>
      				<a id="<?php echo $schedule->id; ?>" class="addbid"
      					href="<?php echo url('/schedules/addbid');?>">Add to Bid</a>
      			<?php
      			}
      		}
      		?>
        </td>

<!--echo "<td><a href='".url('/vFleetTracker/view/'.$aircraft->registration)."'>".$aircraft->registration."</a></td>";-->

    </tr>
  <?php } ?>

</tbody>
</table>
