
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

  // pilot hours
  $stats = StatsData::getTopPilotsHours();
  $pilothours = array();

  $pilothours[] = array('pilot', 'hours');

  foreach ($stats as $stat_line) {
    $pilothours[] = array((string) PilotData::getPilotCode($stat_line->code, $stat_line->pilotid),
      (float) $stat_line->totalhours);
  }

  $jsonpilothours = json_encode($pilothours, true);

  // pilot flights
  $stats = StatsData::getTopPilotsFlights();
  $pilotflights = array();

  $pilotflights[] = array('pilot', 'flights');

  foreach ($stats as $stat_line) {
    $pilotflights[] = array((string) PilotData::getPilotCode($stat_line->code, $stat_line->pilotid),
      (float) $stat_line->totalflights);
  }

  $jsonpilotflights = json_encode($pilotflights, true);

  // PIREP per month
  $pirepByMonth = PIREPData::getIntervalCurrentYear();

  $pirepArrayStats = array();
  $pirepArrayStats[] = array('month', 'pireps');

  foreach ($pirepByMonth as $pirepStat) {
    $pirepArrayStats[] = array((string)$pirepStat->ym, (int)$pirepStat->total );
  }
  $jsonPirepStats = json_encode($pirepArrayStats, true);


  // light time per month in hours
  $hoursPerMonth = PIREPData::getIntervalCurrentYear($where_params);
  $where_params[] = ' p.log LIKE \'%IVAO%\'';
  $hoursIvaoPerMonth = PIREPData::getIntervalCurrentYear($where_params);
  //print_r($hoursIvaoPerMonth);

  $onlineHours = array();
  $onlineHours[] = array('month', 'overall', 'ivao');

  foreach ($hoursPerMonth as $stat_line) {

    $ivao_hours = 0;

    foreach ($hoursIvaoPerMonth as $ivaoh) {
      if ($ivaoh->ym == $stat_line->ym)
        $ivao_hours = $ivaoh->flighttime;
    }

    $onlineHours[] = array((string)$stat_line->ym, (int)$stat_line->flighttime, (int)$ivao_hours);

  }
  $jsonOnlineHoursStats = json_encode($onlineHours, true);
  //print_r($jsonOnlineHoursStats);


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
          width: 500,
          height: 400
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);


        // plane by hours
        var data = new google.visualization.DataTable(<?=$jsonphours?>);

        var options = {
          title: ' Aircraft Types Used by hours',
          sliceVisibilityThreshold: 0.035,
          pieHole: 0.4,
          width: 500,
          height: 400
        };

        var chart = new google.visualization.PieChart(document.getElementById('aircraft_hours'));
        chart.draw(data, options);

        // routs flown
        var data = new google.visualization.DataTable(<?=$jsonroutes?>);

        var options = {
          title: ' Routes',
          sliceVisibilityThreshold: 0.015,
          pieHole: 0.4,
          width: 500,
          height: 400
        };

        var chart = new google.visualization.PieChart(document.getElementById('routes'));
        chart.draw(data, options);

        // pilot hours
        var data = new google.visualization.arrayToDataTable(<?=$jsonpilothours?>);

        var options = {
          title: 'pilot hours',
          width: 500,
          height: 400
        };

        //var chart = new google.visualization.DataView(document.getElementById('pilot_hours'));
        var chart = new google.visualization.ColumnChart(document.getElementById('pilot_hours'));
        chart.draw(data, options);

        // pilot flights1
        var data = new google.visualization.arrayToDataTable(<?=$jsonpilotflights?>);

        var options = {
          title: 'pilot flights',
          width: 500,
          height: 400
        };

        //var chart = new google.visualization.DataView(document.getElementById('pilot_hours'));
        var chart = new google.visualization.ColumnChart(document.getElementById('pilot_flights'));
        chart.draw(data, options);

        // PIREP stats
        var data = new google.visualization.arrayToDataTable(<?=$jsonPirepStats?>);

        var options = {
          title: 'PIREPS per month',
          hAxis: { title: 'month' },
          vAxis: { title: 'hours' },
          curveType: 'function',
          width: 500,
          height: 400
        };

        var chart = new google.visualization.LineChart(document.getElementById('pireps'));
        chart.draw(data, options);

        // online hours
        var data = new google.visualization.arrayToDataTable(<?=$jsonOnlineHoursStats?>);

        var options = {
          title: 'hours per month',
          hAxis: { title: 'month' },
          vAxis: { title: 'hours' },
          curveType: 'function',
          width: 500,
          height: 400
        };

        var chart = new google.visualization.LineChart(document.getElementById('online_hours'));
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

  <div class="features-row">
    <section>
      <div id="pireps"></div>
    </section>
    <section>
      <div id="online_hours"></div>
    </section>
  </div>

  <div class="features-row">
    <section>
      <div id="pilot_hours"></div>
    </section>

    <section>
      <div id="pilot_flights"></div>
    </section>

  </div>
