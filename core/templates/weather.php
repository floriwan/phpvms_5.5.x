
<p>

  <?php if (strlen($metar) > 1) { ?>

    <?php echo $metar; ?></br>

    <strong>Weather report for <?php echo $site ?> (<?php echo $station_id; ?>) at <?php echo WeatherData::format_date($observation_time); ?>:</strong></br>

    wind from <?php echo $wind_dir_degrees; ?>&deg; (<?php echo WeatherData::wind_direction($wind_dir_degrees); ?>) at <?php echo $wind_speed_kt; ?> knots</br>

    <?php if ($visibility_statute_mi == '9999' || $visibility_statute_mi > 6) { ?>
      visibility is 10km (6 miles) or more</br>
    <?php } else { ?>
      visibility is <?php echo $visibility_statute_mi; ?> miles</br>
    <?php } ?>

    <?php echo WeatherData::convert_clouds($sky_cover); ?> at <?php echo $sky_cloud_base; ?> feet</br>

    <?php if ($sky_cover1) { ?>
        <?php echo WeatherData::convert_clouds($sky_cover1); ?> at <?php echo $sky_cloud_base1; ?> feet</br>
    <?php } ?>

    <?php if ($sky_cover2) { ?>
        <?php echo WeatherData::convert_clouds($sky_cover2); ?> at <?php echo $sky_cloud_base2; ?> feet</br>
    <?php } ?>

    <?php if ($sky_cover3) { ?>
        <?php echo WeatherData::convert_clouds($sky_cover3); ?> at <?php echo $sky_cloud_base3; ?> feet</br>
    <?php } ?>



    Temperature <?php echo $temp_c ?>&deg;C (<?php echo WeatherData::degreeToFahrenheit($temp_c); ?>&deg;F),
    dew point <?php echo $dewpoint_c ?>&deg;C (<?php echo WeatherData::degreeToFahrenheit($dewpoint_c); ?>&deg;F)</br>

    QNH <?php echo WeatherData::inHgToQNH($altim_in_hg); ?> hPa (<?php echo $altim_in_hg; ?> inHg) </br>

    flight category <?php echo $flight_category ?> </br>

  <?php } else { ?>
    no metar information for <?php echo $station_id; ?> available.</br>
  <?php } ?>

</p>
