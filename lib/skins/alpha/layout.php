<!DOCTYPE HTML>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
  <!-- <meta http-equiv="X-UA-Compatible" content="IE=7"> -->
  <title><?php echo $page_title; ?></title>

  <?php echo $page_htmlhead; ?>

  <!-- Scripts for the layout template -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!--[if lte IE 8]><script src="http://www.flycaribbeanva.com/phpvms/lib/skins/alpha/assets/js/ie/html5shiv.js"></script><![endif]-->
  <link rel="stylesheet" href="<?php echo fileurl('lib/skins/alpha/assets/css/main.css')?>" />
  <!--[if lte IE 8]><link rel="stylesheet" href="http://www.flycaribbeanva.com/phpvms/lib/skins/alpha/assets/css/ie8.css" /><![endif]-->
  <link rel="stylesheet" href="<?php echo fileurl('lib/skins/alpha/assets/css/animation.css')?>" />

  <!--[if lte IE 8]><script src="http://www.flycaribbeanva.com/phpvms/lib/skins/alpha/assets/js/ie/html5shiv.js"></script><![endif]-->
  <link rel="stylesheet" href="http://www.flycaribbeanva.com/phpvms/lib/skins/alpha/assets/css/main.css" />
  <!--[if lte IE 8]><link rel="stylesheet" href="http://www.flycaribbeanva.com/phpvms/lib/skins/alpha/assets/css/ie8.css" /><![endif]-->
  <link rel="stylesheet" href="http://www.flycaribbeanva.com/phpvms/lib/skins/alpha/assets/css/animation.css" />

  <!---<script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/jquery.min.js"></script>-->
  <script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/jquery.dropotron.min.js"></script>
  <script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/jquery.scrollgress.min.js"></script>
  <script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/skel.min.js"></script>
  <script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/util.js"></script>
  <!--[if lte IE 8]><script src="http://www.flycaribbeanva.com/phpvms/lib/skins/alpha/assets/js/ie/respond.min.js"></script><![endif]-->
  <script src="<?php echo SITE_URL?>/lib/skins/alpha/assets/js/main.js"></script>

  <!-- simbrief include -->
  <script type="text/javascript" src="<?php echo fileurl('lib/js/simbrief.apiv1.js');?>"></script>

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
      <?php if(Auth::LoggedIn() == false) { ?>
        <h1><a href="<?php echo url('/'); ?>"><img src="<?php echo SITE_URL?>/lib/images/flycaribbean_icon_small.png" alt="FCB" /> <i class="icon fa-home"></i> <?php echo SITE_NAME; ?></a></h1>
      <?php } else { ?>
        <h1><a href="<?php echo url('/'); ?>"><img src="<?php echo SITE_URL?>/lib/images/flycaribbean_icon_small.png" alt="FCB" /> <i class="icon fa-home"></i> <?php echo SITE_NAME; ?></a></h1>
      <?php } ?>

      <!-- <h1><a href="<?php echo url('/'); ?>"><img src="<?php echo SITE_URL?>/lib/skins/alpha/images/flycaribbean_icon.png"> FlyCaribbean</a></h1> -->
      <nav id="nav">
        <ul>
          <?php Template::Show('core_navigation.tpl'); ?>
        </ul>
      </nav>
    </header>

    <!-- banner -->

    <section id="banner">
      <?php if(Auth::LoggedIn() == false) { ?>
        <img src="<?php echo SITE_URL?>/lib/images/flycaribbean.png" alt="flycaribbean logo" />
        <p>Caribbeans finest virtual airline</p>

        <ul class="actions">
						<li>
							<a href="<?php echo url('/ruleregs'); ?>" class="button special">
							Sign Up
							<i class="fa fa-sign-in" aria-hidden="true"></i></a>
						</li>
						<li><a href="<?php echo url('contact'); ?>" class="button">Contact
            <i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>
				</ul>

      <?php } ?>
    </section>


    <!-- main -->
    <section id="main" class="container">

      <!-- user not logged in, give some airline information -->
      <?php if(Auth::LoggedIn() == false)
      {

        $server_url = $_SERVER['PHP_SELF'];
        $regex = "/^.+index.php(\/|)$/";
        //$regex = "/(^.+registration$|^.+\/acars$|^.+\/viewreport\/.+|^.+profile\/view\/.+)/";
        $result = preg_match($regex, $server_url);

        if ($result != 0) { ?>

          <a name="who_we_are"></a>

          <div class="box">
          <header><h2>Who we are</h2></header>
          <span class="image featured"><img src="<?php echo SITE_URL?>/lib/images/flycaribbean_plane2.jpg" alt="" /></span>


          <p>FlyCaribbeanVA is a Virtual Alliance by and for
          virtual pilots who like to fly in the Caribbean area.
          It is founded in 2016 and become an
          <a target="_blank" href="https://www.ivao.aero//db/airline/airline.asp?Id=19790">official IVAO airline</a>
           in the same year.
          The idea is to offer the
          possibility to simulate real world flights flown in the
          Caribbean, from small private aircrafts to large passenger
          and cargo jets. </p>

          <p>We have two hubs: <a target="_blank" href="https://skyvector.com/airport/TNCM/Princess-Juliana-International-Airport">St. Maarten (TNCM)</a>
             and <a target="_blank" href="https://skyvector.com/airport/TNCC/Curacao-Airport">Curacao (TNCC)</a>.</p>

  				</div>

          <div class="box">
          <header><h2>What we offer</h2></header>
          <span class="image featured"><img src="<?php echo SITE_URL?>/lib/images/code_share.jpg" alt="" /></span>
          <p>We offer our pilots the possibility to fly offline and
				  online (<a href="https://www.ivao.aero/">IVAO</a>,
					<a href="https://www.vatsim.net/">VATSIM</a>, or any other
					network).</p>

          <p>Flighttracking will be done primarily by our own
					smartCARS, but we do allow XAcars as well.</p>

					<p>Too fly as real as it gets we offer flights from many
					realworld airlines that are operating in the Caribbean
					(LIAT, InselAir, Winair, Seaborne and many more) and
					intercontinental flights to/from Europe, North - and South
					America (KLM, Delta, British Airways, etc)  with their
					appropriate callsigns.</p>

					<p>We also allow our pilots to create their own flights, using
					our FCB-callsign. We have a large fleet with realworld
					aircrafts, from small props to big jets, from helicopters to
					bussiness jets.</p>

          <p>All pilots are welcome to use our Team Speak 3 server which
            runs 24 / 7.</p>
            
            
          <ul class="icons">
            <!--<li><a target="_blank" href="http://www.ivao.aero"><img src="<?php echo SITE_URL?>/lib/images/ivao_logo.png" alt="" /></a></li>-->
            <li><a target="_blank" href="http://www.ivao.aero"><img src="<?php echo SITE_URL?>/lib/images/ivao_certified_airline_logo.png" alt="" /></a></li>
            <li><a target="_blank" href="http://an.ivao.aero/"><img src="<?php echo SITE_URL?>/lib/images/ivao_an_logo.png" alt="" /></a></li>
            <li><a target="_blank" href="http://www.vatsim.net"><img src="<?php echo SITE_URL?>/lib/images/vatsim_logo.png" alt="" /></a></li>
            <li><a target="_blank"  href="http://www.simbrief.com/"><img src="<?php echo SITE_URL?>/lib/images/simbrief_logo.png" alt="" /></li>
          </ul>

        </div>

        <a name="airline_news"></a>
          <section class="box feature">
            <!--<h2>Airline News</h2>-->
            <?php MainController::Run('News', 'ShowNewsPreview', 5); ?>
          </section>

          <section class="box special features">'
            <?php echo $page_content; ?>
          </section>

        <div class="box">
        <header><h2>Why choose FlyCaribbeanVA</h2></header>
        <span class="image featured"><img src="<?php echo SITE_URL?>/lib/images/flycaribbean_palm.jpg" alt="" /></span>
        <p>The Caribbean are one the most beautifull places in the world.
          Wether you like to do some island hoping and try your skills on the
          approaches of St. Barths and Saba, or fly big jets for a nice approach
          into St. Maarten, FlyCaribbeanVA can make this happen.</p>

        <p>We have an active and friendly community, new pilots are very welcome.</p>

        </div>

        <?php
        } else {
          echo '<section class="box feature">';
          echo $page_content;
          echo '</section>';
        } ?>

      <?php
      } else {

        /* display page content if logged in */

        /* check the url and add the special feature box for
           pilot profile and homepage */
        $regex = "/(.+index\.php\/*$|.+\/statistic$|.+\/profile_detail$|.+\/profile$)/";
        $server_url = $_SERVER['PHP_SELF'];
        $result = preg_match($regex, $server_url);

        if ($result == 0) {
            /* special layout for all the tour pages */
            $result = preg_match("/.+Tours.*$/", $server_url);
            if ($result == 0) {
              echo '<section class="box feature">';
              echo $page_content;
              echo '</section>';
            } else {
              echo $page_content;
            }
        } else {

          $server_url = $_SERVER['PHP_SELF'];
          $regex = "/^.+index.php(\/|)$/";
          $result = preg_match($regex, $server_url);

          if ($result) {
            echo '<section class="box feature">';
            /*echo '<h3>Airline News</h3>';*/
            MainController::Run('News', 'ShowNewsPreview', 5);
            echo '</section>';

          }

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
        <li><a href="<?php echo url('/ruleregs'); ?>" class="button">APPLY NOW &nbsp;<i class="icon fa-sign-in"></i></a></li>
      </ul>

    </section>
    <?php } ?>

    <!-- footer -->
    <footer id="footer">
      <ul class="icons">
        <li><a target="_blank" href="http://www.ivao.aero"><img border="0" height="75" width="75" src="<?php echo SITE_URL?>/lib/images/ivao_certified_airline_logo.png" alt="" /></a></li>
        <li><a target="_blank" href="http://an.ivao.aero/"><img border="0" height="75" width="100" src="http://an.ivao.aero/public/images/an.svg"></a></li>
        <li><a target="_blank" href="https://www.ivao.aero//db/airline/airline.asp?Id=19790"><img border="0" height="75" width="300" src="http://status.ivao.aero/CVA/19790.png"></a></li>
        <li><a target="_blank" href="http://openaip.net/"><img src="<?php echo SITE_URL?>/lib/images/openAIP_logo.png" alt="openAIP"></a></li>
      </ul>
      
      <ul class="icons">
        <li><a href="https://twitter.com/flycaribbeanva" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
        <li><a href="https://www.facebook.com/flycaribbeanVirtual/" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
        <li><a href="https://www.youtube.com/channel/UCFzd-kBC5SADPMBijNZeP9Q" class="icon fa-youtube"><span class="label">Youtube</span></a></li>
        <!--<li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>-->
        <!--<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
        <li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
        <li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>-->
      </ul>

      <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="E2AKFB6DUCU8A">
        <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/nl_NL/i/scr/pixel.gif" width="1" height="1">
      </form>

      <ul class="copyright">
        <li>copyright &copy; 2007 - <?php echo date('Y') ?> - <?php echo SITE_NAME; ?></li>
        <li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
        <li><a href="http://www.phpvms.net" target="_blank">powered by phpVMS</a></li>
        <li>Images: <a href="https://unsplash.com">unsplash</a></li>
      </ul>
    </footer>

  </div>
</body>
</html>
