<?php
# get the values submitted from the website
$first_name = isset($_REQUEST['first_name']) ? prettyStr($_REQUEST['first_name']) : null;
$middle_name = isset($_REQUEST['middle_name']) ? prettyStr($_REQUEST['middle_name']) : null;
$last_name = isset($_REQUEST['last_name']) ? prettyStr($_REQUEST['last_name']) : null;
$email_id = isset($_REQUEST['email_id']) ? filter_var($_REQUEST['email_id'], FILTER_SANITIZE_EMAIL) : null;
$pri_phone = isset($_REQUEST['pri_phone']) ? preg_replace("/\D/",null,$_REQUEST['pri_phone']) : null;
$user_type_cd = isset($_REQUEST['user_type_cd']) ? preg_replace("/\D/",null,$_REQUEST['user_type_cd']) : null;
$industry_type_cd = isset($_REQUEST['industry_type_cd']) ? prettyStr($_REQUEST['industry_type_cd']) : null;

$login_pw = ( isset($_REQUEST['login_pw']) && validPassword($_REQUEST['login_pw'])) ? $_REQUEST['login_pw']  : null;
$v_login_pw = (isset($_REQUEST['v_login_pw']) && validPassword($_REQUEST['v_login_pw'])) ? $_REQUEST['v_login_pw'] : null;

$event = (isset($_REQUEST['event']) && !empty($_REQUEST['event'])) ? $_REQUEST['event'] : 'new';

# error handling..
$errors = array();
if ( empty($first_name) ) { $errors[] = 'First Name is required'; }
if ( empty($last_name) ) { $errors[] = 'Last name is required'; }
if ( empty($email_id) ) { $errors[] = 'Email is required'; }
if ( empty($pri_phone) ) { $errors[] = 'Phone number is required'; }

if ( $event == 'new' && empty($login_pw) ) { $errors[] = "Valid Password is required (8-16 alphanumeric/special characters)"; }

if ( $login_pw <> $v_login_pw ) { $errors[] = "Verification password is missing / or does not match new password"; }

# now check whether we have errors..
if (count($errors)) {

  echo <<<HereDoc
  <div class="card">
  <div class="card-header bg-warning text-white">Please review the following:</div>
  <div class="card-body">
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

  include_once __DIR__ . '/forms/profile-form.php';
  return;
} else {

  # encrypt the passwords..
  $login_pw = md5($login_pw);
  $v_login_pw = md5($v_login_pw);

  # prepare for database..
  $user_id = empty($user_id) ? 'NULL' : $user_id;
  $first_name = empty($first_name) ? 'NULL' : "\"$first_name\"";
  $middle_name = empty($middle_name) ? 'NULL' : "\"$middle_name\"";
  $last_name = empty($last_name) ? 'NULL' : "\"$last_name\"";
  $email_id = empty($email_id) ? 'NULL' : "\"$email_id\"";
  $login_pw = empty($login_pw) ? 'NULL' : "\"$login_pw\"";
  $pri_phone = empty($pri_phone) ? 'NULL' : "\"$pri_phone\"";
  $user_type_cd = empty($user_type_cd) ? 'NULL' : $user_type_cd;
  $industry_type_cd = empty($industry_type_cd) ? 'NULL' : "\"$industry_type_cd\"";

  # SQL to save the data
  $add_sql =<<<HereDoc
insert into offertrak_users (
  user_id,
  user_type_cd,
  access_level_cd,
  industry_type_cd,
  email_id,
  login_pw,
  last_login_date,
  login_count,
  bad_login_count,
  password_modified,
  first_name,
  middle_name,
  last_name,
  pri_phone,
  lastmod
) values (
  $user_id,
  $user_type_cd,
  3,
  $industry_type_cd,
  $email_id,
  $login_pw,
  null,
  0,
  0,
  null,
  $first_name,
  $middle_name,
  $last_name,
  $pri_phone,
  now()
)

HereDoc;

$update_sql =<<<HereDoc
update offertrak_users
set
  first_name   = $first_name,
  middle_name  = $middle_name,
  last_name    = $last_name,
  pri_phone    = $pri_phone,
  lastmod      = now()
where user_id = $user_id
limit 1

HereDoc;

  $sql = ($event == 'new') ? $add_sql : $update_sql;

  if (mysqli_query($dbh,$sql) && mysqli_affected_rows($dbh) > 0) {
    $user_id = ($event == 'new') ? mysqli_insert_id($dbh) : $user_id;

    echo <<<HereDoc
<div class="alert alert-success alert-dismissible fade show">
  Profile information saved successfully
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

HereDoc;
    notifyOpenTrade($user_id);
    navigatorAPI($user_type_cd);

  } else {
    errorHandler(mysqli_error($dbh), $sql);

    # take the user back to the form..
    profileForm();

  }
}

function notifyOpenTrade($user_id) {
  global $dbh;

  $sql =<<<HereDoc
select
  a.email_id,
  a.first_name,
  a.middle_name,
  a.last_name,
  a.pri_phone,
  b.user_type_cd_desc
from offertrak_users a
left join offertrak_user_types b on a.user_type_cd = b.user_type_cd
where a.user_id = $user_id

HereDoc;

  if ( !$sth = mysqli_query($dbh,$sql) ) { errorHandler(mysqli_error($dbh), $sql, 0); return; }

  while ( $row = mysqli_fetch_array($sth) ) {
    foreach ( $row as $key => $val ) {
      $$key = $val;
    }
    $pri_phone = formatPhone($pri_phone);
  }

  $host_ip = $_SERVER['REMOTE_ADDR'];
  $host_address = gethostbyaddr($host_ip);
  $browser_app = $_SERVER['HTTP_USER_AGENT'];

  $subject = "Profile Updated";
  $message =<<<HereDoc
$first_name $middle_name $last_name
$user_type_cd_desc
$email_id
$pri_phone

*** ALERT ***
Profile Created/Updated.

This is to confirm that you recently created or updated your profile on Open Trade Logistics Platform.
If this is intentional --no further action is necessary, otherwise please contact Open Trade Logistics.

Details:
IP: $host_ip
HOST: $host_address
Browser: $browser_app


Thank You.

Account Services,
Open Trade Logistics
www.opentradelogistics.com
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
  # $mail->DKIM_private = '/usr/home/delta1/public_html/opentrade/apps/lib/google.opentradelogistics.com.pem';
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

?>
