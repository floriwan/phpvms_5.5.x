<?php
/**
 * @author Florian Göldenitz
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class AircraftData extends CodonData {


  public static function getAllLiveries() {
    $sql = "SELECT * FROM " . TABLE_PREFIX . "aircraft_liveries";
    $ret = DB::get_results($sql);
    return $ret;
  }

  public static function loadLivery($id) {

    $sql = "SELECT * FROM " . TABLE_PREFIX . "aircraft_liveries WHERE `id`=".$id;
    //echo "<p> load " . $sql . "</p>";
    return DB::get_row($sql);
  }

  public static function getLiveries($aircraftID) {
    //echo "<p>" . $aircraftID . "</p>";
    $sql = "SELECT * FROM " . TABLE_PREFIX . "aircraft_liveries WHERE `aircraftID`=".$aircraftID;
    //echo "<p>" . $sql . "</p>";
    return DB::get_results($sql);

  }

  public static function deleteLivery($liveryID) {
    $sql = "DELETE FROM " . TABLE_PREFIX . "aircraft_liveries WHERE `id`=".$liveryID;
    $res = DB::query($sql);
    if (DB::errno() != 0) return false;
    return true;
  }

  public static function saveLivery($aircraftID, $registration, $sim, $desc, $link, $image) {

    $sql = "INSERT INTO ". TABLE_PREFIX . "aircraft_liveries (`registration`, `sim`, `desc`, `image`, `link`, `aircraftID`)
      VALUES  ('$registration', '$sim', '$desc', '$image', '$link', '$aircraftID')";

    $res = DB::query($sql);
    if (DB::errno() != 0) return false;

    return true;

  }

  public static function updateLivery($liveryID, $registration, $sim, $desc, $link, $image) {

    $sql = "UPDATE ". TABLE_PREFIX . "aircraft_liveries SET `registration`='$registration', `sim`='$sim', `desc`='$desc', `image`='$image', `link`='$link' WHERE `ID`='$liveryID'";
    $res = DB::query($sql);
    if (DB::errno() != 0) return false;
    return true;

  }

}
