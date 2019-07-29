<form id="applicant" method="post" action="/offertrak/" class="needs-validation" novalidate>

<div class="card">
  <div class="card-header">Applicant <?php if ( $applicant_id ) { ?><small><a class="float-right" href="/offertrak/?w=job_offer_f&amp;applicant_id=<?php echo $applicant_id; ?>">Make a Job Offer</a></small><?php } ?></div>
  <div class="card-body">

    <div class="form-group row">
      <label for="first_name" class="col-md-3 col-form-label">First Name</label>
      <div class="col-md-9">
        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required/>
        <div class="invalid-feedback">First Name is required</div>
      </div>
    </div>

    <div class="form-group row">
      <label for="last_name" class="col-md-3 col-form-label">Last</label>
      <div class="col-md-9">
        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required/>
        <div class="invalid-feedback">Last Name is required</div>
      </div>
    </div>

    <div class="form-group row">
      <label for="filing_status_cd" class="col-md-3 col-form-label">Tax Filing Status</label>
      <div class="col-md-9">
        <?php getTaxStatus($filing_status_cd); ?> 
        <div class="invalid-feedback">Tax Filing status is required</div>
      </div>
    </div>

    <div class="form-group row">
      <label for="contact_type_cd" class="col-md-3 col-form-label">Recruitment Source</label>
      <div class="col-md-9">
        <?php getContactType($contact_type_cd); ?> 
        <div class="invalid-feedback">Contact type/method is required</div>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3 col-form-label">Documentation</label>
      <div class="col-md-9">

        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="coverletter_sw" name="coverletter_sw" value="Y" <?php if ($coverletter_sw == 'Y') { echo "checked"; }?>/>
          <label class="form-check-label" for="coverletter_sw">Cover Letter Received?</label> 
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="resume_sw" name="resume_sw" value="Y" <?php if ($resume_sw == 'Y') { echo "checked"; }?>/>
          <label class="form-check-label" for="resume_sw">Resume Received?</label> 
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="reference_sw" name="reference_sw" value="Y" <?php if ($reference_sw == 'Y') { echo "checked"; }?>/>
          <label class="form-check-label" for="reference_sw">References Received?</label> 
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="reference_checked_sw" name="reference_checked_sw" value="Y" <?php if ($reference_checked_sw == 'Y') { echo "checked"; }?>/>
          <label class="form-check-label" for="reference_checked_sw">References Checked?</label> 
        </div>

      </div>
    </div>

  </div>
</div><br/>

<div class="card">
  <div class="card-header"> Review and Submit</div>
  <div class="card-body">
    <div class="form-group">
      <input type="hidden" id="w" name="w" value="applicant"/>
      <input type="hidden" id="applicant_id" name="applicant_id" value="<?php echo $applicant_id; ?>"/>
      <input type="hidden" id="event" name="event" value="<?php echo $event; ?>"/>
      <button type="submit" class="btn btn-success">Continue</button>
    </div>
  </div>
</div><br/>

</form>

<?php if ( $applicant_id ) {
  jobOfferReport();
}
?>

