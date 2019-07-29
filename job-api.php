<?php

# get submitted values..
$job_id = isset($_REQUEST['job_id']) ? preg_replace("/\D/",null,$_REQUEST['job_id']) : null;
$job_category_id = isset($_REQUEST['job_category_id']) ? preg_replace("/\D/",null,$_REQUEST['job_category_id']) : null;
$job_title = isset($_REQUEST['job_title']) ? prettyStr($_REQUEST['job_title']) : null;
$city_name = isset($_REQUEST['city_name']) ? prettyStr($_REQUEST['city_name']) : null;
$state_cd = isset($_REQUEST['state_cd']) ? $_REQUEST['state_cd'] : null;
$event = (isset($_REQUEST['event']) && !empty($_REQUEST['event'])) ? $_REQUEST['event'] : 'new';

# error handling..
$errors = array();
if ( empty($job_category_id) ) { $errors[] = 'Job category is required'; }
if ( empty($job_title) ) { $errors[] = 'Job Title is required'; }
if ( empty($city_name) ) { $errors[] = 'Job city location is required'; }
if ( empty($state_cd) ) { $errors[] = 'Job State location is required'; }

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

  jobsForm();
  return;
}

# prep for database..
$job_id = empty($job_id) ? 'NULL' : $job_id;
$job_category_id = empty($job_category_id) ? 'NULL' : $job_category_id;
$job_title = empty($job_title) ? 'NULL' : "\"$job_title\"";
$city_name = empty($city_name) ? 'NULL' : "\"$city_name\"";
$state_cd = empty($state_cd) ? 'NULL' : "\"$state_cd\"";

$add_sql =<<<HereDoc
insert into offertrak_jobs (
  job_id,
  job_category_id,
  job_title,
  city_name,
  state_cd,
  lastmod
) values (
  $job_id,
  $job_category_id,
  $job_title,
  $city_name,
  $state_cd,
  now()
)

HereDoc;

$update_sql =<<<HereDoc
update offertrak_jobs
set
  job_category_id = $job_category_id,
  job_title = $job_title,
  city_name = $city_name,
  state_cd = $state_cd,
  lastmod = now()
where job_id = $job_id
limit 1

HereDoc;

$sql = ($event == 'new') ? $add_sql : $update_sql;

if (mysqli_query($dbh,$sql) && mysqli_affected_rows($dbh) > 0) {

  # fetch the id for use in the notification link..
  $job_id = ($event == 'new') ? mysqli_insert_id($dbh) : $job_id;

  # remove quotes..
  $job_title = preg_replace("/\"/",null,$job_title);
  echo <<<HereDoc
<div class="alert alert-success alert-dismissible fade show">
  <a href="/offertrak/?w=jobs_f&amp;job_id=$job_id">$job_title</a> job saved successfully
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><br/>

HereDoc;

  dashboardAPI();
} else {
  errorHandler(mysqli_error($dbh), $sql);

  # take the user back to the form..
  jobsForm();
}


