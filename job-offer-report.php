<?php
$applicant_id = isset($_REQUEST['applicant_id']) ? preg_replace("/\D/",null,$_REQUEST['applicant_id']) : null;

$sql =<<<HereDoc
select
  a.offer_id,
  a.job_id,
  date_format(a.offer_datetime,'%m/%d/%Y') as offer_datetime,
  a.salary_offered,
  a.agency_cost,
  b.job_title,
  b.city_name,
  b.state_cd,
  c.job_category_id_desc
from offertrak_job_offer a
left join offertrak_jobs b on a.job_id = b.job_id
left join offertrak_job_categories c on b.job_category_id = c.job_category_id
where a.applicant_id=$applicant_id

HereDoc;

if ( !$sth = mysqli_query($dbh,$sql) ) { errorHandler(mysqli_error($dbh),$sql); return; }

if ( mysqli_num_rows($sth) > 0 ) {
 
  echo <<<HereDoc
<table class="table table-sm table-hover">
<tr>
  <th>Job</th>
  <th>Location</th>
  <th class="d-none d-lg-md-table-cell text-right pr-5">Salary (USD)</th>
  <th class="d-none d-lg-lg-table-cell text-right pr-5">Costs (USD)</th>
  <th class="d-none d-lg-table-cell">Offer Date</th>
</tr>

HereDoc;

  while ( $row = mysqli_fetch_array($sth) ) {
    foreach ( $row as $key => $val ) {
      $$key = $val;
    }

    $salary_offered_str = number_format($salary_offered,2);
    $agency_cost_str = number_format($agency_cost,2);

    echo <<<HereDoc
<tr class="clickable-row glow" data-href="/offertrak/?w=job_offer_f&amp;offer_id=$offer_id">
  <td>$job_title</td>
  <td>$city_name, $state_cd</td>
  <td class="d-none d-md-table-cell text-right pr-5">$salary_offered_str</td>
  <td class="d-none d-lg-table-cell text-right pr-5">$agency_cost_str</td>
  <td class="d-none d-lg-table-cell">$offer_datetime</td>
</tr>

HereDoc;
  }
  echo <<<HereDoc
</table>

HereDoc;

} else {
  echo <<<HereDoc
<div class="alert alert-warning alert-dismissible fade show">
  There are no job offers for this applicant.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><br/>

HereDoc;
}


