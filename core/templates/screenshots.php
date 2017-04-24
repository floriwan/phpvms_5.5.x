<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<h3>FlyCaribbean Monthly Screenshot</h3>

<?php 
    if ($screenshots) { 
        echo "<ul class='actions'>";
        foreach ($screenshots as $date => $image) {
            echo "<li><a href='".SITE_URL.SCREENSHOT_PATH.DIRECTORY_SEPARATOR.$image."' class='button special'>$date</a></li>";
        }
        echo "</ul>";
    } 
?>

<?php 
    if($current_screenhot)
        echo "<img src='".$current_screenhot."'>";
    else
        echo "<p>No images exists for " . $display_month . ". Please upload a first image.</p>";
?>

<hr />

<?php if (Auth::LoggedIn() == true) { ?>

<p>Add new image for <?php echo $display_month ?><br>
(Max. upload file size is <?php echo round((SCREENSHOT_MAX_FILESIZE/1024/1024),2) ?> MB)</p>

<form method="post" enctype="multipart/form-data">
    <div class="row uniform 50%">
        <div class="6u 12u(mobilep)">
            <input name="image" type="file" accept=".jpg, .jpeg">
        </div>
        <div class="6u 12u(mobilep)">
            <input type="hidden" name="action" value="savescreenhot" />
            <input type="submit" value="Upload" class="fit" />
        </div>
    </div>

</form>

<?php } ?>
