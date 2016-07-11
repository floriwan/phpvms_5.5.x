<?php

function get_metar($location){
  $fileName = "http://weather.noaa.gov/pub/data/observations/metar/stations/$location.TXT";
  $metar = '';
  $fileData = @file($fileName); //or die ("weather script died :-(");
  if ($fileData != false) {
    list($i, $date) = each($fileData);

    $utc = strtotime(trim($date));
    $time = date("D, F jS Y g:i A",$utc);

    while (list($i, $line) = each($fileData)) {
      $metar .= ' ' . trim($line);
    }
    $metar = trim(str_replace(' ', ' ', $metar));
    echo "<strong>METAR FOR $location ($time UTC):</strong><br \>$metar";
  } else {
    echo "METAR for ". $location . " not available";
  }
}


 ?>
