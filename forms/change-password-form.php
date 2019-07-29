<form id="change_pw" method="post" action="/offertrak/" class="needs-validation" novalidate>

<div class="card">
  <div class="card-header">Change Pasword <small>(optional)</small></div>
  <div class="card-body">

    <div class="form-group row">
      <label for="c_login_pw" class="col-md-3 col-form-label">Current Password</label>
      <div class="col-md-9">
        <input type="password" class="form-control" id="c_login_pw" name="c_login_pw" value="" required/>
        <div class="invalid-feedback">Please enter current login_pw</div>
      </div>
    </div>

    <div class="form-group row">
      <label for="n_login_pw" class="col-md-3 col-form-label">New Password</label>
      <div class="col-md-9">
        <input type="password" class="form-control" id="n_login_pw" name="n_login_pw" value="" required/>
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

    <div class="form-group">
      <input type="hidden" id="w" name="w" value="change_pw"/>
      <input type="hidden" id="email_id" name="email_id" value="<?php echo $email_id; ?>"/>
      <input type="hidden" id="event" name="event" value="update"/>
      <button type="submit" class="btn btn-primary">Update Password</button>
    </div>

  </div>
</div>

</form>
