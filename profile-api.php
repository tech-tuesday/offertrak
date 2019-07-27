<?php
# get the values submitted from the website
user_id
email_id
login_pw
first_name
last_name
access_type
agency_id
login_count
bad_login_count
last_login_date
password_modified
active_sw

$login_pw = ( isset($_REQUEST['login_pw']) && validPassword($_REQUEST['login_pw'])) ? $_REQUEST['login_pw']  : null;
$v_login_pw = (isset($_REQUEST['v_login_pw']) && validPassword($_REQUEST['v_login_pw'])) ? $_REQUEST['v_login_pw'] : null;

$event = (isset($_REQUEST['event']) && !empty($_REQUEST['event'])) ? $_REQUEST['event'] : 'new';

# error handling..
$errors = array();
# example..
if ( empty($first_name) ) { $errors[] = 'First Name is required'; }

# handle when this is an update as opposed to a new registration(signup)
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

) values (

)

HereDoc;

$update_sql =<<<HereDoc
update offertrak_users
set

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
    dashboardAPI();

  } else {
    errorHandler(mysqli_error($dbh), $sql);

    # take the user back to the form..
    profileForm();

  }
}

?>
