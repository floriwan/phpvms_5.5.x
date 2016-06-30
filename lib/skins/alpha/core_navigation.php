
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

	<li><a href="<?php echo url('/ruleregs'); ?>">Register</a></li>
<?php
}
else
{
	// Show these items only if they are logged in
?>
	<li><a href="<?php echo url('/profile'); ?>">Pilot Center</a></li>

<?php
}
?>

  <li><a href="#" class="icon fa-angle-down">Company</a>
    <ul>
      <li><a href="<?php echo url('/vStaff');?>">Our Staff</a></li>
      <li><a href="<?php echo url('/vFleetTracker');?>">Our Fleet</a></li>
      <li><a href="<?php echo url('/Pilots/getAllPilots');?>">Our Pilots</a></li>
      <li><a href="<?php echo url('/Ranks');?>">Pilot Ratings</a></li>
      <li><a href="<?php echo url('/ruleregs');?>">Rules & Regulations</a></li>
    </ul>
  </li>
<?php
if(Auth::LoggedIn())
{ ?>

	<li><a href="#" class="icon fa-angle-down">Flight Operations</a>
	<ul>
		<li><a href="<?php echo url('/pireps/mine');?>">View my PIREPs</a></li>
		<li><a href="<?php echo url('/pireps/routesmap');?>">View a map of all my flights</a></li>
		<li><a href="<?php echo url('/pireps/filepirep');?>">File a Pilot Report</a></li>
		<li><a href="<?php echo url('/schedules/view');?>">View Flight Schedules</a></li>
		<li><a href="<?php echo url('/schedules/bids');?>">View my flight bids</a></li>
		<li><a href="<?php echo url('/finances');?>">View VA Finances</a></li>
	</ul>
  </li>

<li><a href="#" class="icon fa-angle-down">Profile</a>
<ul>
	<li><a href="<?php echo url('/profile/editprofile'); ?>">Edit My Profile</a></li>
	<li><a href="<?php echo url('/profile/changepassword'); ?>">Change my Password</a></li>
	<li><a href="<?php echo url('/profile/badge'); ?>">View my Badge</a></li>
	<li><a href="<?php echo url('/profile/stats'); ?>">My Stats</a></li>
	<li><a href="<?php echo url('/downloads'); ?>">View Downloads</a></li>
</ul>
</li>

<?php
}
?>



<li><a href="<?php echo url('/acars') ?>">Live Map</a></li>
<?php echo $MODULE_NAV_INC;?>

<?php
if(Auth::LoggedIn())
{
	echo '<li><a href="'.fileurl('/admin').'">Admin Center</a></li>';
}

?>

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
