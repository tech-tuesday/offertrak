<?php
function fetch_one($sql,$str) {
  global $dbh;
  $str_value = null;
  if (!$res = mysqli_query($dbh,$sql)) { errorHandler(mysqli_error($dbh),$sql); return; }

  while ($rec = mysqli_fetch_assoc($res)) { $str_value = $rec[$str]; }
  return $str_value;
}

function errorHandler($str1, $str2, $str3=null) {
  echo <<<HereDoc
<div class="card">
  <div class="card-header bg-danger text-white">Critical Application Error</div>
  <div class="card-body">
    <pre>$str1</pre>
    <div class="alert alert-info"><pre>$str2</pre></div>
  </div>
</div>
<br/>
HereDoc;

  if ($str3) {
    # send mail..
  }
}

function yesnoFlag($flag_name,$flag_sel=null) {
  global $dbh;
  $sql = <<<HereDoc
select
  'Y' as flag,
  'Active' as flag_desc
from dual
union
select
  'N' as flag,
  'Locked' as flag_desc
from dual
HereDoc;

  if (!$sth = mysqli_query($dbh,$sql)) { errorHandler(mysqli_error($dbh),$sql); return; }

  echo <<<HereDoc
<select class="form-control" name="$flag_name" id="$flag_name" required>

HereDoc;

  while ($row = mysqli_fetch_array($sth)) {
    foreach( $row AS $key => $val ){
      $$key = stripslashes($val);
    }
    # capture incoming selected value..
    $selected = ($flag == $flag_sel) ? ' selected' : null;

    echo <<<HereDoc
    <option value="$flag"$selected>$flag_desc</option>

HereDoc;
  }
  echo <<<HereDoc
</select>

HereDoc;
}

function validPassword($candidate) {
  if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $candidate)) {
    return false;
  }
  return true;

  /***
  Explaining $\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$
  $ = beginning of string
  \S* = any set of characters
  (?=\S{8,}) = of at least length 8
  (?=\S*[a-z]) = containing at least one lowercase letter
  (?=\S*[A-Z]) = and at least one uppercase letter
  (?=\S*[\d]) = and at least one number
  (?=\S*[\W]) = and at least a special character (non-word characters)
  $ = end of the string
  ***/
}

function makeRandompasswd() {
  $salt = "abCdefGhJkmNpqRstuvWxyZ23456789!@#$%^&/?+";
  srand((double)microtime()*1000000);
  $i = 0;
  $pass = null;
  while ($i <= 12) {
    $num = rand() % 33;
    $tmp = substr($salt, $num, 1);
    $pass .= $tmp;
    $i++;
  }
  return $pass;
}

function getTaxStatus($filing_status_cd_sel=null) {
  global $dbh;
  $sql = <<<HereDoc
select
  filing_status_cd,
  filing_status_cd_desc
from offertrak_tax_filing_status_types
order by filing_status_cd asc

HereDoc;

  if (!$sth = mysqli_query($dbh,$sql)) { errorHandler(mysqli_error($dbh),$sql); return; }

  echo <<<HereDoc
<select class="form-control" name="filing_status_cd" id="filing_status_cd" required>
  <option value=""></option>
HereDoc;

  while ($row = mysqli_fetch_array($sth)) {
    foreach( $row AS $key => $val ){
      $$key = stripslashes($val);
    }
    # capture incoming selected value..
    $selected = ($filing_status_cd == $filing_status_cd_sel) ? ' selected = "selected"' : null;

    echo <<<HereDoc
    <option value="$filing_status_cd"$selected>$filing_status_cd_desc</option>
HereDoc;
  }
  echo <<<HereDoc
</select>
HereDoc;
}

function getContactType($contact_type_cd_sel=null) {
  global $dbh;
  $sql = <<<HereDoc
select
  contact_type_cd,
  contact_type_cd_desc
from offertrak_contact_types
order by contact_type_cd asc

HereDoc;

  if (!$sth = mysqli_query($dbh,$sql)) { errorHandler(mysqli_error($dbh),$sql); return; }

  echo <<<HereDoc
<select class="form-control" name="contact_type_cd" id="contact_type_cd" required>
  <option value=""></option>
HereDoc;

  while ($row = mysqli_fetch_array($sth)) {
    foreach( $row AS $key => $val ){
      $$key = stripslashes($val);
    }
    # capture incoming selected value..
    $selected = ($contact_type_cd == $contact_type_cd_sel) ? ' selected = "selected"' : null;

    echo <<<HereDoc
    <option value="$contact_type_cd"$selected>$contact_type_cd_desc</option>
HereDoc;
  }
  echo <<<HereDoc
</select>
HereDoc;
}

