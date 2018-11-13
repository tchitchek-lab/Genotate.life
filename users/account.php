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
?>
<?php 
require_once '../users/init.php';
include '../header.php';
include '../users/includes/initialize_db.php';
include '../navigation.php';
include '../users/includes/page_frame.php';
?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();}?>
<?php
if(!empty($_POST['uncloak'])){
	if(isset($_SESSION['cloak_to'])){
		$to = $_SESSION['cloak_to'];
		$from = $_SESSION['cloak_from'];
		unset($_SESSION['cloak_to']);
		$_SESSION['user'] = $_SESSION['cloak_from'];
		unset($_SESSION['cloak_from']);
		logger($from,"Cloaking","uncloaked from ".$to);
		Redirect::to($us_url_root.'users/admin_users.php?err=You+are+now+you!');
		}else{
			Redirect::to($us_url_root.'users/logout.php?err=Something+went+wrong.+Please+login+again');
		}
}


//dealing with if the user is logged in
if($user->isLoggedIn() || !$user->isLoggedIn() && !checkMenu(2,$user->data()->id)){
	if (($settings->site_offline==1) && (!in_array($user->data()->id, $master_account)) && ($currentPage != 'login.php') && ($currentPage != 'maintenance.php')){
		$user->logout();
		Redirect::to($us_url_root.'users/maintenance.php');
	}
}
$grav = get_gravatar(strtolower(trim($user->data()->email)));
$get_info_id = $user->data()->id;
// $groupname = ucfirst($loggedInUser->title);
$raw = date_parse($user->data()->join_date);
$signupdate = $raw['month']."/".$raw['day']."/".$raw['year'];
$userdetails = fetchUserDetails(NULL, NULL, $get_info_id); //Fetch user details


 ?>


		<div class="div-border-title">
			Account information
			<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['login_interface']; ?>">
			<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
			</div>
<div class="div-border" style='padding:5px;'>
		<p>Welcome <?=ucfirst($user->data()->fname)." ".ucfirst($user->data()->lname)?> ( <?=echousername($user->data()->id)?> )</p>
		<p>Member Since:<?=$signupdate?></p>
		<p>Number of Logins: <?=$user->data()->logins?></p>
		<?php if($settings->session_manager==1) {?><p>Number of Active Sessions: <?=UserSessionCount()?> <sup><a class="nounderline" data-toggle="tooltip" title="Click the Manage Sessions button in the left sidebar for more information.">?</a></sup></p><?php } ?>
	
  <?php

$userid = $user->data()->id;
$rwhere = " WHERE user_id = $userid ";
$request = "SELECT count(dataset_id) as total FROM dataset $rwhere";
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
$row = mysqli_fetch_array ( $results, MYSQLI_ASSOC );
$total = $row['total'];
  ?>
<p>Number of private datasets: <?=$total?></p>

</div>


<!-- Place any per-page javascript here -->
<script type="text/javascript">
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>

