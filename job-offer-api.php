<?php
# get submitted values..
$offer_id = isset($_REQUEST['offer_id']) ? preg_replace("/\D/",null,$_REQUEST['offer_id']) : null;
$job_id = isset($_REQUEST['job_id']) ? preg_replace("/\D/",null,$_REQUEST['job_id']) : null;
$applicant_id = isset($_REQUEST['applicant_id']) ? preg_replace("/\D/",null,$_REQUEST['applicant_id']) : null;
$salary_offered = isset($_REQUEST['salary_offered']) ? floatval($_REQUEST['salary_offered']) : null;
$event = (isset($_REQUEST['event']) && !empty($_REQUEST['event'])) ? $_REQUEST['event'] : 'new';

# prepare for database..
$offer_id = empty($offer_id) ? 'NULL' : $offer_id;
$applicant_id = empty($applicant_id) ? 'NULL' : $applicant_id;
$job_id = empty($job_id) ? 'NULL' : $job_id;
$salary_offered = empty($salary_offered) ? 'NULL' : $salary_offered;
$agency_cost = calculateCosts($applicant_id,$salary_offered);

$add_sql =<<<HereDoc
insert into offertrak_job_offer (
  offer_id,
  applicant_id,
  job_id,
  offer_datetime,
  salary_offered,
  agency_cost,
  lastmod
) values (
  $offer_id,
  $applicant_id,
  $job_id,
  now(),
  $salary_offered,
  $agency_cost,
  now()
)

HereDoc;

$update_sql =<<<HereDoc
update offertrak_job_offer
set
  job_id = $job_id,
  salary_offered = $salary_offered,
  agency_cost = $agency_cost,
  lastmod = now() 
where offer_id = $offer_id
limit 1

HereDoc;

$sql = ($event == 'new') ? $add_sql : $update_sql;

if (mysqli_query($dbh,$sql) && mysqli_affected_rows($dbh) > 0) {
  # fetch the id for use in the notification link..
  $offer_id = ($event == 'new') ? mysqli_insert_id($dbh) : $offer_id;

  echo <<<HereDoc
<div class="alert alert-success alert-dismissible fade show">
  <a href="/offertrak/?w=job_offer_f&amp;offer_id=$offer_id">Job offer</a> saved successfully
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><br/>

HereDoc;

  applicantReport();
} else {
  errorHandler(mysqli_error($dbh), $sql);

  # take the user back to the form..
  jobOfferForm();
}

