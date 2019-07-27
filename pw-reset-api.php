<?php

# get submitted values..
$email_id = isset($_REQUEST['email_id']) ? filter_var($_REQUEST['email_id'], FILTER_SANITIZE_EMAIL) : null;

if ( empty($email_id) ) {
  echo <<<HereDoc
<div class="alert alert-danger">Valid email required to continue.</div>

HereDoc;
  pwResetForm();
  return;
}

# validate user exists based on provided email..

$sql =<<<HereDoc
select
  email_id,
  login_pw
from offertrak_users
where email_id = '$email_id'

HereDoc;

if ( !$sth = mysqli_query($dbh,$sql) ) { errorHandler(mysqli_error($dbh), $sql); return; }

if ( mysqli_num_rows($sth) > 0 ) {
  # we have a match..

  $new_pw = makeRandompasswd();
  $encrypted_pw = md5($new_pw);

  # update the password in the database..
  $pw_sql =<<<HereDoc
update offertrak_users
set login_pw='$encrypted_pw',
password_modified = now()
where email_id='$email_id'
limit 1

HereDoc;

  if ( !mysqli_query($dbh,$pw_sql) ) { errorHandler(mysqli_error($dbh),$sql); return; }

  while ($row = mysqli_fetch_array($sth) ) {
    foreach ( $row AS $key => $val ) {
      $$key = $val;
    }
  }

  echo <<<HereDoc
<div class="alert alert-warning alert-dismissible fade show">
A new password has been generated. Please check your email in a few minutes for instructions on how to login
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><br>
<pre>
*** In a real-world App, this information is emailed to the user ***
Login ID:   $email_id
New Password: $new_pw
</pre>
HereDoc;


  loginForm();

} else {
  echo <<<HereDoc
<div class="alert alert-danger">Sorry- A user account with that email was not found.</div>

HereDoc;

  pwResetForm();
  return;
}

