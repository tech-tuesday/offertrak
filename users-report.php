<?php 
$sql =<<<HereDoc
select
  a.user_id,
  a.email_id,
  a.first_name,
  a.last_name,
  b.agency_name,
  date_format(a.last_login_date,'%m/%d/%Y') as last_login_date,
  date_format(a.password_modified,'%m/%d/%Y') as password_modified,
  a.active_sw
from offertrak_users a
left join offertrak_agencies b on a.agency_id = b.agency_id
order by first_name asc

HereDoc;

if ( !$sth = mysqli_query($dbh,$sql) ) { errorHandler(mysqli_error($dbh), $sql); return; }

if ( mysqli_num_rows($sth) > 0 ) {
  echo <<<HereDoc
<table class="table table-sm table-hover">
<tr>
  <th>Recruiter</th>
  <th class="d-none d-lg-table-cell">Email</th>
  <th class="d-none d-md-table-cell">Agency</th>
  <th class="d-none d-md-table-cell">Latest Login</th>
  <th class="d-none d-lg-table-cell">Password Updated</th>
  <th>Status</th>
</tr>

HereDoc;
} else {
  echo <<<HereDoc
<div class="alert alert-warning alert-dismissible fade show">
  There are no Recruiters in the database.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><br/>
<a class="btn btn-primary col-md-3" role="button" href="/offertrak/?w=applicant_f">Add Recruiter</a>

HereDoc;
  dashboardAPI();
  return;
}

while ( $row = mysqli_fetch_array($sth) ) {
  foreach ( $row as $key => $val ) {
    $$key = $val;
  }
  $active_sw_str = ($active_sw == 'Y') ? 'Active' : 'Locked';
  $row_class = ($active_sw == 'Y') ? null : ' text-danger';

  echo <<<HereDoc
<tr class="clickable-row glow$row_class" data-href="/offertrak/?w=users_f&amp;user_id=$user_id">
  <td>$first_name $last_name</td>
  <td class="d-none d-lg-table-cell">$email_id</td>
  <td class="d-none d-md-table-cell">$agency_name</td>
  <td class="d-none d-md-table-cell">$last_login_date</td>
  <td class="d-none d-lg-table-cell">$password_modified</td>
  <td>$active_sw_str</td>
</tr>

HereDoc;
}

echo <<<HereDoc
</table>

HereDoc;
