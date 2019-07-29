<?php
# get submitted values..
$applicant_id = isset($_REQUEST['applicant_id']) ? preg_replace("/\D/",null,$_REQUEST['applicant_id']) : null;
$first_name = isset($_REQUEST['first_name']) ? prettyStr($_REQUEST['first_name']) : null;
$last_name = isset($_REQUEST['last_name']) ? prettyStr($_REQUEST['last_name']) : null;
$filing_status_cd = isset($_REQUEST['filing_status_cd']) ? $_REQUEST['filing_status_cd'] : null;
$contact_type_cd = isset($_REQUEST['contact_type_cd']) ? $_REQUEST['contact_type_cd'] : null;

$coverletter_sw = isset($_REQUEST['coverletter_sw']) ? $_REQUEST['coverletter_sw'] : null;
$resume_sw = isset($_REQUEST['resume_sw']) ? $_REQUEST['resume_sw'] : null;
$reference_sw = isset($_REQUEST['reference_sw']) ? $_REQUEST['reference_sw'] : null;
$reference_checked_sw = isset($_REQUEST['reference_checked_sw']) ? $_REQUEST['reference_checked_sw'] : null;

$event = (isset($_REQUEST['event']) && !empty($_REQUEST['event'])) ? $_REQUEST['event'] : 'new';

# error handling..
$errors = array();

if ( empty($first_name) ) { $errors[] = 'First Name is required'; }
if ( empty($last_name) ) { $errors[] = 'Last Name is required'; }

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

  applicantForm();
  return;
}

# prep for database..
$applicant_id = empty($applicant_id) ? 'NULL' : $applicant_id;
$first_name = empty($first_name) ? 'NULL' : "\"$first_name\"";
$last_name = empty($last_name) ? 'NULL' : "\"$last_name\"";
$filing_status_cd = empty($filing_status_cd) ? 'NULL' : "\"$filing_status_cd\"";
$contact_type_cd = empty($contact_type_cd) ? 'NULL' : "\"$contact_type_cd\"";
$coverletter_sw = empty($coverletter_sw) ? 'NULL' : "\"$coverletter_sw\"";
$resume_sw = empty($resume_sw) ? 'NULL' : "\"$resume_sw\"";
$reference_sw = empty($reference_sw) ? 'NULL' : "\"$reference_sw\"";
$reference_checked_sw = empty($reference_checked_sw) ? 'NULL' : "\"$reference_checked_sw\"";

$add_sql =<<<HereDoc
insert into offertrak_applicants (
  applicant_id,
  first_name,
  last_name,
  filing_status_cd,
  contact_type_cd,
  coverletter_sw,
  resume_sw,
  reference_sw,
  reference_checked_sw,
  lastmod
) values (
  $applicant_id,
  $first_name,
  $last_name,
  $filing_status_cd,
  $contact_type_cd,
  $coverletter_sw,
  $resume_sw,
  $reference_sw,
  $reference_checked_sw,
  now()
)

HereDoc;

$update_sql =<<<HereDoc
update offertrak_applicants
set
  first_name = $first_name,
  last_name = $last_name,
  filing_status_cd = $filing_status_cd,
  contact_type_cd = $contact_type_cd,
  coverletter_sw = $coverletter_sw,
  resume_sw = $resume_sw,
  reference_sw = $reference_sw,
  reference_checked_sw = $reference_checked_sw,
  lastmod = now()
where applicant_id = $applicant_id
limit 1

HereDoc;

$sql = ($event == 'new') ? $add_sql : $update_sql;

if (mysqli_query($dbh,$sql) && mysqli_affected_rows($dbh) > 0) {
  # fetch the id for use in the notification link..
  $applicant_id = ($event == 'new') ? mysqli_insert_id($dbh) : $applicant_id;

  # remove quotes..
  $first_name = preg_replace("/\"/",null,$first_name);
  $last_name = preg_replace("/\"/",null,$last_name);

  echo <<<HereDoc
<div class="alert alert-success alert-dismissible fade show">
  <a href="/offertrak/?w=applicant_f&amp;applicant_id=$applicant_id">$first_name $last_name</a> Application saved successfully
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><br/>

HereDoc;

  dashboardAPI();
} else {
  errorHandler(mysqli_error($dbh), $sql);

  # take the user back to the form..
  applicantForm();
}


