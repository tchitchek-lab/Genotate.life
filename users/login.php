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
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
ini_set("allow_url_fopen", 1);
if(isset($_SESSION)){session_destroy();}
?>
<?php 
require_once '../users/init.php';
include '../header.php';
include '../users/includes/initialize_db.php';
include '../navigation.php';
include '../users/includes/page_frame.php';
if($settings->twofa == 1){
  $google2fa = new PragmaRX\Google2FA\Google2FA();
}
?>
<?php
if(ipCheckBan()){Redirect::to($us_url_root.'usersc/scripts/banned.php');die();}
$settingsQ = $db->query("SELECT * FROM settings");
$settings = $settingsQ->first();
$error_message = '';
if (@$_REQUEST['err']) $error_message = $_REQUEST['err']; // allow redirects to display a message
$reCaptchaValid=FALSE;
if($user->isLoggedIn()) Redirect::to($us_url_root.'index.php');

if (Input::exists()) {
  $token = Input::get('csrf');
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }
  //Check to see if recaptcha is enabled
  if($settings->recaptcha == 1){
    require_once $abs_us_root.$us_url_root.'users/includes/recaptcha.config.php';

    //reCAPTCHA 2.0 check
    $response = null;

    // check secret key
    $reCaptcha = new ReCaptcha($settings->recap_private);

    // if submitted check response
    if ($_POST["g-recaptcha-response"]) {
      $response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$_POST["g-recaptcha-response"]);
    }
    if ($response != null && $response->success) {
      $reCaptchaValid=TRUE;

    }else{
      $reCaptchaValid=FALSE;
      $error_message .= 'Please check the reCaptcha.';
    }
  }else{
    $reCaptchaValid=TRUE;
  }

  if($reCaptchaValid || $settings->recaptcha == 0){ //if recaptcha valid or recaptcha disabled

    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'username' => array('display' => 'Username','required' => true),
      'password' => array('display' => 'Password', 'required' => true)));

      if ($validation->passed()) {
        //Log user in
        $remember = (Input::get('remember') === 'on') ? true : false;
        $user = new User();
        $login = $user->loginEmail(Input::get('username'), trim(Input::get('password')), $remember);
        if ($login) {
          $dest = sanitizedDest('dest');
          $twoQ = $db->query("select twoKey from users where id = ? and twoEnabled = 1",[$user->data()->id]);
          if($twoQ->count()>0) {
            $_SESSION['twofa']=1;
            if(!empty($dest)) {
              $page=encodeURIComponent(Input::get('redirect'));
              logger($user->data()->id,"Two FA","Two FA being requested.");
              Redirect::to($us_url_root.'users/twofa.php?dest='.$dest.'&redirect='.$page); }
              else Redirect::To($us_url_root.'users/twofa.php');
            } else {
              # if user was attempting to get to a page before login, go there
              $_SESSION['last_confirm']=date("Y-m-d H:i:s");
              Redirect::to($us_url_root.'index.php');
            }
          } else {
            $error_message .= '<strong>Login failed</strong>. Please check your username and password and try again.';
          }
        } else{
          $error_message .= '<ul>';
          foreach ($validation->errors() as $error) {
            $error_message .= '<li>' . $error[0] . '</li>';
          }
          $error_message .= '</ul>';
        }
      }
    }
    if (empty($dest = sanitizedDest('dest'))) {
      $dest = '';
    }

    ?>


            <?php if(!$error_message=='') {?><div class="alert alert-danger" style="width:100%"><?=$error_message;?></div><?php } ?>
            <?php

            if($settings->glogin==1 && !$user->isLoggedIn()){
              require_once $abs_us_root.$us_url_root.'users/includes/google_oauth_login.php';
            }
            if($settings->fblogin==1 && !$user->isLoggedIn()){
              require_once $abs_us_root.$us_url_root.'users/includes/facebook_oauth.php';
            }
            ?>
              
			  
			<div class="div-border-title">
			Please provide your login information
			<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['login_interface']; ?>">
			<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
			</div>

			<div class="div-border" style='padding:5px;'>
            <form name="login" id="login-form" class="form-signin" action="login.php" method="post">
              <input type="hidden" name="dest" value="<?= $dest ?>" />
              <div class="form-group" style='margin-top:5px;margin-bottom:5px;'>
                <label for="username" >username or email</label>
                <input  class="form-control" type="text" name="username" id="username" autofocus  data-toggle="tooltip" data-placement="top"  style="width: 100%; height: 2em; text-align: left;" title="<?=$tooltip_text['username'];?>">
              </div>

              <div class="form-group" style='margin-top:5px;margin-bottom:5px;'>
                <label for="password">password</label>
                <input type="password" class="form-control"  name="password" id="password"  autocomplete="off" data-toggle="tooltip" data-placement="top"  style="width: 100%; height: 2em; text-align: left;"  title="<?php echo $tooltip_text['password'];?>">
              </div>
              <?php
              if($settings->recaptcha == 1){
                ?>
                <div class="g-recaptcha" data-sitekey="<?=$settings->recap_public; ?>" data-bind="next_button" data-callback="submitForm"></div>
              <?php } ?>

              <div style='margin:5px;width:100%;'>
                  <a style='float:right;margin:5px;' href='/users/forgot_password.php'><i class="fa fa-wrench"></i><label>Forgot password</label></a>
               
                </div>
                <input type="hidden" name="csrf" value="<?=Token::generate(); ?>">
                <input type="hidden" name="redirect" value="<?=Input::get('redirect')?>" />
                <button style="width: 100%; font-size: 1.3em;" class="btn btn-secondary active" type="submit"><i class="fa fa-sign-in"></i> <?=lang("SIGNIN_BUTTONTEXT","");?></button>

              </form>
                </div>
 

 <script>
          
		  					$(function () {
						$('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
					})
         </script>
		
        <!-- Place any per-page javascript here -->

        <?php   if($settings->recaptcha == 1){ ?>
          <script src="https://www.google.com/recaptcha/api.js" async defer></script>
          <script>
          function submitForm() {
            document.getElementById("login-form").submit();
          }
		  

        </script>
      <?php } ?>
