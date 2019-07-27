<?php
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


