<?php
/*
UserSpice 4
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
$query = $db->query("SELECT * FROM email");
$results = $query->first();

//Value of email_act used to determine whether to display the Resend Verification link
$email_act=$results->email_act;

// Set up notifications button/modal
if ($user->isLoggedIn()) {
    if ($dayLimitQ = $db->query('SELECT notif_daylimit FROM settings', array())) $dayLimit = $dayLimitQ->results()[0]->notif_daylimit;
    else $dayLimit = 7;

    // 2nd parameter- true/false for all notifications or only current
	$notifications = new Notification($user->data()->id, false, $dayLimit);
}

?>
<!-- Navigation -->
<div class="navbar navbar-fixed-top navbar-inverse" role="navigation" style='display: contents;'>
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header ">
			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-top-menu-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse navbar-top-menu-collapse navbar-right">
					<ul class="nav navbar-nav ">

				<?php if($user->isLoggedIn()){ //anyone is logged in?>
					<li><a href="<?=$us_url_root?>users/account.php"><i class="fa fa-fw fa-user"></i> <?php echo echousername($user->data()->id);?></a></li> <!-- Common for Hamburger and Regular menus link -->
					 <!-- Hamburger menu link -->

						<li><a href="<?=$us_url_root?>users/admin.php"><i class="fa fa-fw fa-cogs"></i>Dashboard</a></li> <!-- Hamburger menu link -->
						<li><a href="<?=$us_url_root?>users/admin_users.php"><i class="glyphicon glyphicon-user"></i>User Management</a></li> <!-- Hamburger menu link -->
						<li><a href="<?=$us_url_root?>users/admin_permissions.php"><i class="glyphicon glyphicon-lock"></i>User Permissions</a></li> <!-- Hamburger menu link -->
						<li><a href="<?=$us_url_root?>users/admin_pages.php"><i class="glyphicon glyphicon-wrench"></i>System Pages</a></li> <!-- Hamburger menu link -->
						<li><a href="<?=$us_url_root?>users/admin_messages.php"><i class="glyphicon glyphicon-envelope"></i>Messages</a></li> <!-- Hamburger menu link -->
						<li><a href="<?=$us_url_root?>users/admin_logs.php"><i class="glyphicon glyphicon-search"></i>System Logs</a></li> <!-- Hamburger menu link -->
            <li><a href="<?=$us_url_root?>users/logout.php"><i class="fa fa-fw fa-sign-out"></i>Logout</a></li> <!-- regular Hamburger logout menu link -->

				<?php }else{ // no one is logged in so display default items ?>
					<li><a href="<?=$us_url_root?>users/login.php" class=""><i class="fa fa-sign-in"></i> Login</a></li>
					<li><a href="<?=$us_url_root?>users/join.php" class=""><i class="fa fa-plus-square"></i> Register</a></li>
					<li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-life-ring"></i> Help <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?=$us_url_root?>users/forgot_password.php"><i class="fa fa-wrench"></i> Forgot Password</a></li>
							<?php if ($email_act){ //Only display following menu item if activation is enabled ?>
								<li><a href="<?=$us_url_root?>users/verify_resend.php"><i class="fa fa-exclamation-triangle"></i> Resend Activation Email</a></li>
							<?php }?>
						</ul>
					</li>
				<?php } //end of conditional for menu display ?>
				</ul> <!-- End of UL for navigation link list -->
				</div> <!-- End of Div for right side navigation list -->

		<?php require_once $abs_us_root.$us_url_root.'usersc/includes/navigation.php';?>

	</div> <!-- End of Div for navigation bar -->
</div> <!-- End of Div for navigation bar styling -->
