<?php
$email_id = (isset($_REQUEST['email_id'])) ? $_REQUEST['email_id'] : null;
$login_pw = (isset($_REQUEST['login_pw'])) ? $_REQUEST['login_pw'] : null;

# encrypt the password..
$login_pw = md5($login_pw);

# authenticate user..
$sql =<<<HereDoc
select
  user_id,
  access_type,
  concat_ws(' ',first_name,last_name) as app_user,
  date_format(last_login_date,'%m/%d/%Y %r') as last_login_date
from offertrak_users
where email_id = '$email_id'
and login_pw = '$login_pw'
and bad_login_count < 3
and active_sw = 'Y'

HereDoc;

if ( !$sth = mysqli_query($dbh,$sql) ) { errorHandler(mysqli_error($dbh), $sql, 0); return; }

if ( mysqli_num_rows($sth) > 0 ) {

  # reset bad login count if necessary..
  $rsql = "update offertrak_users set bad_login_count = 0 where email_id = '$email_id' limit 1";
  if ( !$rsth = mysqli_query($dbh, $rsql) ) { errorHandler(mysqli_error($dbh), $rsql); return; }

  # get user details..
  $key = 'abchefghjkmnpqrstuvwxyz0123456789';

  while ($row = mysqli_fetch_array($sth)) {
    foreach ($row AS $key => $val) {
      $$key = stripslashes($val);
    }
    $data = serialize($email_id);

    # register session management variables..
    $_SESSION['sid'] = md5($key . $data);
    $_SESSION['access_type'] = $access_type;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['app_user'] = $app_user;
  }

  $sql2 = "update offertrak_users set last_login_date = now(), login_count = login_count+1 where user_id = $user_id limit 1";
  if ( !$sth = mysqli_query($dbh,$sql2) ){ errorHandler(mysqli_error($dbh), $sql2 ); return; }

  # refresh to send user to the dashboard..
  echo <<<HereDoc
  <script>location.replace("/offertrak/");</script>
HereDoc;

} else {
  $fail_message = loginCheck($email_id);
  echo <<<HereDoc
<div class="alert alert-warning alert-dismissible fade show">
Unable to validate credentials.<br/><strong>$fail_message</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><br>
HereDoc;
  loginForm();
}

function loginCheck($email_id) {
  global $dbh;

  # initialize failure message..
  $fail_message = null;

  $sql =<<<HereDoc
select count(*) as 'counter' from offertrak_users where email_id = '$email_id'
HereDoc;

  $counter = fetch_one($sql,'counter');

  if ($counter) {
    # means we found the email_id in the database..
    # update bad login count..
    mysqli_query($dbh,"update offertrak_users set bad_login_count = bad_login_count+1 where email_id='$email_id' limit 1");

    # check threshold..
    $sql = "select bad_login_count from offertrak_users where email_id='$email_id'";

    $bad_login_count = fetch_one($sql,'bad_login_count');

    if ($bad_login_count >=3) {
        return "Account is locked due to too many failed attempts. Please contact OfferTrak Information Security";
    } else {
      $login_attempts_remaining = (3 - $bad_login_count);
      if ($login_attempts_remaining > 0) {
        return "You have $login_attempts_remaining login attempt(s) before account is locked";
      }
    }

  } else {
    # email_id not found in database..
    return "Unknown UserID";
  }
}

?>

