<form id="jobs" method="post" action="/offertrak/" class="needs-validation" novalidate>

<div class="card">
  <div class="card-header">Job</div>
  <div class="card-body">

    <div class="form-group row">
      <label for="job_title" class="col-md-3 col-form-label">Title</label>
      <div class="col-md-9">
        <input type="text" class="form-control" id="job_title" name="job_title" value="<?php echo $job_title; ?>" required/>
        <div class="invalid-feedback">Job Title is required</div>
      </div>
    </div>

    <div class="form-group row">
      <label for="job_category_id" class="col-md-3 col-form-label">Category</label>
      <div class="col-md-9">
        <?php getJobCategory($job_category_id); ?> 
        <div class="invalid-feedback">Job Category is required</div>
      </div>
    </div>

    <div class="form-group row">
      <label for="city_name" class="col-md-3 col-form-label">City</label>
      <div class="col-md-9">
        <input type="text" class="form-control" id="city_name" name="city_name" value="<?php echo $city_name; ?>" required/>
        <div class="invalid-feedback">City is required</div>
      </div>
    </div>

    <div class="form-group row">
      <label for="state_cd" class="col-md-3 col-form-label">State</label>
      <div class="col-md-9">
         <?php selectState($state_cd); ?>
        <div class="invalid-feedback">State is required</div>
      </div>
    </div>

  </div>
</div><br/>

<div class="card">
  <div class="card-header"> Review and Submit</div>
  <div class="card-body">
    <div class="form-group">
      <input type="hidden" id="w" name="w" value="jobs"/>
      <input type="hidden" id="user_id" name="job_id" value="<?php echo $job_id; ?>"/>
      <input type="hidden" id="event" name="event" value="<?php echo $event; ?>"/>
      <button type="submit" class="btn btn-success">Continue</button>
    </div>
  </div>
</div>

</form>

