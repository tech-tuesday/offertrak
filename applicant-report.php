<?php 
$sql =<<<HereDoc
select
  a.applicant_id,
  concat_ws(' ',a.first_name, a.last_name) as applicant,
  c.job_title,
  concat_ws(', ',c.city_name,c.state_cd) as location,
  b.salary_offered,
  date_format(b.offer_datetime,'%m/%d/%Y') as offer_datetime
from offertrak_applicants a
left join offertrak_job_offer b on a.applicant_id = b.applicant_id
left join offertrak_jobs c on b.job_id
order by 2 asc

HereDoc;

if ( !$sth = mysqli_query($dbh,$sql) ) { errorHandler(mysqli_error($dbh), $sql); return; }

if ( mysqli_num_rows($sth) > 0 ) {
  echo <<<HereDoc
<table class="table table-sm table-hover">
<tr>
  <th>Applicant</th>
  <th>Job</th>
  <th>Location</th>
  <th>Salary</th>
  <th>Offer Date</th>
</tr>

HereDoc;
} else {
  echo <<<HereDoc
<div class="alert alert-warning alert-dismissible fade show">
  There are no Applicants in the database.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><br/>
<a class="btn btn-primary col-md-3" role="button" href="/offertrak/?w=applicant_f">Add Applicant</a>

HereDoc;
  return;
}

while ( $row = mysqli_fetch_array($sth) ) {
  foreach ( $row as $key => $val ) {
    $$key = $val;
  }

  echo <<<HereDoc
<tr class="clickable-row glow" data-href="/offertrak/?w=applicant_f&amp;applicant_id=$applicant_id">
  <td>$applicant</td>
  <td>$job_title</td>
  <td>$location</td>
  <td>$salary_offered</td>
  <td>$offer_datetime</td>
</tr>

HereDoc;
}

echo <<<HereDoc
</table>

HereDoc;
