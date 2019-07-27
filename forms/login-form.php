<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/offertrak/tpl/app_header.php';
?>

<div class="row mt-5">
		<div class="col-2"></div>
		<div class="col-8">
				<form action = "index.php" method = "post">

					<h3>Login</h3>
					<div class="card">
						<div class="card-body">
							<div class="form-group">
							<label>Email Address</label>
							<input class = "form-control" name = "email_id" placeholder = "Enter Email Address" >
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
