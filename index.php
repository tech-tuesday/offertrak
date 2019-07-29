<?php
  error_reporting(E_ALL);
  $page_title = "OfferTrak Inc";
  include_once $_SERVER['DOCUMENT_ROOT'] . '/offertrak/web-assets/tpl/app_header.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/offertrak/web-assets/lib/db.php';

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
     # manage users..
    'users_r'       => 'usersReport',
    'users'         => 'usersAPI',
    'users_f'       => 'usersForm',

    'applicant_f'   => 'applicantForm',
    'applicant'     => 'applicantAPI',
    'applicant_r'   => 'applicantReport',

    'job_offer_f'   => 'jobOfferForm',
    'job_offer'     => 'jobOfferAPI',
    'job_offer_r'   => 'jobOfferReport',

    'jobs_f'        => 'jobsForm',
    'jobs'          => 'jobsAPI',
    'jobs_r'        => 'jobsReport',
  );

  # check whether we have configured a function for each action we are expecting..

  if (array_key_exists($action, $options)) {
    $function = $options[$action];
    call_user_func($function);
  } else {
    if ( !empty($_SESSION['sid']) && !empty($_SESSION['user_id']) && !empty($_SESSION['app_user']) ) {
      dashboardAPI();
    } else {
      loginForm();
    }
  }

  include_once $_SERVER['DOCUMENT_ROOT'] . '/offertrak/web-assets/tpl/app_footer.php';

  function loginForm() {
    global $dbh,
      $email_id,
      $login_pw;
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
    global $dbh, $email_id;
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

  function usersForm() {
    global $dbh,
      $user_id,
      $email_id,
      $first_name,
      $last_name,
      $access_type,
      $agency_id,
      $active_sw;

    if ( isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']) ) {
      $user_id = preg_replace("/\D/",null,$_REQUEST['user_id']);
      $sql =<<<HereDoc
select
  first_name,
  last_name,
  email_id,
  access_type,
  agency_id,
  active_sw
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
    include_once __DIR__ . '/forms/users-form.php';
  }

  function usersAPI() {
    global $dbh;
    include_once __DIR__ . '/users-api.php';
  }
  function usersReport() {
    global $dbh;
    include_once __DIR__ . '/users-report.php';
  }

  function applicantForm() {
    global $dbh,
      $applicant_id,
      $first_name,
      $last_name,
      $filing_status_cd,
      $contact_type_cd,
      $coverletter_sw,
      $resume_sw,
      $reference_sw,
      $reference_checked_sw,
      $offer_id,
      $job_id,
      $salary_offered,
      $event;

    $event = (isset($_REQUEST['event']) && !empty($_REQUEST['event'])) ? $_REQUEST['event'] : 'new';
    $applicant_id = (isset($_REQUEST['applicant_id']) && !empty($_REQUEST['applicant_id'])) ? preg_replace("/\D/",null,$_REQUEST['applicant_id']) : null;

    # if the call is to create a new applicant, applicant_id will be null.
    # otherwise, if applicant_id exists we are probably editing the record..

    if ($applicant_id) {
      $sql =<<<HereDoc
select
  a.first_name,
  a.last_name,
  a.filing_status_cd,
  a.contact_type_cd,
  a.coverletter_sw,
  a.resume_sw,
  a.reference_sw,
  a.reference_checked_sw,
  b.offer_id,
  b.job_id,
  b.salary_offered,
  'update' as event
from offertrak_applicants a
left join offertrak_job_offer b on a.applicant_id = b.applicant_id
where a.applicant_id = $applicant_id

HereDoc;

      if ( !$sth = mysqli_query($dbh,$sql) ) { errorHandler(mysqli_error($dbh), $sql); return; }

      while ( $row = mysqli_fetch_array($sth) ) {
        foreach ( $row as $key => $val ) {
          $$key = $val;
        }
      }
    }
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
    global $dbh,
      $offer_id,
      $applicant_id,
      $job_id,
      $offer_datetime,
      $salary_offered,
      $event;

    $offer_id = (isset($_REQUEST['offer_id']) && !empty($_REQUEST['offer_id'])) ? preg_replace("/\D/",null,$_REQUEST['offer_id']) : null;
    $applicant_id = (isset($_REQUEST['applicant_id']) && !empty($_REQUEST['applicant_id'])) ? preg_replace("/\D/",null,$_REQUEST['applicant_id']) : null;
    $event = (isset($_REQUEST['event']) && !empty($_REQUEST['event'])) ? $_REQUEST['event'] : 'new';

    if ( $offer_id ) {
      $sql =<<<HereDoc
select
  applicant_id,
  job_id,
  offer_datetime,
  salary_offered,
  agency_cost,
  'update' as event
from offertrak_job_offer
where offer_id = $offer_id

HereDoc;

      if ( !$sth = mysqli_query($dbh,$sql) ) { errorHandler(mysqli_error($dbh), $sql); return; }

      while ( $row = mysqli_fetch_array($sth) ) {
        foreach ( $row as $key => $val ) {
          $$key = $val;
        }
      }
    }

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

  function jobsForm() {
    global $dbh,
      $job_id,
      $job_category_id,
      $job_title,
      $city_name,
      $state_cd,
      $event;

    $event = (isset($_REQUEST['event']) && !empty($_REQUEST['event'])) ? $_REQUEST['event'] : 'new';
    $job_id = (isset($_REQUEST['job_id']) && !empty($_REQUEST['job_id'])) ? preg_replace("/\D/",null,$_REQUEST['job_id']) : null;

    # if the call is to create a new job, job_id will be null.
    # otherwise, if job_id exists we are probably editing the record..

    if ($job_id) {
      $sql =<<<HereDoc
select
  job_id,
  job_category_id,
  job_title,
  city_name,
  state_cd,
  'update' as event
from offertrak_jobs
where job_id = $job_id

HereDoc;

      if ( !$sth = mysqli_query($dbh,$sql) ) { errorHandler(mysqli_error($dbh), $sql); return; }

      while ( $row = mysqli_fetch_array($sth) ) {
        foreach ( $row as $key => $val ) {
          $$key = $val;
        }
      }
    }
    include_once __DIR__ . '/forms/job-form.php';
  }

  function jobsAPI() {
    global $dbh;
    include_once __DIR__ . '/job-api.php';
  }
