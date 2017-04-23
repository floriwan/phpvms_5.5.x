
<!-- <li><a href="<?php echo url('/'); ?>">home</a></li> -->

<?php
if(!Auth::LoggedIn())
{
	// Show these if they haven't logged in yet
  $mobile_dev = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up.browser|up.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);

  // login popup is not working on mobile devices
  // show the default login page
  if ($mobile_dev) { ?>
    <li><a href="<?php echo url('/login'); ?>">Login</a></li>
  <?php } ?>

	<!--<li><a href="<?php echo url('/ruleregs'); ?>">Register</a></li>-->

<?php
}
else
{
	// Show these items only if they are logged in
?>

<?php
if(Auth::LoggedIn() && (PilotGroups::group_has_perm(Auth::$usergroups, ACCESS_ADMIN)))
{
	echo '<li><a class="icon fa-cog" href="'.fileurl('/admin').'">Admin Center</a></li>';
}
?>

	<li><a class="icon fa-shopping-bag" href="<?php echo url('/profile'); ?>">Pilot Center</a></li>

<?php
}
?>

  <li><a class="icon fa-newspaper-o" href="<?php echo url('/news');?>">News</a></li>

  <li><a href="#" class="icon fa-desktop">Company <i class="icon fa-angle-down"></i></a>
    <ul>
      <li><a href="<?php echo url('/vStaff');?>">Our Staff</a></li>
      <li><a href="<?php echo url('/vFleetTracker');?>">Our Fleet</a></li>
      <li><a href="<?php echo url('/Pilots/getAllPilots');?>">Our Pilots</a></li>
      <li><a href="<?php echo url('/events');?>">Our Events</a></li>
      <li><a href="<?php echo url('/Ranks');?>">Pilot Ratings</a></li>
      <?php if(Auth::LoggedIn()) { ?>
        <li><a href="<?php echo url('/statistic');?>">Airline Statistics</a></li>
      <?php } ?>
      <li><a href="<?php echo url('/ruleregs');?>">Rules & Regulations</a></li>
    </ul>
  </li>
<?php
if(Auth::LoggedIn())
{ ?>

	<li><a href="#" class="icon fa-plane">Flight Operations <i class="icon fa-angle-down"></i></a>
	<ul>
    <li><a href="<?php echo url('/schedules/view');?>">Flight Schedules</a></li>
    <li><a href="<?php echo url('/Tours');?>">View active Tours</a></li>
    <li><a href="<?php echo url('/schedules/bids');?>">My Flight Bids</a></li>
		<li><a href="<?php echo url('/pireps/mine');?>">View My PIREPs</a></li>
    <li><a href="<?php echo url('/pireps/filepirep');?>">File a Pilot Report</a></li>
		<li><a href="<?php echo url('/pireps/routesmap');?>">A Map Of All My Flights</a></li>
		<li><a href="<?php echo url('/finances');?>">VA Finances</a></li>
    <li><a href="<?php echo url('/Airline');?>">Airline Codes</a></li>
	</ul>
  </li>

<li><a href="#" class="icon fa-user">Profile <i class="icon fa-angle-down"></i></a>
<ul>
  <li><a href="<?php echo url('/profile/profile_detail'); ?>">View My Profile</a></li>
  <li><a href="<?php echo url('/Tours/pilotTours'); ?>">View My Tours</a></li>
	<!--<li><a href="<?php echo url('/profile/editprofile'); ?>">Edit My Profile</a></li>-->
	<li><a href="<?php echo url('/profile/changepassword'); ?>">Change My Password</a></li>
	<li><a href="<?php echo url('/profile/stats'); ?>">View My Stats</a></li>
  <li><a href="<?php echo url('/downloads/dl/7') ?>">smartCARS Tutorial</a></li>
	<li><a href="<?php echo url('/downloads'); ?>">View Downloads</a></li>
</ul>
</li>

<?php
}
?>

<li><a href="#" class="icon fa-group">Community <i class="icon fa-angle-down"></i></a>
  <ul>
    <li><a href="<?php echo url('/acars') ?>">Live Map</a></li>
    <li><a href="http://www.flycaribbeanva.com/smf/index.php?action=login">Forum</a></li>
    <li><a href="JavaScript:ts_popup('http://www.flycaribbeanva.com/teamspeak.html');">Teamspeak</a></li>
    <?php if(Auth::LoggedIn()) { ?>
    <li><a href="<?php echo url('/Screenhots') ?>">Screenhots</a></li>
    <?php } ?>
  </ul>
</li>

<?php echo $MODULE_NAV_INC;?>

<!-- show log in or log out button -->
<?php if(Auth::LoggedIn() == false && !$mobile_dev)
{ ?>


<li> <a href="#" id="loginButton"><span><i class="icon fa-sign-in"></i>
Login</span><em></em></a>

   <div id="loginBox"> <form id="loginForm" name="loginform" action="<?php echo
   SITE_URL?>/index.php/login" method="post"> <center> <fieldset id="body"
   action="<?php echo SITE_URL?>/index.php/login" method="post" >

               <fieldset> <label for="email">Pilot ID <input class="loginfield"
               type="text" name="email" placeholder="pilot id" value=""
               onClick="this.value=''" /> </label> </fieldset>

               <fieldset> <label for="password">Password <input class="loginbox"
               type="password" name="password" placeholder="password"
               value="password"  onClick="this.value=''"/> </label> </fieldset>

               <input type="hidden" name="remember" value="on" />
							 <input type="hidden" name="redir" value="index.php/profile" />
							 <input type="hidden" name="action" value="login" />
               <input type="submit" id="login" type="submit" name="submit" value="login" />
               </fieldset>


               <p><a href="<?php echo url('Login/forgotpassword'); ?>">lost my password</a></p>

         </center> </form>

   </div>
</li>
<?php
} else { ?>
   <li><a href="<?php echo url('/logout'); ?>"><i class="icon fa-sign-out"> </i>Logout</a></li>
<?php } ?>

<!--
<?php
if(Auth::LoggedIn())
{
	if(PilotGroups::group_has_perm(Auth::$usergroups, ACCESS_ADMIN))
	{
		echo '<li><a href="'.fileurl('/admin').'">Admin Center</a></li>';
	}
?>


<li><a href="<?php echo url('/logout'); ?>">Log Out</a></li>
<?php
}
?>-->
