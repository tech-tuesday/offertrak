<?php $dbh = new mysqli ('localhost','root', '', 'bdpa_class');

if (!$dbh->error) {
  echo "it worked.";
}
else {
  echo "it didn't work.";
} ?>
