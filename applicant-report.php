<?php 
$sql =<<<HereDoc
select
  a.applicant_id,
  concat_ws(' ',a.first_name, a.last_name) as applicant,
  b.filing_status_cd_desc,
  c.contact_type_cd_desc,
  d.job_offers
from offertrak_applicants a
left join offertrak_tax_filing_status_types b on a.filing_status_cd = b.filing_status_cd
left join offertrak_contact_types c on a.contact_type_cd = c.contact_type_cd
left join (
  select
    applicant_id,
    count(*) as job_offers
  from offertrak_job_offer
  group by applicant_id
) d on a.applicant_id = d.applicant_id
order by 2 asc

HereDoc;

if ( !$sth = mysqli_query($dbh,$sql) ) { errorHandler(mysqli_error($dbh), $sql); return; }

if ( mysqli_num_rows($sth) > 0 ) {
  echo <<<HereDoc
<table class="table table-sm table-hover container">
<tr>
  <th>Applicant</th>
  <th>Tax Filing Status</th>
  <th>Recruiting Source</th>
  <th>Job Offers</th>
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
  <td>$filing_status_cd_desc</td>
  <td>$contact_type_cd_desc</td>
  <td>$job_offers</td>
</tr>

HereDoc;
}

echo <<<HereDoc
</table>

HereDoc;
