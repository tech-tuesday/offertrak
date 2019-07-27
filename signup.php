<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/offertrak/tpl/app_header.php';
?>

<div class="row mt-5">
		<div class="col-2"></div>
		<div class="col-8">
				<form action = "index.php" method = "post">

					<h3>Sign Up</h3>
					<div class="card">
						<div class = "form-row">
						<div class="card-body">
							<div class="form-group">
							<label>First Name</label>
							<input class = "form-control" name = "email_id" placeholder = "Enter First Name" >
							</div>
							
							<div class="form-group">
							<label>Last Name</label>
							<input class = "form-control" name = "email_id" placeholder = "Enter Last Name" >
							</div>
							
							<div class="form-group">
							<label>Email</label>
							<input class = "form-control" name = "email_id" placeholder = "Enter Email Address" >
							</div>
							
							<div class="form-group">
							<label>Address</label>
							<input class = "form-control" name = "email_id" placeholder = "Enter Address" >
							</div>
							
							<div class="form-group">
							<label >Password</label>
							<input class = "form-control" name = "loginz_pw" placeholder = "Enter Password">
							</div>
							
							
							<button class = "btn btn-primary" type = "submit" >Submit</button>

						</div>
					</div>
					
				</form>
		</div>
		<div class="col-2"></div>
</div>


<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/offertrak/tpl/app_footer.php';
?>
