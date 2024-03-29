<form id="login" method="post" action="/offertrak/" autocomplete="false" class="needs-validation" novalidate>
  <div class="jumbotron">
  <div class="card">
    <div class="card-header">Welcome to OfferTrak Inc</div>
    <div class="card-body">
      <div class="form-group">
        <label for="email_id" class="col-md-2 col-form-label">Email ID</label>
        <div class="col-md-9">
          <input type="email" class="form-control" id="email_id" name="email_id" autocomplete="off" value="<?php echo $email_id; ?>" required>
          <div class="invalid-feedback">Email ID is required</div>
        </div>
      </div>

      <div class="form-group">
        <label for="login_pw" class="col-md-2 col-form-label">Password</label>
        <div class="col-md-9">
          <input type="password" class="form-control" id="login_pw" name="login_pw" autocomplete="off" required>
          <div class="invalid-feedback">Password is required</div>
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-9">
          <input id="w" type="hidden" name="w" value="login"/>
          <button type="submit" class="btn btn-success">Login</button>
          <a href="/offertrak/?w=pw_reset_f">Forgot Password?</a> |
          <a href="/offertrak/?w=profile_f">Register</a>
        </div>
      </div>

    </div>
  </div>
  </div>
</form><br/>

