<div class="collapse navbar-collapse" id="navbarCollapse">
<ul class="navbar-nav ml-auto mr-5">
  <li class="nav-item dropdown active">
    <a class="nav-link dropdown-toggle" href="#" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Navigator</a>
    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
      <a class="dropdown-item" href="/offertrak/">Dashboard</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="/offertrak/?w=applicant_f">Add Applicant</a>
      <a class="dropdown-item" href="/offertrak/?w=jobs_f">Add Job</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="/offertrak/?w=jobs_r">Jobs</a>
      <a class="dropdown-item" href="/offertrak/?w=applicant_r">Applicants</a>
      <?php if ( $_SESSION['access_type'] == 'A' ) { ?>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="/offertrak/?w=users_r">Manage Users</a>
      <?php } ?>
    </div>
  </li>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle ml-auto" href="#" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['app_user']; ?></a>

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
      <a class="dropdown-item" href="/offertrak/?w=profile_f">My Profile</a>
      <a class="dropdown-item" href="/offertrak/?w=logout">Logout</a>
    </div>
  </li>
</ul>
</div>
