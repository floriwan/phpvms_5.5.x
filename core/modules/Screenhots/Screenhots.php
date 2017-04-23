<?php
/**
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class Screenhots extends CodonModule {

    public function index() {

        if(isset($this->post->action)) {
            if($this->post->action == 'savescreenhot') {
                $this->save_screenhot($date_string = date('Ym'));
            }
        }
        
        $date_string = date('Ym');
        $date_display = date('F Y');
        
        $screenshots = $this->get_all_monthly_screenhots();
        $this->set('screenshots', $screenshots);
        
        //$this->generate_big_picture($date_string);
        
        if (file_exists(SITE_ROOT.SCREENSHOT_PATH.DIRECTORY_SEPARATOR.$date_string.'.jpg'))
            $this->set('current_screenhot', SITE_URL.SCREENSHOT_PATH.DIRECTORY_SEPARATOR.$date_string.'.jpg');
            
        $this->set('display_month', date('F Y'));
        
        $this->render("screenshots.php");
        
    }

    public function save_screenhot($month) {
        
        $target_file;
        
        // create random filename
        while (true) {
            $target_file = SITE_ROOT.SCREENSHOT_PATH.DIRECTORY_SEPARATOR.$month.DIRECTORY_SEPARATOR.uniqid(rand(), true) . ".jpg";
            if (!file_exists($target_file)) break;
        }
        
        $check_ok = true;
        
        // check upload filesize        
        if ($_FILES["image"]["size"] > SCREENSHOT_MAX_FILESIZE) {
            echo "<p>Upload image size (".round(($_FILES["image"]["size"]/1024/1024), 2)."MB) is too large. The maximum filesize is ".round((SCREENSHOT_MAX_FILESIZE/1024/1024),2)."MB</p>";
            $check_ok = false;
        }
            
        $check_img_size = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check_img_size !== false) {
            //echo "<p>upload image " . $check_img_size["mime"] . "</p>";            
        } else {
            echo "<p>You can only upload images, try again ...</p>";
            $check_ok = false;
        }
        
        // everything ok, move to upload directory
        if (check_ok) {
            if(copy($_FILES["image"]["tmp_name"], $target_file)) {
                echo "<p>upload image successful</p>";
            } else {
                echo "<p>ERROR: can not upload file</p>";
            }
        }

        // recalculate the big picture
        $this->generate_big_picture($month);
        
        // twitter new screenhot
        $message = "new screenshot generated for " . date('F Y') . ". ".SITE_URL.SCREENSHOT_PATH.DIRECTORY_SEPARATOR.$month.".jpg";
        
        if(Config::get('TWITTER_ENABLE_PUSH') == true) {
            $params = array(
                'type' => 'ACTIVITY_NEW_SCREENSHOT',
                'message' => htmlentities($message),
                'media' => SITE_URL.SCREENSHOT_PATH.DIRECTORY_SEPARATOR.$month.".jpg",
                'submitdate' => 'NOW()');
            ActivityData::pushToTwitter($params);
        }
        
    }
    
    public function generate_big_picture($month) {
    //SCREENSHOT_PB_WIDTH
        $scandir_result = array_diff(scandir(SITE_ROOT.SCREENSHOT_PATH.DIRECTORY_SEPARATOR.$month), array('..', '.'));
        $source_images = array();

        // clean up the found files, take only filenames with .jpg into account
        foreach($scandir_result as $img_name) {
            if (strlen($img_name) < 4) {
                continue;
            }
            if (substr($img_name, -4) === '.jpg') {
                $source_images[] = $img_name;
            } 
        }
        
        if (sizeof($source_images) == 0) return;
        
        $rows = ceil(sqrt(sizeof($source_images)));

        $target_image_height = round(SCREENSHOT_PB_HEIGHT / $rows);
        $target_image_width = round(SCREENSHOT_PB_WIDTH / $rows);

        $target_image = imagecreatetruecolor(SCREENSHOT_PB_WIDTH, SCREENSHOT_PB_HEIGHT);

        $img_count = 0;
        for ($i=0; $i<$rows; $i++) {
            for ($j=0; $j<$rows; $j++) {

                // no more source images
                if ($img_count >= sizeof($source_images)) {
                    continue;
                }

                $source_image_filename = SITE_ROOT.SCREENSHOT_PATH.DIRECTORY_SEPARATOR.$month.DIRECTORY_SEPARATOR.$source_images[$img_count];
                $source_image_rs = imagecreatefromjpeg($source_image_filename);

                // scale and keep aspect ration, check image height later
                $icon = imagescale($source_image_rs, $target_image_width, -1);
                $correct_width=0;
                
                // check image height and calculate correction value
                if (imagesy($icon) < $target_image_height) {
                    
                    $old_x = imagesx($icon);
                    $old_y = imagesy($icon);
                    
                    $img_size = getimagesize($source_image_filename);
                    $ratio = $img_size[1]/$target_image_height;
                    
                    $icon = imagescale($source_image_rs, $img_size[0]/$ratio, $img_size[1]/$ratio);
                    $correct_width = (imagesx($icon)- $old_x);

                }
                
                ImageCopy($target_image,
                    $icon,
                    $j * $target_image_width,
                    $i * $target_image_height,
                    (0 + ($correct_width/2)),
                    0,
                    (imagesx($icon) - ($correct_width/2)),
                    imagesy($icon));
                    
                
                $img_count++;
        
            }
        }
 
        $big_picture_name = SITE_ROOT.SCREENSHOT_PATH.DIRECTORY_SEPARATOR.$month.".jpg";
        imagejpeg($target_image, $big_picture_name);
        //echo "<p>new <a href='".$big_picture_name."'>image is ready</a></p>";
    }

    
    public function get_all_monthly_screenhots() {
    
        // the current month
        $date_string = date('Ym');
        
        //echo "<p>" . SITE_ROOT.SCREENSHOT_PATH . "</p>";
        
        if (!is_dir(SITE_ROOT.SCREENSHOT_PATH . DIRECTORY_SEPARATOR . $date_string)) {
            echo "<p>no directory for current month found</p>";
            
            // we create a new directory for a new month, first delete the old upload directory
            $scn_result = array_diff(scandir(SITE_ROOT.SCREENSHOT_PATH) , array('..', '.'));
            
            foreach($scn_result as $filename) {
                //echo "<p>check " . $filename . "</p>";
                if (is_dir(SITE_ROOT.SCREENSHOT_PATH . DIRECTORY_SEPARATOR . $filename)) {
                    echo "<p>remove old upload directory " . SITE_ROOT.SCREENSHOT_PATH . DIRECTORY_SEPARATOR.$filename . "</p>";
                    system("rm -rf " . SITE_ROOT.SCREENSHOT_PATH . DIRECTORY_SEPARATOR.$filename );
                }
            }
            
            if (!mkdir(SITE_ROOT.SCREENSHOT_PATH . DIRECTORY_SEPARATOR . $date_string)) {
                echo "<p>ERROR can not create new screenhot directory '" . SITE_ROOT.SCREENSHOT_PATH . DIRECTORY_SEPARATOR . $date_string . "'</p>";
            }
            
            
            
        }
        
        //check for past generated big pictures
        $screenhot_dir = fileurl(SITE_ROOT.SCREENSHOT_PATH);
        $src_dir = array_diff(scandir(SITE_ROOT.SCREENSHOT_PATH), array('..', '.'));
        
        $all_screenshots = array();
        foreach($src_dir as $filename) {
            if (substr($filename, -4) === '.jpg') {
                $ex_date = substr($filename, 0, strlen($filename)-4);
                $date = date_create_from_format('Ym', $ex_date);
                
                $all_screenshots[date_format($date, 'F Y')] = $filename;
            }
        }
        
        return $all_screenshots;
    }

}
