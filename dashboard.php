<?php
# applicant count..
$sql = "select count(*) as applicant_count from offertrak_applicants";
$applicant_count = fetch_one($sql,'applicant_count');

# job count..
$sql = "select count(*) as job_count from offertrak_jobs";
$job_count = fetch_one($sql,'job_count');

# job offer count..
$sql = "select count(*) as job_offer_count from offertrak_job_offer";
$job_offer_count = fetch_one($sql,'job_offer_count');
?>
<div class="card-deck">

  <div class="card">
    <div class="card-body">
      <h4 class="card-title text-center">APPLICANTS</h4>
      <h1 class="text-center"><a class="card-link" href="/offertrak/?w=applicant_r"><?php echo $applicant_count; ?></a></h1>
    </div>
    <div class="card-footer text-right"><a class="btn btn-sm btn-outline-secondary" href="/offertrak/?w=applicant_f">Add</a></div>
  </div>

  <div class="card">
    <div class="card-body">
      <h4 class="card-title text-center">JOBS</h4>
      <h1 class="text-center"><a class="card-link" href="/offertrak/?w=jobs_r"><?php echo $job_count; ?></a></h1> 
    </div>
    <div class="card-footer text-right"><a class="btn btn-sm btn-outline-secondary" href="/offertrak/?w=jobs_f">Add</a></div>
  </div>

  <div class="card">
    <div class="card-body">
      <h4 class="card-title text-center">JOB OFFERS</h4>
      <h1 class="text-center"><?php echo $job_offer_count; ?></h1> 
    </div>
  </div>

</div>


