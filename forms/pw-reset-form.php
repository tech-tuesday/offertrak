<form id="pw_reset" method="post" action="/offertrak/" class="needs-validation" novalidate>
  <div class="card">
    <div class="card-header">Password Reset</div>
    <div class="card-body">
      <div class="alert alert-primary">Enter your email below to request a password reset</div>
      <div class="form-group">
        <div class= "input-group mx-auto mb-3 col-md-9">
          <div class="input-group-prepend"><span class="input-group-text">Email</div>
          <input type="email" class="form-control" id="email_id" name="email_id" value="<?php echo $email_id; ?>" required>
          <div class="invalid-feedback">Valid Email ID is required</div>
        </div>
      </div>

      <div class="form-group">
        <div class= "col-md-9 mx-auto">
          <input id="w" type="hidden" name="w" value="pw_reset"/>
          <button type="submit" class="btn btn-sm btn-primary">Reset Password</button>
          <a class="btn btn-sm btn-outline-primary float-right" href="/offertrak/?w=login_f">Login</a>
        </div>
      </div>

    </div>
  </div>
</form>
