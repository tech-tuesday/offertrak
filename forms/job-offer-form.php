<form id="job-offer" method="post" action="/offertrak/" class="needs-validation" novalidate>
<div class="card" id="joboffer">
  <div class="card-header">Job Offer <small><a class="float-right" href="/offertrak/?w=applicant_f&amp;applicant_id=<?php echo $applicant_id; ?>">View Applicant</a></small></div>
  <div class="card-body">

    <div class="form-group row">
      <label for="job_id" class="col-md-3 col-form-label">Title</label>
      <div class="col-md-9">
        <?php getJobs($job_id); ?> 
        <div class="invalid-feedback">Please select a job</div>
      </div>
    </div>

    <div class="form-group row">
      <label for="salary_offered" class="col-md-3 col-form-label">Salary</label>
      <div class="col-md-9">
        <input type="text" class="form-control" id="salary_offered" name="salary_offered" value="<?php echo $salary_offered; ?>" required/>
        <div class="invalid-feedback">Salary is required</div>
      </div>
    </div>

  </div>
</div><br/>

<div class="card">
  <div class="card-header"> Review and Submit</div>
  <div class="card-body">
    <div class="form-group">
      <input type="hidden" id="w" name="w" value="job_offer"/>
      <input type="hidden" id="offer_id" name="offer_id" value="<?php echo $offer_id; ?>"/>
      <input type="hidden" id="applicant_id" name="applicant_id" value="<?php echo $applicant_id; ?>"/>
      <input type="hidden" id="event" name="event" value="<?php echo $event; ?>"/>
      <button type="submit" class="btn btn-primary">Continue</button>
    </div>
  </div>
</div><br/>

</form>
<?php if ( $offer_id ) { calculateCosts($applicant_id,$salary_offered,$display=1); } ?>

