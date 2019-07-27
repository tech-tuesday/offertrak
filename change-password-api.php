<?php
# get submitted values..
$c_login_pw = isset($_REQUEST['c_login_pw']) ? $_REQUEST['c_login_pw'] : null;
$n_login_pw = (isset($_REQUEST['n_login_pw']) && validPassword($_REQUEST['n_login_pw'])) ? $_REQUEST['n_login_pw'] : null;
$v_login_pw = (isset($_REQUEST['v_login_pw']) && validPassword($_REQUEST['v_login_pw'])) ? $_REQUEST['v_login_pw'] : null;

# error handling..
$errors = array();

if ( empty($c_login_pw) ) { $errors[] = "Current Password is required"; }
if ( empty($n_login_pw) ) { $errors[] = "New Password must be 8 - 16 characters [with at least 1 lowercase; at least 1 uppercase; at least 1 number; and at least 1 special character] "; }
if ( empty($v_login_pw) ) { $errors[] = "Verification Password is required"; }
if ( $n_login_pw <> $v_login_pw ) { $errors[] = "Verification password is missing / or does not match new password"; }
if ( $n_login_pw == $c_login_pw ) { $errors[] = "New password must be different from current password"; }

# check whether we have errors..
if (count($errors)) {

  echo <<<HereDoc
  <div class="card">
  <div class="card-header bg-warning text-white">Unable to update password. Please review the following:</div>
  <div class="panel-body">
  <ol>

HereDoc;

  foreach ($errors as $error_item) {
    echo "<li>$error_item</li>";
  }
  echo <<<HereDoc
  </ol>
  </div>
  </div><br/>
HereDoc;

  include_once __DIR__ . '/forms/change-password-form.php';
  return;

} else {

  # encrypt the passwords..
  $c_login_pw = md5($c_login_pw);
  $n_login_pw = md5($n_login_pw);

  $sql =<<<HereDoc
update offertrak_users
set login_pw = '$n_login_pw',
password_modified = now()
where user_id = '$user_id'
and login_pw = '$c_login_pw'
limit 1

HereDoc;

  if (mysqli_query($dbh,$sql) && mysqli_affected_rows($dbh) > 0) {
    # password updated..

    echo <<<HereDoc
<div class="alert alert-warning alert-dismissible fade show">
Password updated successfully
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><br>
HereDoc;

    notifyUser($user_id);
    navigatorAPI($user_type_cd);
  } else {
    echo <<<HereDoc
<div class="alert alert-danger">Sorry- Unable to update password..</div>

HereDoc;
    session_unset();
    session_destroy();
    loginForm();
    return;
  }
}

function notifyUser($user_id) {
  global $dbh;
  $email_id = tsc_fetch_one("select email_id from offertrak_users where user_id=$user_id",'email_id');

  $host_ip = $_SERVER['REMOTE_ADDR'];
  $host_address = gethostbyaddr($host_ip);
  $browser_app = $_SERVER['HTTP_USER_AGENT'];

  $subject = "Password Updated - Open Trade Logistics";
  $message =<<<HereDoc
*** Alert ***
Password changed.

Your password was successfully updated on Open Trade Logistics.
If this was you no further action is necessary, otherwise please contact contact Open Trade Logistics.

Details:
IP: $host_ip
HOST: $host_address
Browser: $browser_app


Thank You.

Account Services,
Open Trade Logistics
opentradelogistics.com
HereDoc;

  require_once 'PHPMailer/Exception.php';
  require_once 'PHPMailer/PHPMailer.php';
  $mail = new PHPMailer\PHPMailer\PHPMailer(true);
  $mail->Mailer   = 'mail';

  # recipients..
  $mail->setFrom('tsadmin@opentradelogistics.com', 'OpenTrade Admin');
  $mail->addAddress($email_id);
  $mail->addReplyTo('tsadmin@opentradelogistics.com','OpenTrade Admin');
  $mail->addBCC('tsadmin@opentradelogistics.com','OpenTrade Admin');

  # server settings to authenticate..
  $mail->DKIM_domain = 'opentradelogistics.com';
  //See the DKIM_gen_keys.phps script for making a key pair -

  # path to private key:
  # $mail->DKIM_private = '/usr/home/delta1/public_html/opentrade/apps/lib/opentrade.opentradelogistics.com.pem';
  $mail->DKIM_private = '/usr/home/delta1/public_html/opentrade/apps/lib/dkim/dkim_private.pem';
  $mail->DKIM_selector = 'opentrade';
  $mail->DKIM_passphrase = null;
  $mail->DKIM_identity = $mail->From;
  $mail->DKIM_copyHeaderFields = false;

  # content..
  $mail->Priority = 1;
  $mail->Subject  =  $subject;
  $mail->WordWrap = 0; # set word wrap
  $mail->Body = $message;

  if(!$mail->Send()) {
    errorHandler('Mail Error', $mail->ErrorInfo(), 0);
    return;
  }
}

