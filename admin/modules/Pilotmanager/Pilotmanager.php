<?php
class Pilotmanager extends CodonModule
{
	public function NavBar()
        {
                echo '<li><a href="'.SITE_URL.'/admin/index.php/Pilotmanager">Pilot Manager</a></li>';
        }

	public function index()
	    {
			$this->set('title', 'Pilot Manager');
            $this->set('pilots', PilotData::getAllPilots());
           	$this->show('/pm/pilot_manager.php');
        }

    public static function getAllEmailTemplates() {

      $dirContent = scandir("templates/pm/");

      $email_teamplates = array();

      foreach($dirContent as $filename) {
        if (preg_match("#^email_.*\.php#", $filename)) {
          $email_templates[] = $filename;
        }
      }
      //print_r($email_templates);
      return $email_templates;
    }

        public function savepro()
         {
          if ($this->post->firstname == '' || $this->post->lastname == '')
                {
                    $this->set('message', 'The first or lastname cannot be blank!');
                    $this->render('core_error.php');
                    return;
                }

                $params = array(
                    'firstname' => $this->post->firstname,
                    'lastname' => $this->post->lastname,
                    'email' => $this->post->email,
                    'hub' => $this->post->hub,
                    'retired' => $this->post->retired,
                    'totalflights' => $this->post->totalflights,
                    'totalpay' => floatval($this->post->totalpay),
                    'transferhours' => $this->post->transferhours,
                   );

                PilotData::updateProfile($this->post->pilotid, $params);
                PilotData::SaveFields($this->post->pilotid, $_POST);

                /* Don't calculate a pilot's rank if this is set */
                if (Config::Get('RANKS_AUTOCALCULATE') == false) {
                    PilotData::changePilotRank($this->post->pilotid, $this->post->rank);
                } else {
                    RanksData::calculateUpdatePilotRank($this->post->pilotid);
                }

                StatsData::UpdateTotalHours();

                $this->set('message', 'Profile updated successfully');
                $this->render('core_success.php');
                $this->set('pilots', PilotData::getAllPilots());
				$this->render('/pm/pilot_manager.php');

                if($this->post->resend_email == 'true') {
                    $this->post->id = $this->post->pilotid;
                    $this->resendemail(false);
                }

                $pilot = PilotData::getPilotData($this->post->pilotid);
                LogData::addLog(Auth::$userinfo->pilotid, 'Updated profile for '
                                .PilotData::getPilotCode($pilot->code, $pilot->pilotid)
                                .' '.$pilot->firstname.' '.$pilot->lastname);

                return;
                
        }

	public function emails()
		{
			$this->set('title', 'Pilot Manager');
			$email = $this->post->email;
			$send = $this->post->send;
			Template::Set('send', $send);

      Template::Set('pilot', PManagerData::getpilotbyemail($email));
      Template::Set('email', $email);

      $message = Template::Get('/pm/email_'.$send.'.php', true);
      Template::Set('message', $message);

			if($send == "warning")
				{
					$pilotinfo = PManagerData::getpilotbyemail($email);
					$pilot = $pilotinfo->pilotid;

					Template::Set('subject', 'Account termination Warning!!');
					$subject = "Account termination Warning!!";
					Util::SendEmail($email, $subject, $message);
					PManagerData::warningsent($pilot, $message);

				}
			if($send == "welcome")
				{
					$pilotinfo = PManagerData::getpilotbyemail($email);
					$pilot = $pilotinfo->pilotid;

					Template::Set('subject', 'Welcome!!');
					$subject = "Welcome!!";
					Util::SendEmail($email, $subject, $message);
					PManagerData::welcomesent($pilot, $message);

				}

			if($send == "blank")
				{
					$this->set('title', 'Pilot Manager');
					$this->set('email', $email);
          $this->show('/pm/blank_email.php');
				}

        // show the email confirmation message
        if($send != "blank")
          $this->show('/pm/email_confirm.php');

		}

	public function send_blank()
		{
			$this->set('title', 'Pilot Manager');
			$email = $this->post->blank;
			$subject = $this->post->subject;
			$message = $this->post->message;
			$pilotinfo = PManagerData::getpilotbyemail($email);
			$pilot = $pilotinfo->pilotid;
			Template::Set('pilot', PManagerData::getpilotbyemail($email));
			Template::Set('subject', $subject);
			Template::Set('email', $email);
			Template::Set('message', $message);
			if($subject == '')
				{
					$this->set('title', 'Pilot Manager');
					$this->set('message', 'You must enter a subject!');
					$this->render('core_error.php');
					$this->set('email', $email);
					$this->show('/pm/blank_email.php');
					return;
				}
			if($message == '')
				{
					$this->set('title', 'Pilot Manager');
					$this->set('message', 'You must enter a message!');
					$this->render('core_error.php');
					$this->set('email', $email);
					$this->show('/pm/blank_email.php');
					return;
				}
			Util::SendEmail($email, $subject, $message);
			PManagerData::blanksent($pilot, $message);
			$this->show('/pm/email_confirm.php');
		}

	public static function deletePilot()
		{
			$pilotid = $_GET["pilotid"];
			$sql = array();


			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'acarsdata WHERE pilotid='.$pilotid;
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'bids WHERE pilotid='.$pilotid;
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'pireps WHERE pilotid='.$pilotid;
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'pilots WHERE pilotid='.$pilotid;

			# These SHOULD delete on cascade, but incase they don't
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'fieldvalues WHERE pilotid='.$pilotid;
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'groupmembers WHERE pilotid='.$pilotid;
			$sql[] = 'DELETE FROM '.TABLE_PREFIX.'pirepcomments WHERE pilotid='.$pilotid;

			foreach($sql as $query)
			{
				$res = DB::query($query);
			}
			echo '<script type="text/javascript">alert("Pilot is deleted!!");</script>';
			$url = $_SERVER['HTTP_REFERER']; // right back to the referrer page from where you came.
			echo '<meta http-equiv="refresh" content="5;URL=' . $url . '">';
		}
}
?>
