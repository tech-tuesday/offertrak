<?php
session_unset();
session_destroy();
unset($GLOBALS['user_id']);
unset($GLOBALS['app_user']);
unset($GLOBALS['user_type_cd']);

echo <<<HereDoc
<script>location.replace("http://localhost/offertrak/");</script>
<div class="alert alert-warning alert-dismissible fade show">
  Loggged out successfully. For your security, you should now close this browser window.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
HereDoc;

loginForm();
