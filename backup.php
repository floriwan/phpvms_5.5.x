<?php
   
    /*    This is the maintenance cron file, which can run nightly. 
    You should either point to this file directly in your web-host's control panel
    Or add an entry into the crontab file. I recommend running this maybe 2-3am, 
    */
    define('ADMIN_PANEL', true);
    include dirname(dirname(__FILE__)).'/core/codon.config.php';
    Auth::$userinfo->pilotid = 0;

    error_reporting(E_ALL);
    ini_set('display_errors', 'on');

    set_time_limit(0);
    ini_set('memory_limit', '-1');

   // In case your PHPvms installation is in a subfolder add ."/yourinstallationfolder/"   at the end of $_SERVER["DOCUMENT_ROOT"];
    $Path = $_SERVER["DOCUMENT_ROOT"];

    $server_name   = DBASE_SERVER ;
    $username      = DBASE_USER;
    $password      = DBASE_PASS;
    $database_name = DBASE_NAME;
    $date_string   = date("Ymd");
    
    
//    Here put your email addres where the backup will be send
    $email = "YourEmail" ;


    $cmd = "mysqldump --hex-blob --routines --skip-lock-tables --log-error=mysqldump_error.log -h {$server_name} -u {$username} -p{$password} {$database_name} > " . $Path . "{$date_string}_{$database_name}.sql";
    $arr_out = array();
    unset($return);

    exec($cmd, $arr_out, $return);

    if($return !== 0) {
        echo "mysqldump for {$server_name} : {$database_name} failed with a return code of {$return}\n\n";
        echo "Error message was:\n";
        $file = escapeshellarg("mysqldump_error.log");
        $message = `tail -n 1 $file`;
        echo "- $message\n\n";
    }
    $files_to_zip = array(
        $Path.$date_string."_".$database_name.".sql" );

    //if true, good; if false, zip creation failed
    $result = create_zip($files_to_zip,'PhpvmsBackup.zip');

    $file=$Path."/admin/PhpvmsBackup.zip" ;

    SendEmail($email, "MYSQL Backup", "Here is todays backup", $file,"Website Server");

    echo "Backup Completed" ;

    function showpath()
    {
        echo  $_SERVER["DOCUMENT_ROOT"]  ;
    }

    function create_zip($files = array(),$destination = '',$overwrite = false) {

        //if the zip file already exists and overwrite is false, return false
        if(file_exists($destination) && !$overwrite) { return false; }
        //vars
        $valid_files = array();
        //if files were passed in...
        if(is_array($files)) {
            //cycle through each file
            foreach($files as $file) {
                //make sure the file exists
                if(file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if(count($valid_files)) {
            //create the archive
            $zip = new ZipArchive();
            if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach($valid_files as $file) {
                $zip->addFile($file,$file);
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        }
        else
        {
            return false;
        }
    }

    function SendEmail($email, $subject, $message, $path,$fromname='', $fromemail='')
    {
        ob_start();
        # PHPMailer
        include_once(SITE_ROOT.'/core/lib/phpmailer/class.phpmailer.php');
        $mail = new PHPMailer();

        if($fromemail == '') {
            $fromemail = Config::Get('EMAIL_FROM_ADDRESS');

            if($fromemail == '') {
                $fromemail = ADMIN_EMAIL;
            }
        }

        if($fromname == '') {

            $fromname = Config::Get('EMAIL_FROM_NAME');

            if($fromname == '') {
                $fromname = SITE_NAME;
            }
        }

        $return_path_email = Config::Get('EMAIL_RETURN_PATH');
        if($return_path_email == '') {
            $return_path_email = $fromemail;
        }

        $mail->From     = $fromemail;
        $mail->FromName = $fromname;

        // Fix thanks to jm (Jean-Michel)
        $mail->Sender = $return_path_email;

        $mail->Mailer = 'mail';
        $mail->CharSet = 'UTF-8'; #always use UTF-8
        $mail->IsHTML(true);

        if(Config::Get('EMAIL_USE_SMTP') == true) {

            $mail->IsSMTP();

            $mail->Host = Config::Get('EMAIL_SMTP_SERVERS');
            $mail->Port = Config::Get('EMAIL_SMTP_PORT');

            if(Config::Get('EMAIL_SMTP_USE_AUTH') == true) {
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = Config::get('EMAIL_SMTP_SECURE');
                $mail->Username = Config::Get('EMAIL_SMTP_USER');
                $mail->Password = Config::Get('EMAIL_SMTP_PASS');
            }
        }

        $mail->SetFrom($fromemail, $fromname);
        $mail->AddReplyTo($fromemail, $fromname);

        $message = "<html><head></head><body>{$message}</body></html>";
        //$message = nl2br($message);
        $alt = strip_tags($message);

        //allowing function to send to an array of email addresses, not just one
        if(is_array($email))    {
            foreach($email as $emailrec)    {
                $mail->AddAddress($emailrec);
            }
        }
        else    {
            $mail->AddAddress($email);
        }
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $alt;
        $mail->addAttachment($path);
        $mail->Send();
        ob_end_clean();
    }


