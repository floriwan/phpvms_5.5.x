<?php

class Weather extends CodonModule {

	public function index() {
	}

  public function request_metar($icao) {
    $metar_xml = WeatherData::get_metar_xml($icao);
    $info_xml = WeatherData::get_info_xml($icao);

    $this->set('metar', $metar_xml->data->METAR->raw_text);
    $this->set('dewpoint_c', $metar_xml->data->METAR->dewpoint_c);
    $this->set('flight_category', $metar_xml->data->METAR->flight_category);
    $this->set('temp_c', $metar_xml->data->METAR->temp_c);
    $this->set('observation_time', $metar_xml->data->METAR->observation_time);
    $this->set('visibility_statute_mi', $metar_xml->data->METAR->visibility_statute_mi);
    $this->set('wind_dir_degrees', $metar_xml->data->METAR->wind_dir_degrees);
    $this->set('wind_speed_kt', $metar_xml->data->METAR->wind_speed_kt);
    $this->set('altim_in_hg', $metar_xml->data->METAR->altim_in_hg);
    $this->set('sky_cover', $metar_xml->data->METAR->sky_condition[0]['sky_cover']);
    $this->set('sky_cloud_base', $metar_xml->data->METAR->sky_condition[0]['cloud_base_ft_agl']);

    $this->set('sky_cover1', $metar_xml->data->METAR->sky_condition[1]['sky_cover']);
    $this->set('sky_cloud_base1', $metar_xml->data->METAR->sky_condition[1]['cloud_base_ft_agl']);

    $this->set('sky_cover2', $metar_xml->data->METAR->sky_condition[2]['sky_cover']);
    $this->set('sky_cloud_base2', $metar_xml->data->METAR->sky_condition[2]['cloud_base_ft_agl']);

    $this->set('sky_cover3', $metar_xml->data->METAR->sky_condition[3]['sky_cover']);
    $this->set('sky_cloud_base3', $metar_xml->data->METAR->sky_condition[3]['cloud_base_ft_agl']);

    $this->set('flight_category', $metar_xml->data->METAR->flight_category);

    $this->set('latitude', $info_xml->data->Station->latitude);
    $this->set('longitude', $info_xml->data->Station->longitude);
    $this->set('elevation_m', $info_xml->data->Station->elevation_m);
		$this->set('station_id', $info_xml->data->Station->station_id);
		$this->set('site', $info_xml->data->Station->site);
		$this->set('stationcountry', $info_xml->data->Station->stationcountry);

    $this->render('weather.php');

  }


}
