<?php
  $page_title = "OfferTrak Inc";
  include_once $_SERVER['DOCUMENT_ROOT'] . '/offertrak/web-assets/tpl/app_header.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/offertrak/web-assets/lib/db.php';
  # include_once $_SERVER['DOCUMENT_ROOT'] . '/offertrak/gateway.php';

  # this line captures the requested "action", it tells us what to do..
  $action = (isset($_REQUEST['w']) ? $_REQUEST['w'] : null);

  $options = array(
    'login_f'       => 'loginForm',
    'login'         => 'loginAPI',
    'logout'        => 'logoutAPI',
    'pw_reset_f'    => 'pwResetForm',
    'pw_reset'      => 'pwResetAPI',
    'change_pw'     => 'changePWAPI',
    'profile_f'     => 'profileForm',
    'profile'       => 'profileAPI',

    'applicant_f'   => 'applicantForm',
    'applicant'     => 'applicantAPI',
    'applicant_r'   => 'applicantReport',
    'job_offer_f'   => 'jobOfferForm',
    'job_offer'     => 'jobOfferAPI',
    'job_offer_r'   => 'jobOfferReport',
    'jobs_r'        => 'jobsReport',
  );

  # check whether we have configured a function for each action we are expecting..

  if (array_key_exists($action, $options)) {
    $function = $options[$action];
    displayHeader();
    call_user_func($function);
  } else {
    if ( !empty($_SESSION['sid']) && !empty($_SESSION['user_id']) && !empty($_SESSION['app_user']) ) {
      dashboardAPI();
    } else {
      loginForm();
    }
  }

  include_once $_SERVER['DOCUMENT_ROOT'] . '/web-assets/tpl/app_footer_class.php';

  function loginForm() {
    global $dbh;
    include_once __DIR__ . '/forms/login-form.php';
  }

  function loginAPI() {
    global $dbh;
    include_once __DIR__ . '/login-api.php';
  }

  function logoutAPI() {
    global $dbh;
    include_once __DIR__ . '/logout-api.php';
  }

  function pwResetForm() {
    global $dbh;
    include_once __DIR__ . '/forms/pw-reset-form.php';
  }

  function pwResetAPI() {
    global $dbh;
    include_once __DIR__ . '/pw-reset-api.php';
  }

  function changePWAPI() {
    global $dbh;
    include_once __DIR__ . '/change-password-api.php';
  }

  function dashboardAPI() {
    global $dbh;
    include_once __DIR__ . '/dashboard.php';
  }

  function profileForm() {
    global $dbh,
      $user_id,
      $email_id,
      $login_pw,
      $first_name,
      $last_name,
      $access_type,
      $agency_id,
      $login_count,
      $bad_login_count,
      $last_login_date,
      $password_modified,
      $active_sw,
      $event;

    $event = (isset($_REQUEST['event']) && !empty($_REQUEST['event'])) ? $_REQUEST['event'] : 'new';

    if ( isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ) {
      $user_id = $_SESSION['user_id'];
      $sql =<<<HereDoc
select
  first_name,
  last_name,
  email_id,
  access_type,
  agency_id,
  'update' as event
from offertrak_users
where user_id=$user_id
HereDoc;

      if ( !$sth = mysqli_query($dbh, $sql) ) { errorHandler(mysqli_error($dbh), $sql, 0); return; }

      if ( mysqli_num_rows($sth) > 0 ) {
        while ($row = mysqli_fetch_array($sth)) {
          foreach ($row AS $key => $val) {
            $$key = stripslashes($val);
          }
        }
      }
    }
    include_once __DIR__ . '/forms/profile-form.php';
  }

  function profileAPI() {
    global $dbh;
    include_once __DIR__ . '/profile-api.php';
  }

  function applicantForm() {
    global $dbh;
    include_once __DIR__ . '/forms/applicant-form.php';
  }

  function applicantAPI() {
    global $dbh;
    include_once __DIR__ . '/applicant-api.php';
  }

  function applicantReport() {
    global $dbh;
    include_once __DIR__ . '/applicant-report.php';
  }

  function jobOfferForm() {
    global $dbh;
    include_once __DIR__ . '/forms/job-offer-form.php';
  }

  function jobOfferAPI() {
    global $dbh;
    include_once __DIR__ . '/job-offer-api.php';
  }

  function jobOfferReport() {
    global $dbh;
    include_once __DIR__ . '/job-offer-report.php';
  }

  function jobsReport() {
    global $dbh;
    include_once __DIR__ . '/jobs-report.php';
  }

  function displayHeader() {
    echo <<<HereDoc
   <div class="card-header mt-0">
    Welcome to OfferTrak Inc

    <ul class="nav float-right">
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-lg fa-handshake white-text"></i> OfferTrack Portal</a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
          <a class="dropdown-item" href="/offertrak/">Dashboard</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/offertrak/?w=applicant_f"><i class="fas fa-user-plus mr-2"></i> Add Applicant</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/offertrak/?w=job_offer_r"><i class="fas fa-user-clock mr-2"></i> Job Offers</a>
          <a class="dropdown-item" href="/offertrak/?w=jobs_r"><i class="fas fa-user-md mr-2"></i> Jobs</a>
          <a class="dropdown-item" href="/offertrak/?w=applicant_r"><i class="fas fa-users mr-2"></i> Applicants</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-lg fa-user"></i> ${_SESSION['app_user']}</a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/offertrak/?w=profile_f">My Profile</a>
          <a class="dropdown-item" href="/offertrak/?w=logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </li>
    </ul>
  </div><br/>
HereDoc;
}
