
<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<?php
  $stats = StatsData::getAircraftFlownData();

  $rows = array();
  $table = array();

  $table['cols'] = array(
    array('id' => '', 'label' => 'aircraft type', 'type' => 'string'),
    array('id' => '', 'label' => 'flights', 'type' => 'number')
  );


  foreach ($stats as $stat_line) {
    $temp = array();

    $temp[] = array('v' => (string) $stat_line->aircraft);
    $temp[] = array('v' => (int) $stat_line->count);
    $rows[] = array('c' => $temp);

  }

  $table['rows'] = $rows;
  $jsonTable = json_encode($table, true);

  $stats = StatsData::getAircraftHoursData();

  $rows = array();
  $phours = array();

  $phours['cols'] = array(
    array('id' => '', 'label' => 'aircraft type', 'type' => 'string'),
    array('id' => '', 'label' => 'hours', 'type' => 'number')
  );


  foreach ($stats as $stat_line) {
    $temp = array();

    $temp[] = array('v' => (string) $stat_line->aircraft);
    $temp[] = array('v' => (float) $stat_line->count);
    $rows[] = array('c' => $temp);

  }

  $phours['rows'] = $rows;
  $jsonphours = json_encode($phours, true);


?>

<script type="text/javascript">

      google.charts.load('visualization', '1', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = new google.visualization.DataTable(<?=$jsonTable?>);

        var options = {
          title: ' Aircraft Types Used by Flight',
          sliceVisibilityThreshold: 0.02,
          pieHole: 0.4,
          width: 800,
          height: 600
        };

        // Instantiate and draw our chart, passing in some options.
        // Do not forget to check your div ID
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);



        var data = new google.visualization.DataTable(<?=$jsonphours?>);

        var options = {
          title: ' Aircraft Types Used by hours',
          sliceVisibilityThreshold: 0.035,
          pieHole: 0.4,
          width: 800,
          height: 600
        };

        // Instantiate and draw our chart, passing in some options.
        // Do not forget to check your div ID
        var chart = new google.visualization.PieChart(document.getElementById('aircraft_hours'));
        chart.draw(data, options);


      }
    </script>

<h3><?php echo SITE_NAME; ?> Statistics</h3>

<p>
<div id="chart_div"></div>
</p>

<p>
<div id="aircraft_hours"></div>
</p>
