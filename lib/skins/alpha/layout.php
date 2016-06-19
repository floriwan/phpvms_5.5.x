<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=7">
  <title><?php echo $page_title; ?></title>

  <?php echo $page_htmlhead; ?>

  <!-- Scripts for the layout template -->

  <!---<script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/jquery.min.js"></script>-->
  <script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/jquery.dropotron.min.js"></script>
  <script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/jquery.scrollgress.min.js"></script>
  <script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/skel.min.js"></script>
  <script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/util.js"></script>
  <!--[if lte IE 8]><script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/ie/respond.min.js"></script><![endif]-->
  <script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/main.js"></script>


  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!--[if lte IE 8]><script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/ie/html5shiv.js"></script><![endif]-->
  <link rel="stylesheet" href="<?php echo SITE_URL?>/lib/skins/alpha/assets/css/main.css" />
  <!--[if lte IE 8]><link rel="stylesheet" href="<?php echo SITE_URL?>/lib/skins/alpha/assets/css/ie8.css" /><![endif]-->

  <!-- for the login pop up window -->
  <script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/login.js"></script>
  <link href="<?php echo SITE_URL?>/lib/skins/alpha/assets/css/login.css" rel="stylesheet" media="all" />

  <!--<link rel="icon" href="<?php echo SITE_URL?>/lib/skins/alpha/images/flycaribbean_icon.ico" type="image/x-icon"/>-->

</head>

<body class="landing">

  <?php /* this must be the fist phpVMS call in the body tag */ echo $page_htmlreq; ?>

  <div id="page-wrapper">

    <!-- header -->

    <header id="header" class="alt">
      <h1><a href="<?php echo url('/'); ?>"><i class="icon fa-home"></i> <?php echo SITE_NAME; ?></a></h1>
      <!-- <h1><a href="<?php echo url('/'); ?>"><img src="<?php echo SITE_URL?>/lib/skins/alpha/images/flycaribbean_icon.png"> FlyCaribbean</a></h1> -->
      <nav id="nav">
        <ul>
          <?php Template::Show('core_navigation.tpl'); ?>
        </ul>
      </nav>
    </header>

    <!-- banner -->
    <section id="banner">
      <h2 style="font-family: 'Courgette', cursive;"><?php echo SITE_NAME; ?></h2>
      <p>The finest airline in the caribbean sea.</p>
    </section>

    <!-- main -->
    <section id="main" class="container">

      <!-- user not logged in, give some airline information -->
      <?php if(Auth::LoggedIn() == false)
      {

        $server_url = $_SERVER['PHP_SELF'];
        $regex = "/^.+index.php\/$/";
        //$regex = "/(^.+registration$|^.+\/acars$|^.+\/viewreport\/.+|^.+profile\/view\/.+)/";
        $result = preg_match($regex, $server_url);

        if ($result != 0) { ?>
          <section class="box special">
            <header class="major">
              <h2>Introducing the caribbean airline</h2>
              <p>Blandit varius ut praesent nascetur eu penatibus nisi risus faucibus nunc ornare<br />
                adipiscing nunc adipiscing. Condimentum turpis massa.</p>
            </header>
            <span class="image featured"><img src="<?php echo SITE_URL?>/lib/images/flycaribbean_plane.jpg" alt="" /></span>
          </section>

          <section class="box special">
            <header class="major">
              <h2>Ipsum dolor</h2>
              <p>Integer volutpat ante et accumsan co mmophasellus sed aliquam feugiat lorem aliquet ut enim rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.</p>
            </header>
          </section>


          <section class="box feature">
            <h2>Airline News</h2>
            <?php MainController::Run('News', 'ShowNewsFront', 5); ?>
          </section>

          <section class="box special features">'
            <?php echo $page_content; ?>
          </section>

        <?php
        } else {
          echo '<section class="box feature">';
          echo $page_content;
          echo '</section>';
        } ?>

      <?php
      } else {

        /* display page content if logged in */

        /* check the url and add the special fueature box for
           pilot profile and homepage */
        $regex = "/(.+index\.php\/*$|.+\/profile$)/";
        $server_url = $_SERVER['PHP_SELF'];
        $result = preg_match($regex, $server_url);

        if ($result == 0) {
            /*echo "false";*/
            echo '<section class="box feature">';
            echo $page_content;
            echo '</section>';
        } else {
          /*echo "true";*/
          echo '<section class="box feature">';
          echo '<h2>Airline News</h2>';
          MainController::Run('News', 'ShowNewsFront', 5);
          echo '</section>';

          echo '<section class="box special features">';
          echo $page_content;
          echo '</section>';
        }

      } ?>

    </section>

    <?php if(Auth::LoggedIn() == false)
    { ?>
    <!-- sign up box -->
    <section id="cta">
      <h2>start flying with <?php echo SITE_NAME; ?></h2>
      <ul class="actions">
        <li><a href="<?php echo url('/registration'); ?>" class="button">APPLY NOW &nbsp;<i class="icon fa-sign-in"></i></a></li>
      </ul>

    </section>
    <?php } ?>

    <!-- footer -->
    <footer id="footer">
      <ul class="icons">
        <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
        <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
        <li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
        <!--<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
        <li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
        <li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>-->
      </ul>
      <ul class="copyright">
        <li>copyright &copy; 2007 - <?php echo date('Y') ?> - <?php echo SITE_NAME; ?></li>
        <li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
        <li><a href="http://www.phpvms.net" target="_blank">powered by phpVMS</a></li>
      </ul>
    </footer>

  </div>
</body>
</html>
