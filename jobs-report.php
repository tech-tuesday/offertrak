<?php 
$sql =<<<HereDoc
select
  a.job_id,
  a.job_title,
  a.city_name,
  a.state_cd,
  b.job_category_id_desc
from offertrak_jobs a
left join offertrak_job_categories b on a.job_category_id = b.job_category_id

HereDoc;

if ( !$sth = mysqli_query($dbh,$sql) ) { errorHandler(mysqli_error($dbh), $sql); return; }

if ( mysqli_num_rows($sth) > 0 ) {
  echo <<<HereDoc
<table class="table table-sm table-hover">
<tr>
  <th>Job</th>
  <th>Location</th>
  <th>Category</th>
</tr>

HereDoc;
} else {
  echo <<<HereDoc
<div class="alert alert-warning alert-dismissible fade show">
  There are no jobs in the database.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button><br/>
  <a class="card-link" href="/offertrak/?w=jobs_f">Add a Job</a>
</div><br/>

HereDoc;
  dashboardAPI();
  return;
}

while ( $row = mysqli_fetch_array($sth) ) {
  foreach ( $row as $key => $val ) {
    $$key = $val;
  }

  echo <<<HereDoc
<tr class="clickable-row glow" data-href="/offertrak/?w=jobs_f&amp;job_id=$job_id">
  <td>$job_title</td>
  <td>$city_name, $state_cd</td>
  <td>$job_category_id_desc</td>
</tr>

HereDoc;
}

echo <<<HereDoc
</table>

HereDoc;
