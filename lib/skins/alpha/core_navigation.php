
<!-- <li><a href="<?php echo url('/'); ?>">home</a></li> -->

<?php
if(!Auth::LoggedIn())
{
	// Show these if they haven't logged in yet
?>
<!--	<li><a href="<?php echo url('/login'); ?>">Login</a></li> -->
	<li><a href="<?php echo url('/registration'); ?>">Register</a></li>
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
    <li><a href="<?php echo url('/vFleetTracker');?>">View Fleet</a></li>
		<li><a href="<?php echo url('/finances');?>">View VA Finances</a></li>
	</ul>


<li><a href="#" class="icon fa-angle-down">Profile</a>
<ul>
	<li><a href="<?php echo url('/profile/editprofile'); ?>">Edit My Profile</a></li>
	<li><a href="<?php echo url('/profile/changepassword'); ?>">Change my Password</a></li>
	<li><a href="<?php echo url('/profile/badge'); ?>">View my Badge</a></li>
	<li><a href="<?php echo url('/profile/stats'); ?>">My Stats</a></li>
	<li><a href="<?php echo url('/downloads'); ?>">View Downloads</a></li>
</ul>
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
<?php if(Auth::LoggedIn() == false)
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
