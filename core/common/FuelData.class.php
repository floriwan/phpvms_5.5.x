<?php

/**
 * phpVMS - Virtual Airline Administration Software
 * Copyright (c) 2008 Nabeel Shahzad
 * For more information, visit www.phpvms.net
 *	Forums: http://www.phpvms.net/forum
 *	Documentation: http://www.phpvms.net/docs
 *
 * phpVMS is licenced under the following license:
 *   Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
 *   View license.txt in the root, or visit http://creativecommons.org/licenses/by-nc-sa/3.0/
 *
 * @author Nabeel Shahzad
 * @copyright Copyright (c) 2008, Nabeel Shahzad
 * @link http://www.phpvms.net
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class FuelData extends CodonData {
    /**
     * Get the current fuel price for an airport, returns it in the
     * unit specified in the config file
     *
     * @param string $apt_icao ICAO of the airport
     * @return float Fuel price
     *
     * @version 709 rewritten
     */
    public static function getFuelPrice($apt_icao) {

        $aptinfo = OperationsData::GetAirportInfo($apt_icao);

        /* file price list is set in configuration */

        $fuelPriceListName = CORE_PATH . "/" . Config::Get('FUEL_PRICE');
        echo "<p>" . $fuelPriceListName . "</p>";

        if (!empty(Config::Get('FUEL_PRICE')) && file_exists($fuelPriceListName)) {
          $price = FuelData::readFuelPriceList($fuelPriceListName, $apt_icao);
          if ($price != 0) {
            echo "<p> return "  . $price . "</p>";
            return $price;
          }
        }


        if ($aptinfo->fuelprice == '' || $aptinfo->fuelprice == 0)  {
            return Config::Get('FUEL_DEFAULT_PRICE');
        }
        else    {
            return $aptinfo->fuelprice;
        }
    }

    /**
     * read fuel price from text file
     */
    public static function readFuelPriceList($fuelPriceList, $apt_icao) {

      $pricelist = file_get_contents($fuelPriceList);

      foreach (explode("\n", $pricelist) as $line) {
        $prices = explode(" ", $line);
        if (strcmp($prices[0], $apt_icao) == 0) {
          return $prices[1];
        }
      }
      return 0;
    }
}
