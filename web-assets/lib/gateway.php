<?php
if ( empty($_SESSION['sid']) || empty($_SESSION['user_id']) || empty($_SESSION['app_user']) ) {
  echo <<<HereDoc
<div class="alert alert-success alert-dismissible fade show">
  Please login to continue.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div><br/>
HereDoc;

  loginForm();
  include_once $_SERVER['DOCUMENT_ROOT'] . '/offertrak/web-assets/tpl/app_footer.php';
  exit;
}