function getJobCategory($job_category_id_sel=null) {
  global $dbh;
  $sql = <<<HereDoc
select
  job_category_id,
  job_category_id_desc
from offertrak_job_categories
order by job_category_id asc

HereDoc;

  if (!$sth = mysqli_query($dbh,$sql)) { errorHandler(mysqli_error($dbh),$sql); return; }

  echo <<<HereDoc
<select class="form-control" name="job_category_id" id="job_category_id" required>
  <option value=""></option>
HereDoc;

  while ($row = mysqli_fetch_array($sth)) {
    foreach( $row AS $key => $val ){
      $$key = stripslashes($val);
    }
    # capture incoming selected value..
    $selected = ($job_category_id == $job_category_id_sel) ? ' selected = "selected"' : null;

    echo <<<HereDoc
    <option value="$job_category_id"$selected>$job_category_id_desc</option>
HereDoc;
  }
  echo <<<HereDoc
</select>
HereDoc;
}

function selectState($state_cd_sel=null) {
  global $dbh;
  $sql = <<<HereDoc
select
  state_cd,
  state_cd_desc
from offertrak_states
where active_sw = 'Y'
order by state_cd asc
HereDoc;

  if (!$sth = mysqli_query($dbh,$sql)) { errorHandler(mysqli_error($dbh),$sql); return; }

  echo <<<HereDoc
<select class="form-control" name="state_cd" id="state_cd" required>
  <option value=""></option>
HereDoc;

  while ($row = mysqli_fetch_array($sth)) {
    foreach( $row AS $key => $val ){
      $$key = stripslashes($val);
    }
    # capture incoming selected value..
    $selected = ($state_cd == $state_cd_sel) ? ' selected = "selected"' : null;

    echo <<<HereDoc
    <option value="$state_cd"$selected>$state_cd - $state_cd_desc</option>
HereDoc;
  }
  echo <<<HereDoc
</select>
HereDoc;
}

function getJobs($job_id_sel=null) {
  global $dbh;
  $sql = <<<HereDoc
select
  job_id,
  job_title,
  concat_ws(', ',city_name,state_cd) as job_location
from offertrak_jobs
order by job_title asc
HereDoc;

  if (!$sth = mysqli_query($dbh,$sql)) { errorHandler(mysqli_error($dbh),$sql); return; }

  echo <<<HereDoc
<select class="form-control" name="job_id" id="job_id" required>
  <option value=""></option>
HereDoc;

  while ($row = mysqli_fetch_array($sth)) {
    foreach( $row AS $key => $val ){
      $$key = stripslashes($val);
    }
    # capture incoming selected value..
    $selected = ($job_id == $job_id_sel) ? ' selected = "selected"' : null;

    echo <<<HereDoc
    <option value="$job_id"$selected>$job_title - $job_location</option>
HereDoc;
  }
  echo <<<HereDoc
</select>
HereDoc;
}

function agencyList($agency_id_sel=null) {
  global $dbh;
  $sql = <<<HereDoc
select
  agency_id,
  agency_name
from offertrak_agencies
order by agency_name asc
HereDoc;

  if (!$sth = mysqli_query($dbh,$sql)) { errorHandler(mysqli_error($dbh),$sql); return; }

  $required = ( empty($_SESION['access_type']) || $_SESSION['access_type'] == 'R' ) ? ' required' : null;
  echo <<<HereDoc
<select class="form-control" name="agency_id" id="agency_id"$required>
  <option></option>
HereDoc;

  while ($row = mysqli_fetch_array($sth)) {
    foreach( $row AS $key => $val ){
      $$key = stripslashes($val);
    }
    # capture incoming selected value..
    $selected = ($agency_id == $agency_id_sel) ? ' selected = "selected"' : null;

    echo <<<HereDoc
    <option value="$agency_id"$selected>$agency_name</option>
HereDoc;
  }
  echo <<<HereDoc
</select>
HereDoc;
}

function prettyStr($str) {
  # remove special characters..
  $str = preg_replace("/[^\w|\s|\-|`|#|\(|\)|&|\/]/",'',$str);

  $str = strtolower(trim($str));
  $temp_str = array();

  $temp_str = explode('-',$str);
  foreach ($temp_str as &$value) { $value = ucwords($value); }
  $str = implode('-',$temp_str);

  $temp_str = explode('(',$str);
  foreach ($temp_str as &$value) { $value = ucwords($value); }
  $str = implode('(',$temp_str);

  $temp_str = explode('Mc',$str);
  foreach ($temp_str as &$value) { $value = ucwords($value); }
  $str = implode('Mc',$temp_str);

  $temp_str = explode('`',$str);
  foreach ($temp_str as &$value) { $value = ucwords($value); }
  $str = implode('`',$temp_str);
  $str = preg_replace("/`/",'',$str);

  $str = preg_replace('/&/',' & ',$str);
  $str = preg_replace('/\b&\b/',' &amp; ',$str);
  $str = preg_replace("/\(/", ' (',$str);
  $str = preg_replace("/\)/", ') ',$str);
  $str = preg_replace("/\//", ' / ',$str);
  $str = preg_replace("/,/", ', ',$str);
  $str = preg_replace("/\./", '. ',$str);
  $str = preg_replace("/\s+/", ' ', $str);

  $str = trim(ucwords($str));
  $str = preg_replace_callback("/\b(\w{2}[\)]?)$/", function($matches) { return strtoupper($matches[0]); }, $str);
  $str = preg_replace_callback("/^(\w{2}[\)]?)\b/", function($matches) { return strtoupper($matches[0]); }, $str);

  $str = preg_replace("/\bLlc\b/i",'LLC', $str);
  $str = preg_replace("/^(Po Box|P.O. Box|P.O Box)/i", 'PO Box', $str);
  $str = preg_replace("/^apt\b/i", 'Apt', $str);
  $str = preg_replace("/^ste\b/i", 'Ste', $str);
  $str = preg_replace("/\busa\b/i", 'USA', $str);
  $str = preg_replace("/\bdc\b/i", 'DC', $str);
  $str = preg_replace("/\bCT\.?\b/i", 'Court', $str);
  $str = preg_replace("/\bJR\.?\b/i", 'Jr', $str);
  $str = preg_replace("/\bST\.?\b/i", 'St', $str);
  $str = preg_replace("/\bSR\.?\b/i", 'Sr', $str);
  $str = preg_replace("/\bA\b/i", 'a', $str);
  $str = preg_replace("/^a\b/i", 'A', $str);

  # standard address abbreviations..
  $str = preg_replace("/\bDR$/i", 'Dr', $str);
  $str = preg_replace("/\bRD$/i", 'Rd', $str);
  $str = preg_replace("/\bST$/i", 'St', $str);
  $str = preg_replace("/\bne\b/i", 'NE', $str);
  $str = preg_replace("/\bse\b/i", 'SE', $str);
  $str = preg_replace("/\bnw\b/i", 'NW', $str);
  $str = preg_replace("/\bsw\b/i", 'SW', $str);

  $str = preg_replace("/\band\b/i", 'and', $str);
  $str = preg_replace("/\bof\b/i", 'of', $str);

  return $str;
}

