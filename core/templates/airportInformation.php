<h4>Airport Information for <?php echo $schedule->depname ?> (<?php echo $schedule->depicao; ?>)</h4>
<div class="table-wrapper">
<table class="alt">
<tbody>
    <tr>
        <td>Coordinates</td>
        <td>N<?php echo $latdms['deg'] ?>&deg; <?php echo $latdms['min'] ?>' <?php echo $latdms['sec'] ?>'' / 
            W<?php echo $londms['deg'] ?>&deg; <?php echo $londms['min'] ?>' <?php echo $londms['sec'] ?>''<br>
            <font size="-1"><sup>Latitude: <?php echo $arrAirport[0]->lat ?> Longitude: <?php echo $arrAirport[0]->lon ?></sup></font>
        </td>
    </tr>
    <tr>
        <td>Elevation</td>
        <td><?php echo OpenAIPData::meter2feet($arrAirport[0]->elev) ?> feet MSL</td>
</tbody>
</table>
</div>
