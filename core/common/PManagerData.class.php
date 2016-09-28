<?php
class PManagerData extends CodonData
{
	public static function pilots()
	{
		$sql="SELECT * FROM " . TABLE_PREFIX . "pilots";

		return DB::get_results($sql);
	}

	public static function getpilotbyemail($email)
	{
		$sql="SELECT * FROM " . TABLE_PREFIX . "pilots WHERE email = '$email' ";

		return DB::get_row($sql);
	}

	public static function checkpilot($id)
	{
		$sql="SELECT * FROM " . TABLE_PREFIX . "pilot_manager WHERE pid = '$id' ";

		return DB::get_row($sql);
	}

	public static function createpilot($pid, $pfname, $plname)
	{
		$sql = "INSERT INTO " . TABLE_PREFIX . "pilot_manager (pid, pfname, plname, blank, warning, welcome, message, datesent)
								  VALUES ('$pid', '$pfname', '$plname', '0', '0', '0', 'welcome', '')";
			DB::query($sql);
	}

	public static function param($pid)
	{
		$sql="SELECT * FROM " . TABLE_PREFIX . "pilot_manager WHERE pid = '$pid'";

		return DB::get_row($sql);
	}

	public static function getpirep($pilotid)
	{
		$sql="SELECT * FROM " . TABLE_PREFIX . "pireps WHERE pilotid = '$pilotid' ORDER BY submitdate DESC";

		return DB::get_row($sql);
	}

	public static function warningsent($pilot, $message)
		{
			$sent = self::param($pilot);
			$sen = $sent->warning;
      $message = DB::escape($message);
			$sql = "UPDATE " . TABLE_PREFIX . "pilot_manager SET warning='$sen' + '1', message='$message', datesent=NOW() WHERE pid='$pilot'";
			DB::query($sql);
		}

	public static function welcomesent($pilot, $message)
		{
			$sent = self::param($pilot);
			$sen = $sent->welcome;
      $message = DB::escape($message);
			$sql = "UPDATE " . TABLE_PREFIX . "pilot_manager SET welcome='$sen' + '1', message='$message', datesent=NOW() WHERE pid='$pilot'";
			DB::query($sql);
		}

	public static function blanksent($pilot, $message)
		{
			$sent = self::param($pilot);
			$sen = $sent->blank;
      $message = DB::escape($message);
			$sql = "UPDATE " . TABLE_PREFIX . "pilot_manager SET blank='$sen' + '1', message='$message', datesent=NOW() WHERE pid='$pilot'";
			DB::query($sql);
		}
}
?>
