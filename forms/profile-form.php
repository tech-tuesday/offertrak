<form id="profile" method="post" action="/offertrak/" class="needs-validation" novalidate>

<div class="card">
  <div class="card-header">User Profile</div>
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
      <label for="email_id" class="col-md-3 col-form-label">Email ID</label>
      <div class="col-md-9">
        <input type="email" class="form-control" id="email_id" name="email_id" <?php if ($event == "update") { echo "readonly"; } ?> value="<?php echo $email_id; ?>" required/>
        <div class="invalid-feedback">Email is required</div>
      </div>
    </div>

    <?php if ($event == "new") { ?>
    <div class="form-group row">
      <label for="login_pw" class="col-md-3 col-form-label">Set Password</label>
      <div class="col-md-9">
        <input type="password" class="form-control" id="login_pw" name="login_pw" value="" required/>
        <small>8 - 16 characters [with at least 1 lowercase; at least 1 uppercase; at least 1 number; and at least 1 special character]</small>
        <div class="invalid-feedback">Password Requirements: 8 - 16 characters; with at least 1 lowercase; at least 1 uppercase; at least 1 number; and at least 1 special character</div>
      </div>
    </div>

    <div class="form-group row">
      <label for="v_login_pw" class="col-md-3 col-form-label">Verify Password</label>
      <div class="col-md-9">
        <input type="password" class="form-control" id="v_login_pw" name="v_login_pw" placeholder="must match new password above" value="" required/>
        <div class="invalid-feedback">Please type new password here to verify</div>
      </div>
    </div>

    <?php } ?>

    <div class="form-group row">
      <label for="agency_id" class="col-md-3 col-form-label">Agency</label>
      <div class="col-md-9">
        <?php agencyList($agency_id); ?>
        <div class="invalid-feedback">Agency name is required</div>
      </div>
    </div>

  </div>
</div><br/>

<div class="card">
  <div class="card-header"> Review and Submit</div>
  <div class="card-body">
    <div class="form-group">
      <input type="hidden" id="w" name="w" value="profile"/>
      <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>"/>
      <input type="hidden" id="event" name="event" value="<?php echo $event; ?>"/>
      <button type="submit" class="btn btn-success">Continue</button>
    </div>
  </div>
</div>
<br/>

</form>

<?php if ($event == "update") { include_once $_SERVER['DOCUMENT_ROOT'] . '/offertrak/forms/change-password-form.php'; } ?>

