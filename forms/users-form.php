<form id="users" method="post" action="/offertrak/" class="needs-validation" novalidate>

<div class="card">
  <div class="card-header">Mange User Profile</div>
  <div class="card-body">
    <p class="alert alert-primary">To Activate/Re-Activate a user: Set Status to Active</p>

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
      <label for="email_id" class="col-md-3 col-form-label">Email ID</label>
      <div class="col-md-9">
        <input type="email" class="form-control" id="email_id" name="email_id" readonly value="<?php echo $email_id; ?>" required/>
        <div class="invalid-feedback">Email is required</div>
      </div>
    </div>

    <div class="form-group row">
      <label for="agency_id" class="col-md-3 col-form-label">Agency</label>
      <div class="col-md-9">
        <?php agencyList($agency_id); ?>
        <div class="invalid-feedback">Agency name is required</div>
      </div>
    </div>

    <div class="form-group row">
      <label for="active_sw" class="col-md-3 col-form-label">Status</label>
      <div class="col-md-9">
        <?php yesnoFlag('active_sw',$active_sw); ?>
        <div class="invalid-feedback">Locked/Active Status is required</div>
      </div>
    </div>

  </div>
</div><br/>

<div class="card">
  <div class="card-header"> Review and Submit</div>
  <div class="card-body">
    <div class="form-group">
      <input type="hidden" id="w" name="w" value="users"/>
      <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>"/>
      <input type="hidden" id="access_type" name="access_type" value="<?php echo $access_type; ?>"/>
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
  </div>
</div>

</form>

