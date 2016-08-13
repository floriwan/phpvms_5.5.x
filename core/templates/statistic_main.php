
<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<?php

  // aircraft usage
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

  // aircraft hours
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

  // routes
  $stats = StatsData::getFlownRoutes();
  print_r($routes);
  $rows = array();
  $routes = array();

  $routes['cols'] = array(
    array('id' => '', 'label' => 'route', 'type' => 'string'),
    array('id' => '', 'label' => 'count', 'type' => 'number')
  );

  foreach ($stats as $stat_line) {
    $temp = array();

    $temp[] = array('v' => (string) $stat_line->fromto);
    $temp[] = array('v' => (float) $stat_line->count);
    $rows[] = array('c' => $temp);

  }

  $routes['rows'] = $rows;
  $jsonroutes = json_encode($routes, true);

  //$stats = StatsData::TopRoutes();
  //print_r($stats);

?>

<script type="text/javascript">

      google.charts.load('visualization', '1', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        // plane by flown
        var data = new google.visualization.DataTable(<?=$jsonTable?>);

        var options = {
          title: ' Aircraft Types Used by Flight',
          sliceVisibilityThreshold: 0.02,
          pieHole: 0.4,
          width: 400,
          height: 300
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);


        // plane by hours
        var data = new google.visualization.DataTable(<?=$jsonphours?>);

        var options = {
          title: ' Aircraft Types Used by hours',
          sliceVisibilityThreshold: 0.035,
          pieHole: 0.4,
          width: 400,
          height: 300
        };

        var chart = new google.visualization.PieChart(document.getElementById('aircraft_hours'));
        chart.draw(data, options);

        // routs flown

        var data = new google.visualization.DataTable(<?=$jsonroutes?>);

        var options = {
          title: ' Routes',
          pieHole: 0.4,
          width: 400,
          height: 300
        };

        var chart = new google.visualization.PieChart(document.getElementById('routes'));
        chart.draw(data, options);

      }
    </script>


<h3><?php echo SITE_NAME; ?> Statistics</h3>
<p>Work in progress</p>


  <div class="features-row">
    <section>
      <div id="chart_div"></div>
    </section>
    <section>
      <div id="aircraft_hours"></div>
    </section>
  </div>

  <div class="features-row">
    <section>
      <div id="routes"></div>
    </section>
    <section>
    </section>
  </div>