function calculateCosts($applicant_id,$salary_offered,$display=null) {
  global $dbh;

  $sql = "select filing_status_cd from offertrak_applicants where applicant_id = $applicant_id";
  $filing_status_cd = fetch_one($sql,'filing_status_cd');

  $sql =<<<HereDoc
select 
  a.tax_rate 
from offertrak_tax_table a
left join (
  select 
    income_range_min, 
    ($salary_offered - income_range_min)
  from offertrak_tax_table
  where filing_status_cd = $filing_status_cd
  and ($salary_offered - income_range_min) > 1
  order by 2 asc
  limit 1
) b on a.income_range_min = b.income_range_min
left join (
  select 
    income_range_max, 
    ($salary_offered - income_range_max)
  from offertrak_tax_table
  where filing_status_cd = $filing_status_cd
  and ($salary_offered - income_range_max) < 1
  order by 2 desc
  limit 1
) c on a.income_range_max = c.income_range_max
where a.filing_status_cd = $filing_status_cd 
and a.income_range_min = b.income_range_min
and a.income_range_max = c.income_range_max

HereDoc;

  $tax_rate = fetch_one($sql,'tax_rate');

  $insurance_cost = $salary_offered * 0.14;
  $workers_comp = $salary_offered * 0.08;
  $recruiter_fees = $salary_offered * 0.11;
  $travel_expenses = 1500;
  $taxes = $salary_offered * $tax_rate/100;

  $agency_costs = ($insurance_cost + $workers_comp + $recruiter_fees + $travel_expenses + $taxes);

  /*
  Insurance costs are 14% of offered salary
  Workers compensation are 8% of offered salary
  Taxes (see Tax Rates in the table below)
  multiply the salary x percentage tax rate to determine the amount of taxes
  Recruiter or agency fees are 11% of the offered salary
  Travel expenses are capped at $1500
  */

  if ($display) {

    $insurance_cost_str = number_format($insurance_cost,2);
    $workers_comp_str = number_format($workers_comp,2);
    $recruiter_fees_str = number_format($recruiter_fees,2);
    $travel_expenses_str = number_format($travel_expenses,2);
    $salary_offered_str = number_format($salary_offered,2);
    $agency_costs_str = number_format($agency_costs,2);
    $taxes_str = number_format($taxes,2);

    echo <<<HereDoc
<div class="card">
  <div class="card-header">Agency Costs Analysis</div>
  <div class="card-body">
  <table class="table table-sm table-hover col-md-4">
    <tr><th>Item</th><th class="text-right pr-5">Cost (USD)</th></tr>
    <tr><td>Salary</td><th class="text-right pr-5">$salary_offered_str</th></tr>
    <tr><td>Insurance</td><td class="text-right pr-5">$insurance_cost_str</td></tr>
    <tr><td>Workers Comp</td><td class="text-right pr-5">$workers_comp_str</td></tr>
    <tr><td>Recruiter Fees</td><td class="text-right pr-5">$recruiter_fees_str</td></tr>
    <tr><td>Travel Expenses</td><td class="text-right pr-5">$travel_expenses_str</td></tr>
    <tr><td>Tax Rate</td><td class="text-right pr-5">$tax_rate %</td></tr>
    <tr><td>Taxes</td><td class="text-right pr-5">$taxes_str</td></tr>
    <tr><th>Total</th><th class="text-right pr-5">$ $agency_costs_str</th></tr>
  </table>
  </div>
</div>

HereDoc;
  } else {
    return $agency_costs;
  }
}



