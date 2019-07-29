<?php
# get the values submitted from the website
$user_id = isset($_REQUEST['user_id']) ? preg_replace("/\D/",null,$_REQUEST['user_id']) : null;
$email_id = isset($_REQUEST['email_id']) ? filter_var($_REQUEST['email_id'], FILTER_SANITIZE_EMAIL) : null;
$first_name = isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : null;
$last_name = isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : null;
$agency_id = isset($_REQUEST['agency_id']) ? preg_replace("/\D/",null,$_REQUEST['agency_id']) : null;
$active_sw = isset($_REQUEST['active_sw']) ? $_REQUEST['active_sw'] : null;
$access_type = isset($_REQUEST['access_type']) ? $_REQUEST['access_type'] : null;

# error handling..
$errors = array();
if ( empty($first_name) ) { $errors[] = 'First Name is required'; }
if ( empty($last_name) ) { $errors[] = 'Last Name is required'; }
if ( empty($email_id) ) { $errors[] = 'Email ID is required'; }
if ( empty($agency_id) && $access_type <> 'A' ) { $errors[] = 'Agency Name is required'; }

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

  usersForm();
  return;
} else {

  # prepare for database..
  $user_id = empty($user_id) ? 'NULL' : $user_id;
  $first_name = empty($first_name) ? 'NULL' : "\"$first_name\"";
  $last_name = empty($last_name) ? 'NULL' : "\"$last_name\"";
  $email_id = empty($email_id) ? 'NULL' : "\"$email_id\"";
  $access_type = empty($access_type) ? 'NULL' : "\"$access_type\"";
  $agency_id = empty($agency_id) ? 'NULL' : $agency_id;
  $active_sw = empty($active_sw) ? 'NULL' : "\"$active_sw\"";

$sql =<<<HereDoc
update offertrak_users
set
  first_name = $first_name,
  last_name = $last_name,
  email_id = $email_id,
  agency_id = $agency_id,
  bad_login_count = 0,
  active_sw = $active_sw,
  lastmod = now()
where user_id = $user_id
limit 1

HereDoc;

  if (mysqli_query($dbh,$sql) && mysqli_affected_rows($dbh) > 0) {

  # remove quotes..
  $first_name = preg_replace("/\"/",null,$first_name);
  $last_name = preg_replace("/\"/",null,$last_name);

    echo <<<HereDoc
<div class="alert alert-success alert-dismissible fade show">
  Profile (<a href="/offertrak/?w=users_f&amp;user_id=$user_id">$first_name $last_name</a>) saved successfully
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

HereDoc;
    dashboardAPI();

  } else {
    errorHandler(mysqli_error($dbh), $sql);

    # take the user back to the form..
    usersForm();
  }
}

?>
