<?php

    /**
    * Pirep Auto Accept & Decline for PHPvms
    * For more information, visit www.baggelis.com
    *
    * Pirep Auto Accept & Decline is licenced under the following license:
    *   Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
    *   View license.txt in the root, or visit http://creativecommons.org/licenses/by-nc-sa/3.0/
    *
    * @author Vangelis Boulasikis
    * @copyright Copyright (c) 2014, Vangelis Boulasikis
    * @link http://www.baggelis.com
    * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
    * version released 7/5/2014
    */

    class PirepAcData extends Codondata {

        public static function get_criteria() {
            $query = "SELECT *
            FROM ".TABLE_PREFIX."autopirep";

            return DB::get_results($query);
        }

        public static function get_settings() {
            $query = "SELECT *
            FROM ".TABLE_PREFIX."autopirep_settings";

            return DB::get_row($query);
        }

        public static function getCriteriaById($id)
        {

            $criteria = DB::get_row('SELECT * FROM '.TABLE_PREFIX.'autopirep
                WHERE `id`=\''.$id.'\'');

            return $criteria;
        }

        public static function editSettings($setting_id,$moduleenabled,$landing_rate, $send_mail_to_admin, $send_mail_to_pilot, $admin_code)
        {

            /*  $sql = "UPDATE ".TABLE_PREFIX."autopirep_settings
            SET `landing_rate`='$landingrate', `sendmail_to_admin`='$sendmailtoadmin',`sendmail_to_pilot`='$sendmailtopilot', `admin_rejecting`=$admincode
            WHERE setting_id=1";

            $res = DB::query($sql);

            if(DB::errno() != 0)
            return false;



            return true;           */
            $id = DB::escape($setting_id);
            $landingrate = DB::escape($landing_rate);
            $mailadmin = DB::escape($send_mail_to_admin);
            $mailpilot = DB::escape($send_mail_to_pilot);
            $admincode = DB::escape($admin_code);

            $sql = "UPDATE phpvms_autopirep_settings
            SET landing_rate='$landingrate', enabled='$moduleenabled',sendmail_to_admin='$mailadmin',sendmail_to_pilot='$mailpilot', admin_rejecting='$admincode'
            WHERE setting_id=$id";

            $res = DB::query($sql);

            if(DB::errno() != 0)
                return false;

            return true;
        }
        public static function addcriteria($name, $value, $custommsg)
        {

            $name = DB::escape($name);
            $value = DB::escape($value);
            $custommsg = DB::escape($custommsg);

            $sql = "INSERT INTO " .TABLE_PREFIX."autopirep (
            `criteria_description`, `criteria_variable`, `criteria_custom_message`)
            VALUES ('$name', '$value','$custommsg' )";

            $res = DB::query($sql);

            if(DB::errno() != 0)
                return false;



            return true;
        }

        public static function editCriteria($id, $criteria_description, $criteria_variable,$custommsg, $enabled=true)
        {
            $code = DB::escape($criteria_description);
            $name = DB::escape($criteria_variable);
            $msg = DB::escape($custommsg);

            if($enabled) $enabled = 1;
            else $enabled = 0;

            $sql = "UPDATE ".TABLE_PREFIX."autopirep
            SET `criteria_description`='$code', `criteria_variable`='$name',`criteria_custom_message`='$msg', `enabled`=$enabled
            WHERE id=$id";

            $res = DB::query($sql);

            if(DB::errno() != 0)
                return false;



            return true;
        }
        public static function deleteCriteria($id)
        {
            if($id == '') return false;
            $id = intval($id);

            $sql = 'DELETE FROM '. TABLE_PREFIX.'autopirep
            WHERE id='.$id;

            $res = DB::query($sql);

        }

        public static function reject_pirep_post($id)
        {
            $pirepid = $id;


            PIREPData::ChangePIREPStatus($pirepid, PIREP_REJECTED); // 2 is rejected
            $pirep_details = PIREPData::GetReportDetails($pirepid);

            // If it was previously accepted, subtract the flight data
            if(intval($pirep_details->accepted) == PIREP_ACCEPTED)
            {
                PilotData::UpdateFlightData($pirep_details->pilotid, -1 * floatval($pirep->flighttime), -1);
            }

            //PilotData::UpdatePilotStats($pirep_details->pilotid);
            RanksData::CalculateUpdatePilotRank($pirep_details->pilotid);
            PilotData::resetPilotPay($pirep_details->pilotid);
            StatsData::UpdateTotalHours();



            # Call the event
            CodonEvent::Dispatch('pirep_rejected', 'PIREPAdmin', $pirep_details);
        }

        public static function approve_pirep_post($id)
        {
            $pirepid = $id;

            if($pirepid == '') return;

            $pirep_details  = PIREPData::GetReportDetails($pirepid);

            # See if it's already been accepted
            if(intval($pirep_details->accepted) == PIREP_ACCEPTED) return;

            # Update pilot stats
            SchedulesData::IncrementFlownCount($pirep_details->code, $pirep_details->flightnum);
            PIREPData::ChangePIREPStatus($pirepid, PIREP_ACCEPTED); // 1 is accepted
            PilotData::UpdateFlightData($pirep_details->pilotid, $pirep_details->flighttime, 1);
            //PilotData::UpdatePilotPay($pirep_details->pilotid, $pirep_details->flighttime);

            RanksData::CalculateUpdatePilotRank($pirep_details->pilotid);
            PilotData::GenerateSignature($pirep_details->pilotid);
            StatsData::UpdateTotalHours();



            # Call the event
            CodonEvent::Dispatch('pirep_accepted', 'PIREPAdmin', $pirep_details);
        }

        public static function pirep_stand_by($id)
        {

            $pirepid = $id;
            PIREPData::ChangePIREPStatus($pirepid, PIREP_PENDING); // 1 is accepted

            $pirep_details = PIREPData::GetReportDetails($pirepid);

            // If it was previously accepted, subtract the flight data
            if(intval($pirep_details->accepted) == PIREP_ACCEPTED)
            {
                PilotData::UpdateFlightData($pirep_details->pilotid, -1 * floatval($pirep->flighttime), -1);
            }

            //PilotData::UpdatePilotStats($pirep_details->pilotid);
            RanksData::CalculateUpdatePilotRank($pirep_details->pilotid);
            PilotData::resetPilotPay($pirep_details->pilotid);
            StatsData::UpdateTotalHours();

        }


        public static function search($id) {

          $reject_pirep = false;

          // get auopirep setting from db
          $sqlset ="SELECT * FROM ".TABLE_PREFIX."autopirep_settings";
          $settings = DB::get_row($sqlset);
          $adminid=PilotData::parsePilotID($settings->admin_rejecting) ;

          // if plugin is diabled, do nothing and return
          if ($settings->enabled == 0) {
            return;
          }

          // get pirep details
          $pirepdetails = PIREPData::getReportDetails($id);
          // get pilots data
          $pilotid=PilotData::GetPilotCode($pirepdetails->code,$pirepdetails->pilotid) ;
          $userinfo = PilotData::getPilotData($pirepdetails->pilotid);
          //echo "<p> pilot id " . $pilotid . "</p>";

          // get active autoaccept criteria from db
          $sql = "SELECT * FROM ".TABLE_PREFIX."autopirep WHERE enabled = '1'";
          $criteria = DB::get_results($sql);

          if($pirepdetails->landingrate < $settings->landing_rate) {
              $reject_pirep = true;
              PIREPData::addComment($pirepdetails->pirepid,$adminid,"Your Pirep has been rejected because you exeeded maximum landing rate of" .$settings->landing_rate) ;
          }

          // check the addition autoaccept criteria
          if (!empty($criteria)) {
            foreach($criteria as $cvariable) {
                //echo "<p>check criteria ". $cvariable->criteria_variable . " </p>";

                // search piprep log for found criteria
                $sql = "SELECT * FROM ".TABLE_PREFIX."pireps WHERE pirepid='$id' AND log LIKE '%$cvariable->criteria_variable%'";
                //echo "<p>sql " . $sql . "</p>";
                $match_result = DB::get_row($sql);

                // found criteria in pirep log, add comment to pirep
                if (!empty($match_result)) {
                  //echo "<p>reject pirep " .$cvariable->criteria_custom_message . "</p>";
                  $reject_pirep = true;
                  //echo "<p>add pipep comment</p>";
                  PIREPData::addComment($match_result->pirepid, $adminid, "Your Pirep has been rejected because you " .$cvariable->criteria_custom_message) ;

                }
            }
          }

          if ($reject_pirep == true) {
            // do not autoreject, inform the admin only
            //self::reject_pirep_post($id);
          } else {
            //echo "<p> accept the pirep</p>";
            self::approve_pirep_post($id);
          }

          // send email to admin
          if ($settings->sendmail_to_admin == '1' && $reject_pirep == true) {

            $sub = "PIREP {$pirepdetails->pirepid} by {$pilotid} ({$pirepdetails->depicao} - {$pirepdetails->arricao}) has been rejected ";
            $message="PIREP {$pirepdetails->pirepid} has been submitted by {$pilotid} {$pirepdetails->firstname} {$pirepdetails->lastname } and has been rejected, please take a look into the pirep comments.\n\n -- your autoaccept plugin -- \n\n" ;

            $email = Config::Get('EMAIL_REJECTED_PIREP');
            if(empty($email)) {
                $email = ADMIN_EMAIL;
            }

            //echo "<p>send eamil : " . $message . "</p>";
            Util::SendEmail("florian@goeldenitz.org", $sub, $message);

          }

        }

}
