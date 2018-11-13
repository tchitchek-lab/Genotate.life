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
include '../users/includes/page_frame.php'; ?>
<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
if(ipCheckBan()){Redirect::to($us_url_root.'usersc/scripts/banned.php');die();}
$error_message = null;
$errors = array();
$email_sent=FALSE;

$token = Input::get('csrf');
if(Input::exists()){
    if(!Token::check($token)){
        include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
    }
}

if (Input::get('forgotten_password')) {
    $email = Input::get('email');
    $fuser = new User($email);
    //validate the form
    $validate = new Validate();
    $validation = $validate->check($_POST,array('email' => array('display' => 'Email','valid_email' => true,'required' => true,),));

    if($validation->passed()){
        if($fuser->exists()){
          $vericode=randomstring(15);
          $vericode_expiry=date("Y-m-d H:i:s",strtotime("+$settings->reset_vericode_expiry minutes",strtotime(date("Y-m-d H:i:s"))));
          $db->update('users',$fuser->data()->id,['vericode' => $vericode,'vericode_expiry' => $vericode_expiry]);
            //send the email
            $options = array(
              'fname' => $fuser->data()->fname,
              'email' => rawurlencode($email),
              'vericode' => $vericode,
              'reset_vericode_expiry' => $settings->reset_vericode_expiry
            );
            $subject = 'Password Reset';
            $encoded_email=rawurlencode($email);
            $body =  email_body('_email_template_forgot_password.php',$options);
            $email_sent=email($email,$subject,$body);
            logger($fuser->data()->id,"User","Requested password reset.");
            if(!$email_sent){
                $errors[] = 'Email NOT sent due to error. Please contact site administrator.';
            }
        }else{
            $errors[] = 'That email does not exist in our database';
        }
    }else{
        //display the errors
        $errors = $validation->errors();
    }
}
?>
<?php
if ($user->isLoggedIn()) $user->logout();
?>

<?php if(!$errors=='') {?><div style="width: 100%" lass="alert alert-danger"><?=display_errors($errors);?></div><?php } ?>
<form action="forgot_password.php" method="post" class="form ">

<div class="div-border-title">
Reset your password
<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['reset_password']; ?>">

<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>

<div class="div-border" style='padding:5px;'>
<?php

if($email_sent){
?>
<p>Your password reset link has been sent to your email address.</p>
<p>Click the link in the email to Reset your password. Be sure to check your spam folder if the email isn't in your inbox.</p>
<p>Reset links are only valid for <?=$settings->reset_vericode_expiry?> minutes.</p>
<?php
}else{
?>
        <ol>
	<li>enter your email address and click Reset</li>
	<li>check your email and click the link that is sent to you.</li>
	<li>follow the instructions</li>
</ol>

	
	<div class="form-group">
		<label for="email">email</label>
		<p>
		<input type="text" name="email" class="form-control" autofocus>
	</div>
	<p>

	<input type="hidden" name="csrf" value="<?=Token::generate();?>">
	<input type='hidden' name="forgotten_password" value="Reset" class="btn btn-primary">
  <button style="width: 100%; font-size: 1.3em;" class="btn btn-secondary active" type="submit">Reset</button>
</form>
<?php
}
?>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- footer -->

